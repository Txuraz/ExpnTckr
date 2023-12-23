<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $budgets = $user->budgets()->with('category')->get();
        $categories = Category::all();

        return view('pages.budget', compact('budgets', 'categories'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'category' => 'required|exists:categories,id',  // Update the field name to match the form
            'budget_amount' => 'required|numeric|min:0',
            'budget_start_date' => 'required|date',
            'budget_end_date' => 'required|date|after_or_equal:budget_start_date',
        ]);

        $user = Auth::user();

        $budget = new Budget();
        $budget->category_id = $request->category;
        $budget->amount = $request->budget_amount;
        $budget->start_date = $request->budget_start_date;
        $budget->end_date = $request->budget_end_date;

        $user->budgets()->save($budget);

        return redirect()->back()->with('success', 'Budget Added successfully!');

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_budget_amount' => 'required|numeric',
            'edit_budget_start_date' => 'required|date',
            'edit_budget_end_date' => 'required|date|after:edit_budget_start_date',
        ]);

        $budget = Budget::findOrFail($id);
        $budget->update([
            'amount' => $request->input('edit_budget_amount'),
            'start_date' => $request->input('edit_budget_start_date'),
            'end_date' => $request->input('edit_budget_end_date'),
        ]);

        // You can add a success message or redirect as needed
        return redirect()->back()->with('success', 'Budget updated successfully');
    }

    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();

        return redirect()->back()->with('success', 'Budget deleted successfully');
    }


}
