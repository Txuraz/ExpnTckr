@extends('layouts.app')
@section('title', 'Dashboard')
@include('components.navbar')
@include('components.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Category Table</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Total Expenses Table</h5>
                    <div class="d-flex">
                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
                            Add Expense
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            Filter
                        </button>
                       <a href="{{route('user.expenses')}}"> <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            Clear Filter
                        </button></a>
                    </div>
                </div>
                @if($request->filled('fromDate') || $request->filled('toDate') || $request->filled('categories') || $request->filled('type'))
                    <div class="mb-4">
                        <p>Filter Details:</p>
                        <ul>
                            @if($request->filled('fromDate'))
                                <li><strong>From Date:</strong> {{ $request->input('fromDate') }}</li>
                            @endif
                            @if($request->filled('toDate'))
                                <li><strong>To Date:</strong> {{ $request->input('toDate') }}</li>
                            @endif
                            @if($request->filled('categories'))
                                <li><strong>Category:</strong> {{ $categories->where('id', $request->input('categories'))->first()->name }}</li>
                            @endif
                            @if($request->filled('type'))
                                <li><strong>Type:</strong> {{ ucfirst($request->input('type')) }}</li>
                            @endif
                        </ul>
                    </div>
                @endif

                @if(Session::has('warning'))
                    <div class="alert alert-warning">
                        {{ Session::get('warning') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Category</th>
                        <th scope="col">Type</th>
                        <th scope="col">Notes</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$expense->date}}</td>
                            <td>{{$expense->category->name}}</td>
                            <td>{{$expense->type}}</td>
                            <td>{{$expense->notes}}</td>
                            <td>{{$expense->amount}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Income</h5>
                        <p class="card-text">{{$total_income}}</p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Total Expenses</h5>
                        <p class="card-text">{{$total_expenses}}</p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Total Balance</h5>
                        <p class="card-text">{{$total_balance}}</p>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Charts</h5>
                        <!-- Add your chart components here for total income, expenses, and balance -->
                        <!-- Example: <canvas id="totalIncomeChart"></canvas> -->
                    </div>
                </div>
            </div>
        </div>




    <!-- Filter Modal -->
        <!-- Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Filter Expenses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('filter.expense') }}" method="get"> <!-- Wrap the form around filter elements -->
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="fromDate" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="fromDate" name="fromDate">
                            </div>
                            <div class="mb-3">
                                <label for="toDate" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="toDate" name="toDate">
                            </div>
                            <div class="mb-3">
                                <label for="categories" class="form-label">Categories</label>
                                <select class="form-control" id="categories" name="categories">
                                    <option></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option></option>
                                    <option value="expense">expense</option>
                                    <option value="income">income</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('expense.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                            @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">--Select Category--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="expense">Expense</option>
                                <option value="income">Income</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" required>{{ old('notes') }}</textarea>
                            @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
                            @error('date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add Expense</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </section>
</main>

