<?php
// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

// Retrieve professors data
$professors = $xml->xpath('//professeur');

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Prof Dashboard</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
						Pages
					</li>

				

					<li class="sidebar-item active">
						<a class="sidebar-link" href="ListeEtudiants.html">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Gestion Profs</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="ListeEtudiants.html">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Gestion Départements</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="ListeEtudiants.html">
              <i class="align-middle" data-feather="bookmark"></i> <span class="align-middle">Gestion Filières</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="Absence.html">
              <i class="align-middle" data-feather="book"></i> <span class="align-middle">Gestion Matières</span>
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

            <h1 class="h3 mb-3"><strong>Gestion</strong> d'Admin</h1>

            <!-- ... Your existing content ... -->

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
                                <?php foreach ($professors as $professor) : ?>
                                    <tr>
                                        <td><?= (string)$professor['id']; ?></td>
                                        <td><?= (string)$professor['department']; ?></td>
                                        <td><?= (string)$professor['username']; ?></td>
                                        <td><?= (string)$professor->details3->fullname->fname . ' ' . (string)$professor->details3->fullname->lname; ?></td>
                                        <td><?= (string)$professor->details3->birthdate; ?></td>
                                        <td><?= (string)$professor->details3->tel; ?></td>
                                        <td><?= (string)$professor->details3->email; ?></td>
                                        <td><?= (string)$professor->details3->cin; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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
								<a class="text-muted" href="" target="_blank"><strong>EST Safi</strong></a> <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong></strong></a>								
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