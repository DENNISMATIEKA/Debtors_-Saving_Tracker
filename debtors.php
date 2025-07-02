<?php include('db.php'); ?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Debtors Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container py-4">
  <h2 class="mb-4">💰 Debtors Tracker</h2>

  <form action="add_debtor.php" method="POST" class="mb-3 row g-2">
    <div class="col-sm-5">
      <input name="name" class="form-control" placeholder="Debtor Name" required />
    </div>
    <div class="col-sm-4">
      <input name="amount" type="number" class="form-control" placeholder="Amount" required />
    </div>
    <div class="col-sm-3">
      <button type="submit" class="btn btn-primary w-100">Add Debtor</button>
    </div>
  </form>

  <?php
  $debts = $conn->query("SELECT * FROM debtors ORDER BY created_at DESC");
  $total_debt = 0;

  if ($debts && $debts->num_rows > 0) {
    echo "<table class='table table-bordered'>
      <thead>
        <tr>
          <th>Name</th>
          <th>Amount</th>
          <th>Paid</th>
          <th>Balance</th>
          <th>Status</th>
          <th>Repayment & History</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>";

    while ($d = $debts->fetch_assoc()) {
      $remaining = $d['amount'] - $d['paid_amount'];
      $percent = $d['amount'] > 0 ? min(100, ($d['paid_amount'] / $d['amount']) * 100) : 0;
      $total_debt += $remaining;

      echo "<tr>
        <td>{$d['name']}</td>
        <td>Ksh " . number_format($d['amount'], 2) . "</td>
        <td>Ksh " . number_format($d['paid_amount'], 2) . "</td>
        <td><strong>Ksh " . number_format($remaining, 2) . "</strong></td>
        <td>{$d['status']}</td>
        <td>
          <div class='progress mb-2' style='height: 20px; max-width: 200px;'>
            <div class='progress-bar bg-success' style='width: {$percent}%;'>
              " . number_format($percent, 1) . "%
            </div>
          </div>
          <form action='pay_debt.php' method='POST' class='d-flex gap-1 mb-2'>
            <input type='hidden' name='id' value='{$d['id']}'>
            <input type='number' name='pay_amount' min='1' max='{$remaining}' required class='form-control form-control-sm' placeholder='Pay Ksh'>
            <button class='btn btn-sm btn-primary'>Pay</button>
          </form>";

      // Payment History
      $history = $conn->query("SELECT amount_paid, paid_at FROM payments WHERE debtor_id = {$d['id']} ORDER BY paid_at DESC");

      if ($history && $history->num_rows > 0) {
        echo "<ul class='list-group list-group-flush'>";
        while ($h = $history->fetch_assoc()) {
          echo "<li class='list-group-item d-flex justify-content-between'>
            <span>Paid Ksh " . number_format($h['amount_paid'], 2) . "</span>
            <small class='text-muted'>" . date('M j, Y - H:i', strtotime($h['paid_at'])) . "</small>
          </li>";
        }
        echo "</ul>";
      } else {
        echo "<p class='text-muted'>No payments yet.</p>";
      }

      echo "</td>";

      // Show delete if fully paid
      if ($d['paid_amount'] >= $d['amount']) {
        echo "<td>
          <form action='delete_debtor.php' method='POST' onsubmit=\"return confirm('Delete this debtor?');\">
            <input type='hidden' name='id' value='{$d['id']}'>
            <button class='btn btn-danger btn-sm'>Delete</button>
          </form>
        </td>";
      } else {
        echo "<td></td>";
      }

      echo "</tr>";
    }

    echo "</tbody></table>";
  } else {
    echo "<p class='text-muted'>No debtors recorded yet.</p>";
  }

  echo "<p><strong>Total Outstanding Debt:</strong> Ksh " . number_format($total_debt, 2) . "</p>";
  ?>
</div>
<?php include('footer.php'); ?>
</body>
</html>
