<?php
include('db.php');

// Get and validate the amount
$amount = floatval($_POST['amount']);

// Only insert if amount is valid and positive
if ($amount > 0) {
  $stmt = $conn->prepare("INSERT INTO savings (amount) VALUES (?)");
  $stmt->bind_param("d", $amount);
  $stmt->execute();
  $stmt->close();
}

// Redirect back to homepage or savings page
header("Location: savings.php");
exit;
?>
