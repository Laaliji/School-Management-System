<?php
// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to update or add data to the XML file
function updateXML($xmlFile, $formData) {
    // Load the existing XML file
    $xml = simplexml_load_file($xmlFile);

    // Create a new user element
    $user = $xml->users->addChild('user');
    $user->addAttribute('username', sanitizeInput($formData['personal']['username']));
    $user->addAttribute('password', sanitizeInput($formData['personal']['password']));
    $user->addAttribute('role', 'student'); // Assuming the role is always 'student'

    // Create a new student element
    $student = $xml->students->addChild('student');
    $student->addAttribute('id', sanitizeInput($formData['personal']['id']));
    $student->addAttribute('username', sanitizeInput($formData['personal']['username']));

    // Create details element for the student
    $details = $student->addChild('details');

    // Populate details with form data
    $details->addChild('fullname')->addChild('fname', sanitizeInput($formData['personal']['fname']));
    $details->fullname->addChild('lname', sanitizeInput($formData['personal']['lname']));
    $details->addChild('birthdate', sanitizeInput($formData['personal']['birthdate']));
    $details->addChild('tel', sanitizeInput($formData['personal']['tel']));
    $details->addChild('email', sanitizeInput($formData['personal']['email']));
    $details->addChild('cin', sanitizeInput($formData['personal']['cin']));
    $details->addChild('cne', sanitizeInput($formData['academic']['cne']));
    $details->addChild('apoge', sanitizeInput($formData['academic']['apoge']));
    $details->addChild('adresse', sanitizeInput($formData['personal']['adresse']));
    $details->addChild('mark', '0'); // Assuming the mark is always '0'

    // Save the updated XML file
    $xml->asXML($xmlFile);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set the path to your XML file
    $xmlFilePath = 'path/to/DATA2.xml';

    // Get form data
    $formData = [
        'personal' => [
            'id' => $_POST['id'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'birthdate' => $_POST['birthdate'],
            'tel' => $_POST['tel'],
            'email' => $_POST['email'],
            'cin' => $_POST['cin'],
            'adresse' => $_POST['adresse']
        ],
        'academic' => [
            'cne' => $_POST['cne'],
            'apoge' => $_POST['apoge']
            // Add other academic fields as needed
        ]
    ];

    // Update or add data to the XML file
    updateXML($xmlFilePath, $formData);

    // You can redirect the user to a success page or perform other actions as needed
    header('Location: success_page.php');
    exit();
} else {
    // Handle invalid request (e.g., direct access to this script)
    header('Location: error_page.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Multi-step form</title>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'><link rel="stylesheet" href="./style.css">

<style>

    *{
    margin: 0;
    padding: 0;
}

html{
    height: 100%;
}

p{
    color: grey;
}

#heading{
    text-transform: uppercase;
    color: #673AB7;
    font-weight: normal;
}

#msform{
    text-align: center;
    position: relative;
    margin-top: 20px;
}

#msform fieldset{
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative;
}

.form-card{
    text-align: center;
}

#msform fieldset:not(:first-of-type){
    display: none;
}

#msform input, #msform textarea{
    padding: 8px 15px 8px 15px;
    border: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    color: #2C3E50;
    background-color: #ECEFF1;
    font-size: 16px;
    letter-spacing: 1px;
}

#msform input:focus, #msform textarea:focus{
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: px solid #673AB7;
    outline-width: 0;
}

#msform .action-button{
    width: 100px;
    background: #673AB7;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 0px 10px 5px;
    float: right;
}
#msform .action-button:hover,
#msform .action-button:focus {
    background-color: #311B92
}

#msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px 10px 0px;
    float: right
}

#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
    background-color: #000000
}

.card {
    z-index: 0;
    border: none;
    position: relative
}

.fs-title {
    font-size: 25px;
    color: #673AB7;
    margin-bottom: 15px;
    font-weight: normal;
    text-align: left
}

.purple-text {
    color: #673AB7;
    font-weight: normal
}

.steps {
    font-size: 25px;
    color: gray;
    margin-bottom: 10px;
    font-weight: normal;
    text-align: right
}

.fieldlabels {
    color: gray;
    text-align: left
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey
}

#progressbar .active {
    color: #673AB7
}

#progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f13e"
}

#progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f007"
}

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f030"
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #673AB7
}

.progress {
    height: 20px
}

.progress-bar {
    background-color: #673AB7
}

.fit-image {
    width: 100%;
    object-fit: cover
}



</style>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-10 col-md-10 col-lg-6 col-xl-5 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2 id="heading">Sign Up Your User Account</h2>
                <p>Fill all form field to go to next step</p>
                <form id="msform" action="index.php" method="POST">
                <ul id="progressbar">
                        <li class="active" id="personal"><strong>Informations Personnelles</strong></li>
                        <li id="academic"><strong>Informations Academiques</strong></li>
                        <li id="choice"><strong>Choix de Candidature</strong></li>
                    </ul>
                    <!-- Fieldsets -->
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Informations Personnelles:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 1 - 3</h2>
                                </div>
                            </div>
                            <label class="fieldlabels">First Name: *</label>
                            <input type="text" name="fname" placeholder="First Name" required />
                            <label class="fieldlabels">Last Name: *</label>
                            <input type="text" name="lname" placeholder="Last Name" required />
                            <label class="fieldlabels">Email: *</label>
                            <input type="email" name="email" placeholder="Email" required />
                            <label class="fieldlabels">CIN: *</label>
                            <input type="text" name="cin" placeholder="CIN" required />
                            <label class="fieldlabels">Birthdate: *</label>
                            <input type="text" name="birthdate" placeholder="Birthdate" required />
                            <label class="fieldlabels">Tel: *</label>
                            <input type="text" name="tel" placeholder="Tel" required />
                            <label class="fieldlabels">Adresse: *</label>
                            <input type="text" name="adresse" placeholder="Adresse" required />
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Informations Academiques:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 2 - 3</h2>
                                </div>
                            </div>
                            <label class="fieldlabels">CNE: *</label>
                            <input type="text" name="cne" placeholder="CNE" required />
                            <label class="fieldlabels">Numero Apoge: *</label>
                            <input type="text" name="apoge" placeholder="Numero Apoge" required />
                            <label class="fieldlabels">Moyen Regional: *</label>
                            <input type="text" name="moyen_regional" placeholder="Moyen Regional" required />
                            <label class="fieldlabels">Moyen National: *</label>
                            <input type="text" name="moyen_national" placeholder="Moyen National" required />
                            <label class="fieldlabels">Moyen General: *</label>
                            <input type="text" name="moyen_general" placeholder="Moyen General" required />
                            <label class="fieldlabels">Classement de Bac: *</label>
                            <input type="text" name="classement_bac" placeholder="Classement de Bac" required />
                            <label class="fieldlabels">Mention: *</label>
                            <input type="text" name="mention" placeholder="Mention" required />
                            <label class="fieldlabels">Date Obtention de Bac: *</label>
                            <input type="text" name="date_obtention_bac" placeholder="Date Obtention de Bac" required />
                            <label class="fieldlabels">Ville de Bac: *</label>
                            <input type="text" name="ville_bac" placeholder="Ville de Bac" required />
                        </div>
                        <input type="button" name="next" class="next action-button" value="Next" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    </fieldset>
                    <fieldset>
                        <div class="form-card">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="fs-title">Choix de Candidature:</h2>
                                </div>
                                <div class="col-5">
                                    <h2 class="steps">Step 3 - 3</h2>
                                </div>
                            </div>
                            <!-- Load the filieres dynamically from XML here -->
                            <label class="fieldlabels">Choose Filiere: *</label>
                            <select name="filiere" required>
                                <option value="" disabled selected>Select Filiere</option>
                                <!-- Add options dynamically from XML using JavaScript -->
                            </select>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                        <input type="submit" name="submit" class="submit action-button" value="Submit" />
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="./script.js"></script>
<script>
    $(document).ready(function () {
        var current_fs, next_fs, previous_fs;
        var opacity;
        var current = 1;
        var steps = $("fieldset").length;

        setProgressBar(current);

        $(".next").click(function () {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            next_fs.show();
            current_fs.animate({ opacity: 0 }, {
                step: function (now) {
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });
            setProgressBar(++current);
        });

        $(".previous").click(function () {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            previous_fs.show();

            current_fs.animate({ opacity: 0 }, {
                step: function (now) {
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });
            setProgressBar(--current);
        });

        function setProgressBar(curStep) {
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width", percent + "%")
        }

        $(".submit").click(function () {
            // Handle form submission here
            submitForm();
            return false;
        });

        // Fetch and populate filieres dynamically from XML
        fetchFilieres();
    });

    // Function to fetch filieres from XML and populate the dropdown
    function fetchFilieres() {
        // You can use AJAX to fetch data from XML
        // For simplicity, let's use a sample data here
        var sampleFilieres = [
            { id: 101, name: "Génie Informatique" },
            { id: 102, name: "Intelligence Artificielle" },
            { id: 103, name: "Techniques de Management" },
            { id: 104, name: "Genie Electrique" }
            // Add more filieres as needed
        ];

        var filiereDropdown = $("select[name='filiere']");
        filiereDropdown.empty();
        filiereDropdown.append('<option value="" disabled selected>Select Filiere</option>');

        // Populate filieres dropdown with options from XML
        sampleFilieres.forEach(function (filiere) {
            filiereDropdown.append('<option value="' + filiere.id + '">' + filiere.name + '</option>');
        });
    }

    function submitForm() {
        // Handle form submission and XML data creation here
        var formData = {
            personal: {
                fname: $("input[name='fname']").val(),
                lname: $("input[name='lname']").val(),
                email: $("input[name='email']").val(),
                cin: $("input[name='cin']").val(),
                birthdate: $("input[name='birthdate']").val(),
                tel: $("input[name='tel']").val(),
                adresse: $("input[name='adresse']").val()
            },
            academic: {
                cne: $("input[name='cne']").val(),
                apoge: $("input[name='apoge']").val(),
                moyen_regional: $("input[name='moyen_regional']").val(),
                moyen_national: $("input[name='moyen_national']").val(),
                moyen_general: $("input[name='moyen_general']").val(),
                classement_bac: $("input[name='classement_bac']").val(),
                mention: $("input[name='mention']").val(),
                date_obtention_bac: $("input[name='date_obtention_bac']").val(),
                ville_bac: $("input[name='ville_bac']").val()
            },
            choice: {
                filiere: $("select[name='filiere']").val()
            }
        };

        // You can use AJAX to send formData to the server and update XML
        // For simplicity, let's log the formData to console
        console.log("Form Data:", formData);
    }
</script>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script><script  src="./script.js"></script>

</body>
</html>
