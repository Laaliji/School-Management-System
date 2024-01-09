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
        <title>Prof Dashboard</title>
        <link href="css/app.css" rel="stylesheet"/>
      </head>
      <body>
        <div class="wrapper">
          <xsl:apply-templates/>
        </div>
        <script src="js/app.js"></script>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="professeurs">
    <nav id="sidebar" class="sidebar js-sidebar">
      <!-- Sidebar content -->
      <div class="sidebar-content js-simplebar">
        <!-- Sidebar brand -->
        <a class="sidebar-brand" href="index.html">
          <span class="align-middle">Dashboard Admin</span>
        </a>
        <!-- Sidebar navigation -->
        <ul class="sidebar-nav">
          <li class="sidebar-header">
            Pages
          </li>
          <li class="sidebar-item active">
            <a class="sidebar-link" href="ListeEtudiants.html">
              <i class="align-middle" data-feather="user"></i>
              <span class="align-middle">Gestion Profs</span>
            </a>
          </li>
          <!-- Add more sidebar items as needed -->
        </ul>
      </div>
    </nav>

    <div class="main">
      <!-- Main content -->
      <main class="content">
        <div class="container-fluid p-0">
          <h1 class="h3 mb-3"><strong>Gestion</strong> d'Admin</h1>
          <div class="row">
            <div class="col-12 col-lg-8 col-xxl-9 d-flex">
              <div class="card flex-fill">
                <div class="card-header">
                  <h5 class="card-title mb-0">Liste des Professeurs</h5>
                </div>
                <table class="table table-hover my-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Department</th>
                      <th>Username</th>
                      <th>Fullname</th>
                      <th>Birthdate</th>
                      <th>Tel</th>
                      <th>Email</th>
                      <th>CIN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <xsl:apply-templates select="professeur"/>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
      <footer class="footer">
        <!-- Footer content -->
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0">
                <a class="text-muted" href="" target="_blank"><strong>EST Safi</strong></a>
                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong></strong></a>
              </p>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </xsl:template>

  <xsl:template match="professeur">
    <tr>
      <td>
        <xsl:value-of select="@id"/>
      </td>
      <td>
        <xsl:value-of select="@department"/>
      </td>
      <td>
        <xsl:value-of select="@username"/>
      </td>
      <td>
        <xsl:value-of select="details3/fullname/fname"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="details3/fullname/lname"/>
      </td>
      <td>
        <xsl:value-of select="details3/birthdate"/>
      </td>
      <td>
        <xsl:value-of select="details3/tel"/>
      </td>
      <td>
        <xsl:value-of select="details3/email"/>
      </td>
      <td>
        <xsl:value-of select="details3/cin"/>
      </td>
    </tr>
  </xsl:template>

</xsl:stylesheet>
