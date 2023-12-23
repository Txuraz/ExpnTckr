<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();


        $expenses = Expense::where('user_id', $user->id);

        $budgets = $user->budgets()->with('category')->get();

        $total_budget = $budgets->sum('amount');


        $total_income = $expenses->where('type', 'income')->sum('amount');
        $total_expenses = $expenses->where('type', 'expense')->sum('amount');
        $total_balance = $total_income - $total_expenses;
        return view('pages.dashboard', compact('total_expenses', 'total_balance', 'total_income', 'expenses', 'budgets', 'total_budget' ));
    }
}
