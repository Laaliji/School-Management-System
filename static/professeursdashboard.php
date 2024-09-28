<?php
// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

// Retrieve professors data
$professeurs = $xml->xpath('//professeur');
$departments = $xml->xpath('//department');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to update professor department
    if (isset($_POST['update_department']) && isset($_POST['professor_id']) && isset($_POST['department_id'])) {
        $professorId = (string)$_POST['professor_id'];
        $departmentId = (string)$_POST['department_id'];

        // Find the professor in the XML data
        $professor = $xml->xpath("//professeur[@id='$professorId']");

        // Update the department attribute
        if ($professor) {
            $professor[0]['department'] = $departmentId;

            // Save the updated XML data
            $xml->asXML('xml/DATA2.xml');
        }
    }
}
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

	<title>Admin Dashboard</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<style>
        main{
            background-image: url('img/photos/backgroundzlij.jpg');
            background-size:auto;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

       
        .table-container {
            width: 100%;
            max-height: 500px;
            overflow-y: auto;
        }

        

        select {
            padding: 8px;
            font-size: 14px;
        }

        button {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    
</style>
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
                    <li class="sidebar-item ">
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
                    <li class="sidebar-item active">
						<a class="sidebar-link" href="professeursdashboard.php">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Professeurs</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="departementsdashboard.php">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Départements</span>
            </a>
					</li>
					<li class="sidebar-item">
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
        <div class="container-fluid p-0" >

            <h1 class="h3 mb-3"><strong>Gestion</strong> des professeurs</h1>

            <!-- ... Your existing content ... -->
                        <div class="card">
                            <h5 class="card-header">Liste des professeurs</h5>
                        
                        <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Fullname</th>
                                    <th>Date de naissance</th>
                                    <th>Tel</th>
                                    <th>Email</th>
                                    <th>CIN</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach ($professeurs as $professeur) :?>
                                    
                                    <tr>
                                        <td><?= (string)$professeur['id']; ?></td>
                                        <td><?= (string)$professeur['username']; ?></td>
                                        <td><?= (string)$professeur->details3->fullname->fname . ' ' . (string)$professeur->details3->fullname->lname; ?></td>
                                        <td><?= (string)$professeur->details3->birthdate; ?></td>
                                        <td><?= (string)$professeur->details3->tel; ?></td>
                                        <td><?= (string)$professeur->details3->email; ?></td>
                                        <td><?= (string)$professeur->details3->cin; ?></td>
                                        <td>
                                        <?php
                                        $departmentId = (string)$professeur['department'];
                                        $department = $xml->xpath("//department[@id='$departmentId']");
                                        echo $department ? (string)$department[0]['name'] : 'N/A';
                                        ?>
                                    </td>
                                    <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="professor_id" value="<?= (string)$professeur['id']; ?>">
                                            <select name="department_id">
                                                <?php foreach ($departments as $department) : ?>
                                                    <option value="<?= (string)$department['id']; ?>" <?= ($department['id'] == $departmentId) ? 'selected' : ''; ?>>
                                                        <?= (string)$department['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" name="update_department">Modifier</button>
                                        </form>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                        </div>
                    
                
            

        </div>
    </main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="http://www.ests.uca.ma/" target="_blank"><strong>EST Safi</strong></a> <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong></strong></a>								
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