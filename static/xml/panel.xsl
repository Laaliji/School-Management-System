<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:template match="/">
    <html lang="en">
      <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5"/>
        <meta name="author" content="AdminKit"/>
        <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web"/>
        <link rel="preconnect" href="https://fonts.gstatic.com"/>
        <link rel="shortcut icon" href="img/icons/icon-48x48.png"/>
        <link rel="canonical" href="https://demo-basic.adminkit.io/"/>
        <title>Admin Dashboard</title>
        <link href="css/app.css" rel="stylesheet"/>
        <style>
          main {
              background-image: url('img/photos/backgroundzlij.jpg');
              background-size: auto;
              background-position: center;
              margin: 0;
              padding: 0;
          }

          .table-container {
              width: 100%;
              max-height: 500px; /* Adjust the height as needed */
              overflow-y: auto;
          }

          /* Add the following styles for the update mark form */
          .update-mark-form {
              display: flex;
              gap: 5px;
              margin-bottom: 10px;
          }

          .update-mark-form input[type="text"] {
              padding: 5px;
          }

          .update-mark-form button {
              padding: 5px 10px;
              background-color: green;
              color: #fff;
              border: none;
              cursor: pointer;
          }

          /* Additional card styles */
          .card {
              border: 1px solid #ddd;
              padding: 10px;
              margin: 10px 0;
          }

        /* Adjust the space between the text and image */
        .card-body img {
            margin-right: 20px; /* Adjust the margin as needed */
        }
        </style>
      </head>
      <body>
        <div class="wrapper">
          <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
              <a class="sidebar-brand" href="index.html">
                <span class="align-middle">Dashboard Admin</span>
              </a>
      
              <ul class="sidebar-nav">
                <li class="sidebar-header">
                  Admin Panel
                </li>
                <li class="sidebar-item active">
                  <a class="sidebar-link" href="panel.php">
                    <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Aperçu</span>
                  </a>
                </li>
                <li class="sidebar-header">
                  Pages
                </li>
                <li class="sidebar-item ">
                  <a class="sidebar-link" href="etudiantsdashboard.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Etudiants</span>
                  </a>
                </li>
                <li class="sidebar-item ">
                  <a class="sidebar-link" href="professeursdashboard.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Professeurs</span>
                  </a>
                </li>
                <li class="sidebar-item ">
                  <a class="sidebar-link" href="departementsdashboard.php">
                    <i class="align-middle" data-feather="list"></i> <span class="align-middle">Départements</span>
                  </a>
                </li>
                <li class="sidebar-item ">
                  <a class="sidebar-link" href="filieresdashboard.php">
                    <i class="align-middle" data-feather="bookmark"></i> <span class="align-middle">Filières</span>
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="matieresdashboard.php">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Matières</span>
                  </a>
                </li>
              </ul>
            </div>
          </nav>

          <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
              <a class="sidebar-toggle js-sidebar-toggle">
                  <i class="hamburger align-self-center"></i>
              </a>

              <div class="navbar-collapse collapse">
                  <ul class="navbar-nav navbar-align">
                      <li class="nav-item dropdown">
                          <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                              <i class="align-middle" data-feather="settings"></i>
                          </a>
                          <img src="img/photos/estlogo.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                          <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                              Admin
                          </a>
                          <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="loginadmin.php">Log out</a>
                          </div>
                      </li>
                  </ul>
              </div>
            </nav>

            <main class="content">
              <div class="container-fluid p-0">
                <div class="row">
                  <!-- Students Card -->
                  <div class="col-md-4">
                    <div class="card" style="background-color: #fdebd8;">
                      <div class="card-body d-flex align-items-center">
                        <img src="img/icons/student.png" alt="Students Icon" width="100" height="100" class="mr-2"/>
                        <div>
                          <h5 class="card-title" style="color:black;">Etudiants</h5>
                          <p class="card-text" style="color:black;">Total Students: <xsl:value-of select="count(//student)"/></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Applications Card -->
                  <div class="col-md-4">
                    <div class="card" style="background-color: #fdebd8;">
                      <div class="card-body d-flex align-items-center">
                        <img src="img/icons/top-rated.png" alt="Applications Icon" width="100" height="100" class="mr-2"/>
                        <div>
                          <h5 class="card-title" style="color:black;">Candidatures</h5>
                          <p class="card-text" style="color:black;">Total Applications: <xsl:value-of select="count(//application)"/></p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Professeurs Card -->
                  <div class="col-md-4">
                    <div class="card" style="background-color: #fdebd8;">
                      <div class="card-body d-flex align-items-center">
                        <img src="img/icons/dean.png" alt="Professeurs Icon" width="100" height="100" class="mr-2"/>
                        <div>
                          <h5 class="card-title" style="color:black;">Professeurs</h5>
                          <p class="card-text" style="color:black;">Total Professeurs: <xsl:value-of select="count(//professeur)"/></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
                
                <div class="row">
                  <!-- Departments Card -->
                  <div class="col-md-4">
                    <div class="card" style="background-color: #fdebd8;">
                      <div class="card-body d-flex align-items-center">
                        <img src="img/icons/office.png" alt="Departments Icon" width="100" height="100" class="mr-2"/>
                        <div>
                          <h5 class="card-title" style="color:black;">Departements</h5>
                          <p class="card-text" style="color:black;">Total Departments: <xsl:value-of select="count(//department)"/></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Filières Card -->
                  <div class="col-md-4">
                    <div class="card" style="background-color: #fdebd8;">
                      <div class="card-body d-flex align-items-center">
                        <img src="img/icons/data-science.png" alt="Filières Icon" width="100" height="100" class="mr-2"/>
                        <div>
                          <h5 class="card-title" style="color:black;">Filières</h5>
                          <p class="card-text" style="color:black;">Total Filières: <xsl:value-of select="count(//filieres/filiere)"/></p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Matières Card -->
                  <div class="col-md-4">
                    <div class="card" style="background-color: #fdebd8;">
                      <div class="card-body d-flex align-items-center">
                        <img src="img/icons/book-stack.png" alt="Matières Icon" width="95" height="95" class="mr-2"/>
                        <div>
                          <h5 class="card-title" style="color:black;">Matières</h5>
                          <p class="card-text" style="color:black;">Total Matières: <xsl:value-of select="count(//matiere)"/></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </main>

            <footer class="footer">
              <div class="container-fluid">
                  <div class="row text-muted">
                      <div class="col-6 text-start">
                          <p class="mb-0">
                              <a class="text-muted" href="http://www.ests.uca.ma/" target="_blank"><strong>EST Safi</strong></a>
                              <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong></strong></a>
                          </p>
                      </div>
                  </div>
              </div>
          </footer>

          </div>
        </div>
        <script src="js/app.js"></script>
      </body>
    </html>
  </xsl:template>

</xsl:stylesheet>
