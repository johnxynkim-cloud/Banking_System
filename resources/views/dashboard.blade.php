<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking System Dashboard</title>
</head>
<body>
    <h1>Banking System Dashboard</h1>

    <!-- Dashboard Statistics Elements -->
    <div id="dashboard-stats">
        <p>Total Accounts: <span id="total-accounts">--</span></p>
        <p>Total Money in Bank: $<span id="total-money">--</span></p>
        <p>Transactions Today: <span id="total-tx">--</span></p>
    </div>

    <!-- AJAX Polling Script -->
    <script>
        async function fetchDashboardStats() {
            try {
                let response = await fetch('/api/dashboard/stats');
                if (!response.ok) throw new Error('Network response was not ok');
                let data = await response.json();
                
                document.getElementById('total-accounts').innerText = data.total_accounts;
                document.getElementById('total-money').innerText = Number(data.total_money).toLocaleString(undefined, {minimumFractionDigits: 2});
                document.getElementById('total-tx').innerText = data.total_transactions_today;
            } catch (error) {
                console.error('Error fetching dashboard stats:', error);
            }
        }

        // Initial fetch on page load
        fetchDashboardStats();

        // Poll every 30 seconds
        setInterval(fetchDashboardStats, 30000);
    </script>
</body>
</html>