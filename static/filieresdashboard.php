<?php
// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

// Retrieve filieres data
$filieres = $xml->xpath('//filieres/filiere');

// Retrieve departments data
$departments = $xml->xpath('//department');

// Function to save changes to the XML file
function saveXML($xml, $file)
{
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($file);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new filiere
    if (isset($_POST["add_filiere"])) {
        $newFiliereID = max(array_map('intval', $xml->xpath('//filieres/filiere/@id'))) + 1;
        $newFiliereName = $_POST["new_filiere_name"];
        $newFiliereDepartmentID = $_POST["new_filiere_department"];

        $newFiliere = $xml->filieres->addChild('filiere');
        $newFiliere->addAttribute('id', $newFiliereID);
        $newFiliere->addAttribute('name', $newFiliereName);
        $newFiliere->addAttribute('department', $newFiliereDepartmentID);

        saveXML($xml, 'xml/DATA2.xml');
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after adding a filiere
        exit();
    }

    // Modify filiere
    if (isset($_POST["modify_filiere"])) {
        $filiereID = $_POST["modify_filiere_id"];
        $filiereName = $_POST["modify_filiere_name"];
        $filiereDepartmentID = $_POST["modify_filiere_department"];

        $filiere = $xml->xpath("//filieres/filiere[@id='$filiereID']")[0];
        $filiere['name'] = $filiereName;
        $filiere['department'] = $filiereDepartmentID;

        saveXML($xml, 'xml/DATA2.xml');
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after modifying a filiere
        exit();
    }

    // Delete filiere
    if (isset($_POST["delete_filiere"])) {
        $filiereID = $_POST["delete_filiere_id"];

        $filiere = $xml->xpath("//filieres/filiere[@id='$filiereID']")[0];
        unset($filiere[0]);

        saveXML($xml, 'xml/DATA2.xml');
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after deleting a filiere
        exit();
    }
}

// Function to get department name by ID
function getDepartmentName($departmentID)
{
    global $departments;
    foreach ($departments as $department) {
        if ((int) $department['id'] == $departmentID) {
            return (string) $department['name'];
        }
    }
    return 'N/A';
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
    main {
            background-image: url('img/photos/backgroundzlij.jpg');
            background-size:auto;
            background-position: center;
            margin: 0;
            padding: 0;
        }
    .table-container {
            width: 100%;
            max-height: 500px; /* Adjust the height as needed */
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

    .form-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-container button {
        background-color: #007bff;
    }

    .form-container button:hover {
        background-color: #0056b3;
    }

    .action-buttons {
        margin-bottom: 20px;
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
					<li class="sidebar-item active">
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

                    <h1 class="h3 mb-3"><strong>Gestion</strong> des filières</h1>

                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="showAddFiliereForm()">Ajouter une filière</button>
                    </div>

                    <div class="card">
                        <h5 class="card-header">Liste des filières</h5>

                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Filière</th>
										<th>Département</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($filieres as $filiere) : ?>
                                        <tr>
                                            <td><?= (int) $filiere['id']; ?></td>
                                            <td><?= (string) $filiere['name']; ?></td>
											<td><?= getDepartmentName($filiere['department']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="showModifyFiliereForm(<?= (int) $filiere['id']; ?>)">Modifier</button>
                                                <button class="btn btn-sm btn-danger" onclick="showDeleteFiliereForm(<?= (int) $filiere['id']; ?>)">Supprimer</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="addFiliereForm" class="form-container" style="display: none;">
        <h3>Ajouter une filiere</h3>
        <form method="post">
            <div class="form-group">
                <label for="new_filiere_name">Nom de la filière :</label>
                <input type="text" class="form-control" id="new_filiere_name" name="new_filiere_name" required>
            </div>
            <div class="form-group">
                <label for="new_filiere_department">Département :</label>
                <select class="form-control" id="new_filiere_department" name="new_filiere_department" required>
                    <?php foreach ($departments as $department) : ?>
                        <option value="<?= (int) $department['id']; ?>"><?= (string) $department['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="add_filiere">Ajouter</button>
            <button type="button" class="btn btn-secondary" onclick="hideAddFiliereForm()">Annuler</button>
        </form>
    </div>

    <!-- Form for Modifying filieres -->
    <?php foreach ($filieres as $filiere) : ?>
        <div id="modifyFiliereForm<?= (int) $filiere['id']; ?>" class="form-container" style="display: none;">
            <h3>Modifier la filière</h3>
            <form method="post">
                <input type="hidden" name="modify_filiere_id" value="<?= (int) $filiere['id']; ?>">
                <div class="form-group">
                    <label for="modify_filiere_name">Nom de la filière :</label>
                    <input type="text" class="form-control" id="modify_filiere_name" name="modify_filiere_name" value="<?= (string) $filiere['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="modify_filiere_department">Département :</label>
                    <select class="form-control" id="modify_filiere_department" name="modify_filiere_department" required>
                        <?php foreach ($departments as $department) : ?>
                            <option value="<?= (int) $department['id']; ?>" <?= ($filiere['department'] == $department['id']) ? 'selected' : ''; ?>>
                                <?= (string) $department['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning" name="modify_filiere">Modifier</button>
                <button type="button" class="btn btn-secondary" onclick="hideModifyFiliereForm(<?= (int) $filiere['id']; ?>)">Annuler</button>
            </form>
        </div>
    <?php endforeach; ?>

    <!-- Form for Deleting filiere -->
    <?php foreach ($filieres as $filiere) : ?>
        <div id="deleteFiliereForm<?= (int) $filiere['id']; ?>" class="form-container" style="display: none;">
            <h3>Supprimer la filière</h3>
            <p>Êtes-vous sûr de vouloir supprimer la filière "<?= (string) $filiere['name']; ?>" ?</p>
            <form method="post">
                <input type="hidden" name="delete_filiere_id" value="<?= (int) $filiere['id']; ?>">
                <button type="submit" class="btn btn-danger" name="delete_filiere">Supprimer</button>
                <button type="button" class="btn btn-secondary" onclick="hideDeleteFiliereForm(<?= (int) $filiere['id']; ?>)">Annuler</button>
            </form>
        </div>
    <?php endforeach; ?>
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

    <script>
        function showAddFiliereForm() {
            document.getElementById('addFiliereForm').style.display = 'block';
        }

        function hideAddFiliereForm() {
            document.getElementById('addFiliereForm').style.display = 'none';
        }

        function showModifyFiliereForm(filiereId) {
            document.getElementById('modifyFiliereForm' + filiereId).style.display = 'block';
        }

        function hideModifyFiliereForm(filiereId) {
            document.getElementById('modifyFiliereForm' + filiereId).style.display = 'none';
        }

        function showDeleteFiliereForm(filiereId) {
            document.getElementById('deleteFiliereForm' + filiereId).style.display = 'block';
        }

        function hideDeleteFiliereForm(filiereId) {
            document.getElementById('deleteFiliereForm' + filiereId).style.display = 'none';
        }
    </script>
</body>

</html>