<?php
include('db.php');

// Sanitize the incoming ID
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
  // Optional: delete payment records first (if not using ON DELETE CASCADE)
  $conn->query("DELETE FROM payments WHERE debtor_id = $id");

  // Delete the debtor record
  $conn->query("DELETE FROM debtors WHERE id = $id");
}

// Redirect back to the debtors page
header("Location: debtors.php");
exit;
?>
