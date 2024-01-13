<?php
// Load XML file
$xml = simplexml_load_file('xml/DATA2.xml');

// Function to save changes to the XML file
function saveXML($xml, $file)
{
    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($file);
}

// Retrieve departments data
$departments = $xml->xpath('//department');

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new department
    if (isset($_POST["add_department"])) {
        $newDepartmentID = max(array_map('intval', $xml->xpath('//department/@id'))) + 1;
        $newDepartmentName = $_POST["new_department_name"];

        $newDepartment = $xml->departments->addChild('department');
        $newDepartment->addAttribute('id', $newDepartmentID);
        $newDepartment->addAttribute('name', $newDepartmentName);

        saveXML($xml, 'xml/DATA2.xml');
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after adding a department
        exit();
    }

    // Modify department
    if (isset($_POST["modify_department"])) {
        $departmentID = $_POST["modify_department_id"];
        $departmentName = $_POST["modify_department_name"];

        $department = $xml->xpath("//department[@id='$departmentID']")[0];
        $department['name'] = $departmentName;

        saveXML($xml, 'xml/DATA2.xml');
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after modifying a department
        exit();
    }

    // Delete department
    if (isset($_POST["delete_department"])) {
        $departmentID = $_POST["delete_department_id"];

        $department = $xml->xpath("//department[@id='$departmentID']")[0];
        unset($department[0]);

        saveXML($xml, 'xml/DATA2.xml');
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh the page after deleting a department
        exit();
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
    main {
        background-image: url('img/photos/backgroundzlij.jpg');
        background-size: auto;
        background-position: center;
        margin: 0;
        padding: 0;
    }

    .table-container {
        width: 100%;
        max-height: 500px;
        /* Adjust the height as needed */
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
                    <li class="sidebar-item active">
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
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Gestion</strong> des départements</h1>

                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="showAddDepartmentForm()">Ajouter un département</button>
                    </div>

                    <div class="card">
                        <h5 class="card-header">Liste des départements</h5>

                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Departement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($departments as $department) : ?>
                                        <tr>
                                            <td><?= (int) $department['id']; ?></td>
                                            <td><?= (string) $department['name']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="showModifyDepartmentForm(<?= (int) $department['id']; ?>)">Modifier</button>
                                                <button class="btn btn-sm btn-danger" onclick="showDeleteDepartmentForm(<?= (int) $department['id']; ?>)">Supprimer</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form for Adding Department -->
                    <div id="addDepartmentForm" class="form-container" style="display: none;">
                        <h3>Ajouter un département</h3>
                        <form method="post">
                            <div class="form-group">
                                <label for="new_department_name">Nom du département :</label>
                                <input type="text" class="form-control" id="new_department_name" name="new_department_name" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_department">Ajouter</button>
                            <button type="button" class="btn btn-secondary" onclick="hideAddDepartmentForm()">Annuler</button>
                        </form>
                    </div>

                    <!-- Form for Modifying Department -->
                    <?php foreach ($departments as $department) : ?>
                        <div id="modifyDepartmentForm<?= (int) $department['id']; ?>" class="form-container" style="display: none;">
                            <h3>Modifier le département</h3>
                            <form method="post">
                                <input type="hidden" name="modify_department_id" value="<?= (int) $department['id']; ?>">
                                <div class="form-group">
                                    <label for="modify_department_name">Nom du département :</label>
                                    <input type="text" class="form-control" id="modify_department_name" name="modify_department_name" value="<?= (string) $department['name']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-warning" name="modify_department">Modifier</button>
                                <button type="button" class="btn btn-secondary" onclick="hideModifyDepartmentForm(<?= (int) $department['id']; ?>)">Annuler</button>
                            </form>
                        </div>
                    <?php endforeach; ?>

                    <!-- Form for Deleting Department -->
                    <?php foreach ($departments as $department) : ?>
                        <div id="deleteDepartmentForm<?= (int) $department['id']; ?>" class="form-container" style="display: none;">
                            <h3>Supprimer le département</h3>
                            <p>Êtes-vous sûr de vouloir supprimer le département "<?= (string) $department['name']; ?>" ?</p>
                            <form method="post">
                                <input type="hidden" name="delete_department_id" value="<?= (int) $department['id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_department">Supprimer</button>
                                <button type="button" class="btn btn-secondary" onclick="hideDeleteDepartmentForm(<?= (int) $department['id']; ?>)">Annuler</button>
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
        function showAddDepartmentForm() {
            document.getElementById('addDepartmentForm').style.display = 'block';
        }

        function hideAddDepartmentForm() {
            document.getElementById('addDepartmentForm').style.display = 'none';
        }

        function showModifyDepartmentForm(departmentId) {
            document.getElementById('modifyDepartmentForm' + departmentId).style.display = 'block';
        }

        function hideModifyDepartmentForm(departmentId) {
            document.getElementById('modifyDepartmentForm' + departmentId).style.display = 'none';
        }

        function showDeleteDepartmentForm(departmentId) {
            document.getElementById('deleteDepartmentForm' + departmentId).style.display = 'block';
        }

        function hideDeleteDepartmentForm(departmentId) {
            document.getElementById('deleteDepartmentForm' + departmentId).style.display = 'none';
        }
    </script>
</body>

</html>
