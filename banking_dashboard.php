<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user'])) {
  header("Location: login_form.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SecureBank | Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      background-color: #1a1a1a;
      min-height: 100vh;
    }
    .sidebar .nav-link {
      color: #ccc;
    }
    .sidebar .nav-link.active, .sidebar .nav-link:hover {
      background-color: #333;
      color: #fff;
    }
    .card-icon {
      font-size: 1.8rem;
      opacity: 0.7;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
      <h4 class="text-white">SecureBank</h4>
      <ul class="nav flex-column mt-4">
        <li class="nav-item"><a class="nav-link active" href="#"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-currency-dollar me-2"></i> Accounts</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-shield-lock me-2"></i> Security</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

    <h2 class="mb-4">Welcome Back, <?php echo $_SESSION['user']; ?></h2>

      <!-- Cards -->
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card text-bg-success shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-bank card-icon me-2"></i>Account Balance</h5>
              <p class="card-text fs-4">$12,540.00</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-warning shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-person-check-fill card-icon me-2"></i>Last Login</h5>
              <p class="card-text">Apr 18, 2024 @ 09:44 AM</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-danger shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill card-icon me-2"></i>Security Alerts</h5>
              <p class="card-text">2 attempts flagged</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Transactions Table -->
      <div class="card mb-4">
        <div class="card-header bg-dark text-white">
          Recent Transactions
        </div>
        <div class="card-body bg-white">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Apr 17, 2024</td>
                <td>ATM Withdrawal</td>
                <td>-$100.00</td>
                <td><span class="badge bg-success">Completed</span></td>
              </tr>
              <tr>
                <td>Apr 16, 2024</td>
                <td>Online Transfer</td>
                <td>-$250.00</td>
                <td><span class="badge bg-success">Completed</span></td>
              </tr>
              <tr>
                <td>Apr 15, 2024</td>
                <td>Deposit</td>
                <td>+$1,200.00</td>
                <td><span class="badge bg-primary">Posted</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Vulnerable User Notes Form (XSS Test) -->
      <div class="card mb-4">
        <div class="card-header bg-danger text-white">
          Vulnerable User Notes (XSS Test)
        </div>
        <div class="card-body bg-light">
          <form method="GET" class="mb-3">
            <div class="mb-2">
              <label for="note" class="form-label">Leave a note:</label>
              <input type="text" class="form-control" id="note" name="note" placeholder="Try a script...">
            </div>
            <button type="submit" class="btn btn-danger">Submit</button>
          </form>

          <?php
          if (isset($_GET['note'])) {
            $note = $_GET['note'];         // vulnerable to XSS (Typing "<script>alert('REFLECTED XSS EXPLOIT')</script>" will cause alert to pop up.)
            echo "<div><strong>Your Note:</strong> $note</div>";
          }
          ?>
        </div>
      </div>

      <footer class="text-muted small text-center mt-4">
        &copy; 2024 SecureBank. All rights reserved.
      </footer>
    </main>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
