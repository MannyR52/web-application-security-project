document.addEventListener("DOMContentLoaded", () => {
  const navLinks = document.querySelectorAll(".nav-link");
  const dynamicContent = document.getElementById("dynamic-dashboard-content");

  // Account balances
  let checkingBalance = 5200;
  let savingsBalance = 14800;
  let selectedAccount = null;

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
    dynamicContent.innerHTML = `
      <h2 class="mb-4">Welcome Back, user1</h2>
      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card text-bg-success shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-bank me-2"></i>Account Balance</h5>
              <p class="card-text fs-4" id="total-balance">$${checkingBalance + savingsBalance}.00</p>
              <button class="btn btn-light btn-sm mt-2" onclick="openDepositModal('total')">Deposit</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-warning shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-person-check-fill me-2"></i>Last Login</h5>
              <p class="card-text">Apr 18, 2024 @ 09:44 AM</p>
              <button class="btn btn-light btn-sm mt-2" onclick="openDepositModal('checking')">Deposit</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-bg-danger shadow-sm">
            <div class="card-body">
              <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Security Alerts</h5>
              <p class="card-text">2 attempts flagged</p>
              <button class="btn btn-light btn-sm mt-2" onclick="openDepositModal('savings')">Deposit</button>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  function loadAccounts() {
   dynamicContent.innerHTML = `
      <h2 class="mb-4">Your Accounts</h2>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="card shadow-sm border-primary">
            <div class="card-header bg-primary text-white">
              <i class="bi bi-credit-card-2-front me-2"></i>Checking Account
            </div>
            <div class="card-body">
              <h5 class="card-title">Balance: $<span id="checking-balance">${checkingBalance}.00</span></h5>
              <p class="card-text">Account #: ****1234</p>
              <p class="text-muted small">Last activity: Apr 17, 2024</p>
              <button class="btn btn-outline-primary btn-sm me-2">View Transactions</button>
              <button class="btn btn-outline-success btn-sm" onclick="openDepositModal('checking')">Deposit</button>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white">
              <i class="bi bi-piggy-bank-fill me-2"></i>Savings Account
            </div>
            <div class="card-body">
              <h5 class="card-title">Balance: $<span id="savings-balance">${savingsBalance}.00</span></h5>
              <p class="card-text">Account #: ****5678</p>
              <p class="text-muted small">Last activity: Apr 15, 2024</p>
              <button class="btn btn-outline-success btn-sm me-2">View Transactions</button>
              <button class="btn btn-outline-success btn-sm" onclick="openDepositModal('savings')">Deposit</button>
            </div>
          </div>
        </div>
      </div>
    `;
  }

  // Load dashboard by default
  loadDashboard();

  // Global deposit modal logic
  window.openDepositModal = function (account) {
    selectedAccount = account;
    const modal = new bootstrap.Modal(document.getElementById('depositModal'));
    document.getElementById("deposit-amount").value = "";
    document.getElementById("account-type-label").textContent =
      account === 'total'
        ? "Distribute deposit manually between accounts."
        : `Depositing to ${account.charAt(0).toUpperCase() + account.slice(1)} account`;
    modal.show();
  };

  document.getElementById("confirm-deposit").addEventListener("click", () => {
    const amountInput = document.getElementById("deposit-amount");
    const amount = parseFloat(amountInput.value);
    if (isNaN(amount) || amount <= 0) {
      alert("Please enter a valid amount.");
      return;
    }

    if (selectedAccount === 'checking') {
      checkingBalance += amount;
    } else if (selectedAccount === 'savings') {
      savingsBalance += amount;
    } else if (selectedAccount === 'total') {
      // For demonstration, split evenly between accounts
      checkingBalance += amount / 2;
      savingsBalance += amount / 2;
    }

    // Reload current view to reflect updated balances
    const activeTab = document.querySelector(".nav-link.active").textContent.trim().toLowerCase();
    if (activeTab === "accounts") {
      loadAccounts();
    } else {
      loadDashboard();
    }

    bootstrap.Modal.getInstance(document.getElementById("depositModal")).hide();
  });
});


