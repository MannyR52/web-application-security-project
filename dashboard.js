document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".nav-link");
    const mainContent = document.querySelector("main");
  
    navLinks.forEach(link => {
      link.addEventListener("click", event => {
        event.preventDefault();
  
        navLinks.forEach(l => l.classList.remove("active"));
        link.classList.add("active");
  
        const target = link.textContent.trim().toLowerCase();
  
        if (target === "dashboard") {
          loadDashboard();
        } else if (target === "accounts") {
          loadAccounts();
        } else {
          mainContent.innerHTML = `<h2 class="mt-4">Coming Soon</h2>`;
        }
      });
    });
  
    function loadDashboard() {
      mainContent.innerHTML = `
        <h2 class="mb-4">Welcome Back, user1</h2>
        <div class="row g-4 mb-4">
          <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-bank me-2"></i>Account Balance</h5>
                <p class="card-text fs-4">$12,540.00</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-check-fill me-2"></i>Last Login</h5>
                <p class="card-text">Apr 18, 2024 @ 09:44 AM</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-bg-danger shadow-sm">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Security Alerts</h5>
                <p class="card-text">2 attempts flagged</p>
              </div>
            </div>
          </div>
        </div>
      `;
    }
  
    function loadAccounts() {
      mainContent.innerHTML = `
        <h2 class="mb-4">Your Accounts</h2>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card shadow-sm border-primary">
              <div class="card-header bg-primary text-white">
                <i class="bi bi-credit-card-2-front me-2"></i>Checking Account
              </div>
              <div class="card-body">
                <h5 class="card-title">Balance: $5,200.00</h5>
                <p class="card-text">Account #: ****1234</p>
                <p class="text-muted small">Last activity: Apr 17, 2024</p>
                <button class="btn btn-outline-primary btn-sm">View Transactions</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card shadow-sm border-success">
              <div class="card-header bg-success text-white">
                <i class="bi bi-piggy-bank-fill me-2"></i>Savings Account
              </div>
              <div class="card-body">
                <h5 class="card-title">Balance: $14,800.00</h5>
                <p class="card-text">Account #: ****5678</p>
                <p class="text-muted small">Last activity: Apr 15, 2024</p>
                <button class="btn btn-outline-success btn-sm">View Transactions</button>
              </div>
            </div>
          </div>
        </div>
      `;
    }
  
    // Load dashboard by default
    loadDashboard();
  });
