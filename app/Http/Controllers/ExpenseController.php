<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use TCPDF;



class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $user = Auth::user();

        $query = Expense::where('user_id', $user->id)->with('category');

        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $category = $request->input('categories');
        $type = $request->input('type');

        if ($fromDate) {
            $query->where('date', '>=', $fromDate);
        }

        if ($toDate) {
            $query->where('date', '<=', $toDate);
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($category) {
            $query->where('category_id', $category);
        }


        $expenses = $query->paginate(5);

        $total_income = $expenses->where('type', 'income')->sum('amount');
        $total_expenses = $expenses->where('type', 'expense')->sum('amount');
        $total_balance = $total_income - $total_expenses;

        return view('pages.expense', compact('categories', 'total_expenses', 'total_balance', 'total_income', 'expenses', 'request'));
    }



    public function create()
    {
        return view('pages.expense');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category' => 'required',
            'type' => 'required|in:expense,income',
            'notes' => 'required',
            'date' => 'required|date',
        ],
            [
                'amount.min' => 'The amount must be greater than 0.',
            ]);

        $user = Auth::user();
        $expense = $user->expenses()->create([
            'category_id' => $request->category,
            'type' => $request->type,
            'amount' => $request->amount,
            'notes' => $request->notes,
            'date' => $request->date,
        ]);

        $budget = Budget::where('category_id', $request->category)
            ->where('end_date', '>=', $request->date)
            ->first();

        if ($budget && $budget->amount < $expense->amount) {
            Session::flash('warning', 'Warning: You have exceeded the budget for the selected category!');
        }

        return redirect()->back()->with('success', 'Expense added successfully!');
    }


    public function generateReport()
    {
        $user = Auth::user();

        // Calculate total income
        $totalIncome = $user->expenses()->where('type', 'income')->sum('amount');

        // Calculate total expenses
        $totalExpenses = $user->expenses()->where('type', 'expense')->sum('amount');

        // Get budget information
        $budgets = $user->budgets()->with('category')->get();

        // Get categories and their expenses
        $categories = Category::with(['expenses' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        // Calculate total budget and total spent for each category
        $categoryReports = [];
        foreach ($categories as $category) {
            $totalBudget = $budgets->where('category_id', $category->id)->sum('amount');
            $totalSpent = $category->expenses->sum('amount');

            $categoryReports[] = [
                'category' => $category->name,
                'total_budget' => $totalBudget,
                'total_spent' => $totalSpent,
            ];
        }

        // Create new TCPDF instance
        $pdf = new TCPDF();

        // View the PDF content
        $pdf->AddPage();
        $pdf->SetFont('times', 'B', 12);
        $pdf->Cell(0, 10, 'Expense Report', 0, 1, 'C');

        // Output the data to the PDF
        foreach ($categoryReports as $report) {
            $pdf->Cell(0, 10, $report['category'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Total Budget: ' . $report['total_budget'], 0, 1, 'L');
            $pdf->Cell(0, 10, 'Total Spent: ' . $report['total_spent'], 0, 1, 'L');
            $pdf->Ln();
        }

        $pdf->Cell(0, 10, 'Total Income: ' . $totalIncome, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Total Expenses: ' . $totalExpenses, 0, 1, 'L');
        $pdf->Cell(0, 10, 'Total Balance: ' . ($totalIncome - $totalExpenses), 0, 1, 'L');

        // Save PDF to a temporary file
        $pdfFilePath = storage_path('app/public/report.pdf');
        $pdf->Output($pdfFilePath, 'F');

        // Download the PDF
        return response()->download($pdfFilePath, 'report.pdf');
    }
}
