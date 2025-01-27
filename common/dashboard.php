<?php
require '../includes/auth.php';
requireLogin(); // Only logged-in users can access this page
?>

<!DOCTYPE html>
<html>
<head>
    <title>Common User Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['user']['name']; ?>!</h1>
    <p>You are logged in as a Common User.</p>
    <p><a href="../logout.php">Logout</a></p>
</body>
</html>
