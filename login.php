<?php
require 'includes/config.php'; // Database connection
session_start();
include "header.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare a query to fetch the user and their role
    $query = "SELECT users.*, roles.role_name AS role FROM users 
              JOIN roles ON users.role_id = roles.id 
              WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role']
        ];

        // Redirect based on role
        if ($user['role'] === 'Admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: common/dashboard.php');
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>


<body>
    <div class="container col-md-6">
    <form method="POST">
        <h2>Login</h2>
        <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
      <a href="register.php">Create Account</a>
  </div>
</body>
