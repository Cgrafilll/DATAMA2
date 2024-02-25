<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>CMS</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
          <div class="container-fluid">
          <a class="navbar-brand me-auto" href="home.php"><span class="title">Clothing Management System</span></a>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header">
              <h2 class="offcanvas-title" id="offcanvasNavbarLabel">CMS</h2>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-center flex-grow-1 pe-5 me-5">
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="">Stocks</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="">Promos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="">Customers</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="">Suppliers</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="">Stores</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link mx-lg-2" href="">Transaction</a>
                  </li>
              </ul>
              </div>
          </div>
          <button type="button" class="button border border-0" id="home"><span>Admin</span></button>
          <button class="navbar-toggler pe-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>
</html>