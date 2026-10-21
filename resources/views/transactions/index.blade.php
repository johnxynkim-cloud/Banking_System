<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction History</title>
</head>
<body>
    <h1>Banking System - Transactions</h1>

    <a href="{{ route('transactions.create') }}">Make a New Transaction</a> | 
    <a href="{{ url('/dashboard') }}">View Dashboard</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <table border="1" cellpadding="10" style="margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Account Number</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Reference Number</th>
                <th>Notes</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $tx)
                <tr>
                    <td>{{ $tx->id }}</td>
                    <td>{{ $tx->account->account_number ?? 'N/A' }}</td>
                    <td>{{ ucfirst($tx->type) }}</td>
                    <td>${{ number_format($tx->amount, 2) }}</td>
                    <td>{{ $tx->reference_number }}</td>
                    <td>{{ $tx->notes }}</td>
                    <td>{{ $tx->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $transactions->links() }}
    </div>
</body>
</html>