<!-- resources/views/pdf/report.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Expense Report</title>
</head>
<body>
<h1>Expense Report</h1>

<p>Total Income: ${{ $totalIncome }}</p>
<p>Total Expenses: ${{ $totalExpenses }}</p>

<h2>Category Reports</h2>
<ul>
    @foreach($categoryReports as $categoryReport)
        <li>
            <strong>{{ $categoryReport['category'] }}</strong>:
            Total Budget: ${{ $categoryReport['total_budget'] }},
            Total Spent: ${{ $categoryReport['total_spent'] }}
        </li>
    @endforeach
</ul>
</body>
</html>
