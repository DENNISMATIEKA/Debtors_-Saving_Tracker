<?php include('db.php'); ?>
<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

    <form action="add_investment.php" method="POST" class="row g-2 mb-4">
  <div class="col-md-3">
    <input name="description" class="form-control" placeholder="Description" required>
  </div>
  <div class="col-md-2">
    <select name="investment_type" class="form-select" required>
      <option value="savings">Savings</option>
      <option value="stocks">Stocks</option>
      <option value="land">Land</option>
      <option value="business">Business</option>
      <option value="crypto">Crypto</option>
      <option value="other">Other</option>
    </select>
  </div>
  <div class="col-md-2">
    <input name="amount" type="number" step="0.01" min="1" class="form-control" placeholder="Amount" required>
  </div>
  <div class="col-md-2">
    <input name="expected_return" type="number" step="0.01" class="form-control" placeholder="Expected Return">
  </div>
  <div class="col-md-2">
    <input name="maturity_date" type="date" class="form-control">
  </div>
  <div class="col-md-1">
    <button class="btn btn-success w-100">Add</button>
  </div>
</form>

<?php
$investments = $conn->query("SELECT * FROM investments ORDER BY created_at DESC");
?>

<div class="container py-4">
  <h2 class="mb-4">📈 Investment Tracker</h2>

  <?php if ($investments && $investments->num_rows > 0): ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Description</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Expected Return</th>
          <th>Maturity Date</th>
          <th>Status</th>
          <th>Date Created</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($i = $investments->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($i['description']) ?></td>
            <td><?= ucfirst($i['investment_type']) ?></td>
            <td>Ksh <?= number_format($i['amount'], 2) ?></td>
            <td><?= $i['expected_return'] ? 'Ksh ' . number_format($i['expected_return'], 2) : '—' ?></td>
            <td><?= $i['maturity_date'] ?? '—' ?></td>
            <td>
              <span class="badge bg-<?= $i['status'] === 'active' ? 'success' : 'secondary' ?>">
                <?= ucfirst($i['status']) ?>
              </span>
            </td>
            <td><?= date('M j, Y', strtotime($i['created_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info text-center">
      🪙 No investments currently recorded.
    </div>
  <?php endif; ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>