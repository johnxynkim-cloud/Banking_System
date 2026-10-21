<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Transaction</title>
</head>
<body>
    <h1>Process a Transaction</h1>

    <a href="{{ route('transactions.index') }}">Back to Transactions</a> | 
    <a href="{{ url('/dashboard') }}">View Dashboard</a>

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST" style="margin-top: 20px;">
        @csrf
        
        <div>
            <label>Select Account:</label><br>
            <select name="account_id" required>
                @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}">Account: {{ $acc->account_number }} (Balance: ${{ $acc->balance }})</option>
                @endforeach
            </select>
        </div>
        <br>

        <div>
            <label>Transaction Type:</label><br>
            <select name="type" required>
                <option value="deposit">Deposit</option>
                <option value="withdrawal">Withdrawal</option>
            </select>
        </div>
        <br>

        <div>
            <label>Amount:</label><br>
            <input type="number" step="0.01" name="amount" required min="1">
        </div>
        <br>

        <div>
            <label>Notes:</label><br>
            <textarea name="notes"></textarea>
        </div>
        <br>

        <button type="submit">Submit Transaction</button>
    </form>
</body>
</html>