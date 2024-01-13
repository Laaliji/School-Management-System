<?php
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function updateXML($xmlFile, $formData) {
    $xml = simplexml_load_file($xmlFile);

    // Update or add user details
    $user = $xml->xpath("//user[@username='{$formData['personal']['username']}']")[0];
    if (!$user) {
        $user = $xml->users->addChild('user');
        $user->addAttribute('username', sanitizeInput($formData['personal']['username']));
        $user->addAttribute('password', sanitizeInput($formData['personal']['password']));
        $user->addAttribute('role', 'student');
    }

    // Update or add student details
    $student = $xml->xpath("//student[@username='{$formData['personal']['username']}']")[0];
    if (!$student) {
        $student = $xml->students->addChild('student');
        $student->addAttribute('id', sanitizeInput($formData['personal']['id']));
        $student->addAttribute('username', sanitizeInput($formData['personal']['username']));
    }

    // Update or add personal details
    $details = $student->details;
    if (!$details) {
        $details = $student->addChild('details');
    }

    $details->fname = sanitizeInput($formData['personal']['fname']);
    $details->lname = sanitizeInput($formData['personal']['lname']);
    $details->birthdate = sanitizeInput($formData['personal']['birthdate']);
    $details->tel = sanitizeInput($formData['personal']['tel']);
    $details->email = sanitizeInput($formData['personal']['email']);
    $details->cin = sanitizeInput($formData['personal']['cin']);
    $details->adresse = sanitizeInput($formData['personal']['adresse']);

    // Update or add academic details
    $details->cne = sanitizeInput($formData['academic']['cne']);
    $details->apoge = sanitizeInput($formData['academic']['apoge']);
    $details->moyen_regional = sanitizeInput($formData['academic']['moyen_regional']);
    $details->moyen_national = sanitizeInput($formData['academic']['moyen_national']);
    $details->moyen_general = sanitizeInput($formData['academic']['moyen_general']);
    $details->classement_bac = sanitizeInput($formData['academic']['classement_bac']);
    $details->mention = sanitizeInput($formData['academic']['mention']);
    $details->date_obtention_bac = sanitizeInput($formData['academic']['date_obtention_bac']);
    $details->ville_bac = sanitizeInput($formData['academic']['ville_bac']);

    // Update or add choice details
    $choice = $student->choice;
    if (!$choice) {
        $choice = $student->addChild('choice');
    }
    $choice->filiere = sanitizeInput($formData['choice']['filiere']);

    $xml->asXML($xmlFile);
}

function fetchFiliereOptions() {
    // Fetch and return filieres from your XML file
    $xmlFilePath = 'DATA2.xml';
    $xml = simplexml_load_file($xmlFilePath);

    $filiereOptions = [];
    foreach ($xml->filieres->filiere as $filiere) {
        $filiereOptions[] = (string)$filiere['name'];
    }

    return $filiereOptions;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlFilePath = 'DATA2.xml';

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
            'apoge' => $_POST['apoge'],
            'moyen_regional' => $_POST['moyen_regional'],
            'moyen_national' => $_POST['moyen_national'],
            'moyen_general' => $_POST['moyen_general'],
            'classement_bac' => $_POST['classement_bac'],
            'mention' => $_POST['mention'],
            'date_obtention_bac' => $_POST['date_obtention_bac'],
            'ville_bac' => $_POST['ville_bac']
        ],
        'choice' => [
            'filiere' => $_POST['filiere']
        ]
    ];

    // Add server-side validation as needed

    updateXML($xmlFilePath, $formData);

    // Fetch and populate filieres dynamically from XML
    $filiereOptions = fetchFiliereOptions();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multi-step form</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css'>

    <style>
        
    *{
    margin: 0;
    padding: 0;
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
    font-weight: 400px;
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
<!-- Your existing HTML code -->
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
                            <label class="fieldlabels">Username: *</label>
                            <input type="text" name="username" placeholder="Username" required />
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
                            <?php
                            // Populate filieres dynamically from PHP array
                            foreach ($filiereOptions as $filiereName) {
                                echo '<option value="' . $filiereName . '">' . $filiereName . '</option>';
                            }
                            ?>
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

    <script>
        
        $(document).ready(function(){

var current_fs, next_fs, previous_fs; //fieldsets
var opacity;
var current = 1;
var steps = $("fieldset").length;

setProgressBar(current);

$(".next").click(function(){

current_fs = $(this).parent();
next_fs = $(this).parent().next();

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
next_fs.show();
//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 500
});
setProgressBar(++current);
});

$(".previous").click(function(){

current_fs = $(this).parent();
previous_fs = $(this).parent().prev();

//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 500
});
setProgressBar(--current);
});

function setProgressBar(curStep){
var percent = parseFloat(100 / steps) * curStep;
percent = percent.toFixed();
$(".progress-bar")
.css("width",percent+"%")
}

$(".submit").click(function(){
return false;
})

});
</script>


</body>
</html>
