<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SecureBank | Login</title>

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Bootstrap Icons (optional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-card {
      max-width: 400px;
      margin: 5rem auto;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }
    .toggle-buttons {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
  </style>
</head>
<body>

  <div class="container">
    <div class="card login-card">
      <div class="card-body">
        <h3 class="card-title text-center mb-4">Login</h3>
         <div class="toggle-buttons">
            <button type="button" class="btn btn-warning w-50" onclick="document.getElementById('loginForm').action='vulnerable_login.php';">Vulnerable Mode</button>
            <button type="button" class="btn btn-success w-50" onclick="document.getElementById('loginForm').action='secure_login.php';">Secure Mode</button>
          </div>
        <form id="loginForm" action="login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
          <div class="text-center mt-3">
            <small><a href="#">Forgot password?</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
