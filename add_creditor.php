<?php
include('db.php');

// Sanitize and validate input
$name = trim($_POST['name']);
$amount = floatval($_POST['amount']);

if ($name !== '' && $amount > 0) {
  // Insert new creditor securely
  $stmt = $conn->prepare("INSERT INTO creditors (name, amount) VALUES (?, ?)");
  $stmt->bind_param("sd", $name, $amount);
  $stmt->execute();
  $stmt->close();
}

// Redirect back to the creditors page
header("Location: creditors.php");
exit;
?>

