<?php
include('db.php');

// Sanitize and validate input
$name = trim($_POST['name']);
$amount = floatval($_POST['amount']);

if ($name !== '' && $amount > 0) {
  // Insert debtor using a prepared statement
  $stmt = $conn->prepare("INSERT INTO debtors (name, amount) VALUES (?, ?)");
  $stmt->bind_param("sd", $name, $amount);
  $stmt->execute();
  $stmt->close();
}

// Redirect back to the debtors list
header("Location: debtors.php");
exit;
?>
