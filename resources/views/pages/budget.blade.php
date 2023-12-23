@extends('layouts.app')
@section('title', 'Budget Management')
@include('components.navbar')
@include('components.sidebar')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Budget Management</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Budget Table</h5>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
                        Add Budget
                    </button>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Budget Amount</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($budgets as $budget)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $budget->category->name }}</td>
                            <td>{{ $budget->amount }}</td>
                            <td>{{ $budget->start_date }}</td>
                            <td>{{ $budget->end_date }}</td>
                           <td> <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBudgetModal{{ $budget->id }}">
                                   Edit
                               </button>
                               <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteBudgetModal{{ $budget->id }}">
                                   Delete
                               </button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @foreach($budgets as $budget)
                <div class="modal fade" id="editBudgetModal{{ $budget->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Budget</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{route('budget.update', $budget->id)}}" method="post">
                                @csrf
                                @method('patch') <!-- Use the appropriate HTTP method for updating -->
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit_budget_amount" class="form-label">Budget Amount</label>
                                        <input type="number" name="edit_budget_amount" id="edit_budget_amount" class="form-control" value="{{ $budget->amount }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_budget_start_date" class="form-label">Start Date</label>
                                        <input type="date" name="edit_budget_start_date" id="edit_budget_start_date" class="form-control" value="{{ $budget->start_date }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_budget_end_date" class="form-label">End Date</label>
                                        <input type="date" name="edit_budget_end_date" id="edit_budget_end_date" class="form-control" value="{{ $budget->end_date }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Budget</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Budget Modal -->
                <div class="modal fade" id="deleteBudgetModal{{ $budget->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this budget?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{route('budget.delete', $budget->id)}}" method="post">
                                    @csrf
                                    @method('DELETE') <!-- Use the appropriate HTTP method for deletion -->
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            <div class="modal fade" id="deleteBudgetModal{{ $budget->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this budget?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="" method="post">
                                @csrf
                                @method('DELETE') <!-- Use the appropriate HTTP method for deletion -->
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- Add Budget Modal -->
            <div class="col-lg-4">
                <div class="modal fade" id="addBudgetModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Budget</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{route('budget.store')}}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" id="category" class="form-control" required>
                                            <option value="">--Select Category--</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="budget_amount" class="form-label">Budget Amount</label>
                                        <input type="number" name="budget_amount" id="budget_amount" class="form-control" value="{{ old('budget_amount') }}" required>
                                        @error('budget_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="budget_start_date" class="form-label">Start Date</label>
                                        <input type="date" name="budget_start_date" id="budget_start_date" class="form-control" value="{{ old('budget_start_date') }}" required>
                                        @error('budget_start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="budget_end_date" class="form-label">End Date</label>
                                        <input type="date" name="budget_end_date" id="budget_end_date" class="form-control" value="{{ old('budget_end_date') }}" required>
                                        @error('budget_end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Budget</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
