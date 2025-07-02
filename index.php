<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DenMatTrack | Financial Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('assets/pattern-light.png') no-repeat center center fixed;
      background-size: cover;
    }
    .overlay {
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      color: #fff;
      top: 50%;
      transform: translateY(-50%);
      animation: fadeIn 1.5s ease-in;
    }
    h1, p {
      animation: slideIn 1.2s ease-out forwards;
      opacity: 0;
    }
    h1 {
      animation-delay: 0.3s;
    }
    p {
      animation-delay: 0.6s;
    }
    .btn-group {
      margin-top: 2rem;
      animation: fadeIn 2s ease-in;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideIn {
      from { transform: translateY(-20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
  </style>
  <?php include('header.php'); ?>
</head>
<body>
  <div class="overlay"></div>
  <div class="container justify-content-center align-items-center">
    <div class="hero-content">
      <h1 class="display-4 fw-bold">DenMatTrack</h1>
      <p class="lead">Track Your Finances with Confidence</p>
      <div class="btn-group">
        <a href="savings.php" class="btn btn-outline-light btn-lg me-3">Savings</a>
        <a href="debtors.php" class="btn btn-outline-warning btn-lg">Debtors</a>
        <a href="creditors.php" class="btn btn-outline-light btn-lg me-3">Creditors</a>
        <a href="investments.php" class="btn btn-outline-warning btn-lg">Investments</a>
      </div>
    </div>
  </div>
     <?php include('footer.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
