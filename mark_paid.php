<?php
include('db.php');

// Sanitize and validate the ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
  // Optional: You could check if the debtor exists first

  // Use prepared statement to avoid injection
  $stmt = $conn->prepare("UPDATE debtors SET status = 'paid' WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

// Redirect to debtor page (update path if needed)
header('Location: debtor.php');
exit;
?>
