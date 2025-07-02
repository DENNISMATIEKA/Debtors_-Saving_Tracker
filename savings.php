<?php
session_start();
include('db.php');

// If reset button was clicked after reaching goal
if (isset($_POST['reset_target'])) {
  $_SESSION['allow_new_target'] = true;
}

// If a new target is set after reaching goal
if (isset($_POST['set_target'])) {
  $result = $conn->query("SELECT SUM(amount) AS total FROM savings");
  $total = ($result && $result->num_rows > 0) ? floatval($result->fetch_assoc()['total']) : 0;

  if (!isset($_SESSION['target']) || $total >= $_SESSION['target']) {
    $_SESSION['target'] = floatval($_POST['custom_target']);
    $conn->query("DELETE FROM savings"); // Optional: clear on reset
  }
}


// Set target if exists, else fallback
$target = isset($_SESSION['target']) ? $_SESSION['target'] : 500000;

// Calculate progress
$result = $conn->query("SELECT SUM(amount) AS total FROM savings");
$total = ($result && $result->num_rows > 0) ? floatval($result->fetch_assoc()['total']) : 0;
$percent = $target > 0 ? min(100, ($total / $target) * 100) : 0;

include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Savings Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
<div class="container py-4">
  <h2 class="mb-4">📈 Savings Tracker</h2>

  <?php
 // Make sure session is active
  $target = isset($_SESSION['target']) ? floatval($_SESSION['target']) : 500000;

  $result = $conn->query("SELECT SUM(amount) AS total FROM savings");
  $total = ($result && $result->num_rows > 0) ? floatval($result->fetch_assoc()['total']) : 0;
  $percent = $target > 0 ? min(100, ($total / $target) * 100) : 0;
?>


  <form action="add_saving.php" method="POST" class="mb-4 row g-2">
    <div class="col-md-6">
      <input name="amount" type="number" step="0.01" min="1" class="form-control" placeholder="Enter Savings Amount" required />
    </div>
    <div class="col-md-3">
      <button class="btn btn-success w-100">Add Saving</button>
    </div>
  </form>
<!-- 🎉 Congratulatory Alert -->
<?php if ($total >= $target): ?>
  <div class="alert alert-success fw-bold text-center" role="alert">
    🎉 Congratulations! You've reached your savings target of Ksh <?= number_format($target, 2) ?>!
  </div>
<?php endif; ?>

<form method="POST" class="row g-2 mb-3">
  <div class="col-md-6">
   <input type="number" name="custom_target" min="1000" class="form-control"
       placeholder="Set Your Target (KES)" required
       value="<?= $target ?>"
       <?= ($total < $target) ? 'disabled' : '' ?>>

  </div>
  <div class="col-md-3 d-flex gap-2">
    <button name="set_target" class="btn btn-primary w-100"
        <?= ($total < $target) ? 'disabled' : '' ?>>
  <?= ($total < $target) ? 'Locked (Target Set)' : 'Set New Target' ?>
</button>

    <?php if ($total >= $target && !isset($_SESSION['allow_new_target'])): ?>
      <button name="reset_target" class="btn btn-warning">Reset Target</button>
    <?php endif; ?>
  </div>
</form>


  <div class="mb-3">
    <div class="progress" style="height: 30px;">
      <div class="progress-bar bg-info fw-bold" style="width: <?= $percent ?>%;">
        <?= number_format($percent, 1) ?>%
      </div>
    </div>
  </div>

  <p class="fw-semibold">💰 Total Saved: <strong>Ksh <?= number_format($total, 2) ?></strong> / Ksh <?= number_format($target, 2) ?></p>

  <hr />
  

  <h5>💾 Savings History</h5>
  <?php
    $entries = $conn->query("SELECT amount, created_at FROM savings ORDER BY created_at DESC");

    if ($entries && $entries->num_rows > 0) {
      echo "<ul class='list-group'>";
      while ($s = $entries->fetch_assoc()) {
        echo "<li class='list-group-item d-flex justify-content-between'>
          <span>Ksh " . number_format($s['amount'], 2) . "</span>
          <small class='text-muted'>" . date('M j, Y - H:i', strtotime($s['created_at'])) . "</small>
        </li>";
      }
      echo "</ul>";
    } else {
      echo "<p class='text-muted'>No savings recorded yet.</p>";
    }
  ?>
</div>
<?php include('footer.php'); ?>
</body>
</html>
