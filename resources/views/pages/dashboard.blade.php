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
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">


                            <div class="card-body">
                                <h5 class="card-title">Total Balance</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$total_balance}}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="card-body">
                                <h5 class="card-title">Total Budget</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{$total_budget}}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">


                            <div class="card-body">
                                <h5 class="card-title">Total Roles</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-download"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><a href="{{ route('generate.report') }}" class="btn btn-primary">Generate Report</a>
                                            </h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Available Budget Table</h5>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Budget Amount</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title">Recent Expenses Table</h5>
                </div>

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


        </div>


    </section>
</main>

