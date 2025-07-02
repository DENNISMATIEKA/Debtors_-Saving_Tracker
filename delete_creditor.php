<?php
include('db.php');

// Sanitize the incoming ID
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($id > 0) {
  // Optional: delete payments manually if ON DELETE CASCADE is not enabled
  $conn->query("DELETE FROM creditor_payments WHERE creditor_id = $id");

  // Delete the creditor record
  $conn->query("DELETE FROM creditors WHERE id = $id");
}

// Redirect back to the creditors page
header("Location: creditors.php");
exit;
?>
