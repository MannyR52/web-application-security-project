<?php
session_start();
 //Check if user is logged in
if (!isset($_SESSION['user'])){
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
   <script src="dashboard.js" defer></script>
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
  <!-- Deposit Modal -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="depositModalLabel">Deposit Funds</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="account-type-label"></p>
        <input type="number" id="deposit-amount" class="form-control" placeholder="Enter amount" min="1" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirm-deposit">Confirm Deposit</button>
      </div>
    </div>
  </div>
</div>


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
      <div id="dynamic-dashboard-content">

        <!-- Cards -->
        <div class="row g-4 mb-4">
          <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-bank card-icon me-2"></i>Account Balance</h5>
                <p class="card-text fs-4">$12,540.00</p>
                <button class="btn btn-light btn-sm mt-3">Deposit</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-check-fill card-icon me-2"></i>Last Login</h5>
                <p class="card-text">Apr 18, 2024 @ 09:44 AM</p>
                <button class="btn btn-light btn-sm mt-3">Deposit</button>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-bg-danger shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill card-icon me-2"></i>Security Alerts</h5>
                <p class="card-text">2 attempts flagged</p>
                <button class="btn btn-light btn-sm mt-3">Deposit</button>
              </div>
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
                <td>
                  <span class="badge bg-success">Completed</span><br>
                  <button class="btn btn-outline-primary btn-sm mt-1">Deposit</button>
                </td>
              </tr>
              <tr>
                <td>Apr 16, 2024</td>
                <td>Online Transfer</td>
                <td>-$250.00</td>
                <td>
                  <span class="badge bg-success">Completed</span><br>
                  <button class="btn btn-outline-primary btn-sm mt-1">Deposit</button>
                </td>
              </tr>
              <tr>
                <td>Apr 15, 2024</td>
                <td>Deposit</td>
                <td>+$1,200.00</td>
                <td>
                  <span class="badge bg-primary">Posted</span><br>
                  <button class="btn btn-outline-primary btn-sm mt-1">Deposit</button>
                </td>
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

      <!-- Secure User Notes Form -->
       <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    Secure User Notes
                </div>
                <div class="card-body bg-light">
                    <form method="GET" class="mb-3">
                        <div class="mb-2">
                            <label for="secure_note" class="form-label">Leave a note:</label>
                            <input type="text" class="form-control" id="secure_note" name="secure_note" placeholder="Enter your note here.">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>

                    <div>
                        <strong>Your Note:</strong>
                        <?php
                        if (isset($_GET['secure_note'])) {
                            $secureNote = $_GET['secure_note'];
                            $safeNote = htmlspecialchars($secureNote, ENT_QUOTES, 'UTF-8');
                            echo "<div>" . $safeNote . "</div>"; // Secure output
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- ID Upload Form -->
<div class="card mb-4">
  <div class="card-header bg-info text-white">
    Verify Your Identity
  </div>
  <div class="card-body bg-light">
    <form action="secure_backend.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="id-upload" class="form-label">Upload a government-issued ID(secure) (JPEG, PNG,SVG,html or GIF only):</label>
        <input class="form-control" type="file" name="id-upload" id="id-upload" required accept=".jpg,.jpeg,.png,.gif,.svg,.html,.php">
      </div>
      <button type="submit" class="btn btn-primary">Submit for Review</button>
    </form>
    <form action="insecure_backend.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="id-upload" class="form-label">Upload a government-issued ID(insecure)(JPEG, PNG,SVG,html or GIF only):</label>
        <input class="form-control" type="file" name="id-upload" id="id-upload" required accept=".jpg,.jpeg,.png,.gif,.svg,.html,.php">
      </div>
      <button type="submit" class="btn btn-primary">Submit for Review</button>
    </form>

    <?php
    
if (isset($_GET['status']) && $_GET['status'] === 'success') {
  echo '<div class="alert alert-success mt-3">Your ID has been uploaded successfully and will be reviewed by our verification team.</div>';

  if (isset($_GET['image'])) {
    $imagePath = 'uploads/' . basename($_GET['image']);
    // Show preview of uploaded image
    echo "<div class='mt-3'><strong>Uploaded Image Preview:</strong><br><img src=\"$imagePath\" alt=\"Uploaded ID\" class=\"img-fluid border\" style=\"max-width:300px;\"></div>";
  }
} elseif (isset($_GET['status']) && $_GET['status'] === 'fail') {
  echo '<div class="alert alert-danger mt-3">There was a problem with your upload. Please try again or contact support.</div>';
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


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
