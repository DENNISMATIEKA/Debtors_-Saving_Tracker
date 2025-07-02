<?php
include('db.php');

// Sanitize and validate inputs
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$pay = isset($_POST['pay_amount']) ? floatval($_POST['pay_amount']) : 0;

if ($id > 0 && $pay > 0) {
  // Add to total paid amount
  $stmt1 = $conn->prepare("UPDATE debtors SET paid_amount = paid_amount + ? WHERE id = ?");
  $stmt1->bind_param("di", $pay, $id);
  $stmt1->execute();
  $stmt1->close();

  // Insert payment history
  $stmt2 = $conn->prepare("INSERT INTO payments (debtor_id, amount_paid) VALUES (?, ?)");
  $stmt2->bind_param("id", $id, $pay);
  $stmt2->execute();
  $stmt2->close();

  // Auto-update status if paid in full
  $stmt3 = $conn->prepare("UPDATE debtors SET status = 'paid' WHERE id = ? AND paid_amount >= amount");
  $stmt3->bind_param("i", $id);
  $stmt3->execute();
  $stmt3->close();
}

// Redirect back to the tracker
header("Location: debtors.php");
exit;
?>
