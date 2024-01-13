<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-step Form</title>
    <style>
        /* Add this CSS code to a file named styles.css */

body {
    font-family: 'Arial', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    background-color: #f4f4f4;
}

.container {
    width: 50%;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
}

#progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 33.33%;
    float: left;
    position: relative;
    font-weight: bold;
}

#progressbar li:before {
    content: '\025B8'; /* Unicode character for small filled right arrow */
    font-size: 24px;
    color: lightgrey;
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #673AB7;
    color: white;
}

#progressbar li.active {
    color: #673AB7;
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgrey;
    position: absolute;
    left: 0;
    top: 15px;
    z-index: -1;
}

fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative;
    display: none;
}

fieldset:first-child {
    display: block;
}

input[type="text"],
select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
    width: 100%;
}

input[type="button"],
input[type="submit"],
input[type="reset"] {
    background-color: #673AB7;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
}

input[type="button"]:hover,
input[type="submit"]:hover,
input[type="reset"]:hover {
    background-color: #311B92;
}

.action-button-previous {
    background-color: #616161;
    margin-right: 10px;
}

.action-button-previous:hover {
    background-color: #000000;
}

    </style>
</head>
<body>

<div class="container">
    <form id="msform" action="process_form.php" method="POST">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active">Step 1</li>
            <li>Step 2</li>
            <li>Step 3</li>
        </ul>
        <!-- fieldsets -->
        <fieldset>
            <h2 class="fs-title">Step 1</h2>
            <input type="text" name="field1" placeholder="Field 1" required />
            <input type="text" name="field2" placeholder="Field 2" required />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Step 2</h2>
            <input type="text" name="field3" placeholder="Field 3" required />
            <input type="text" name="field4" placeholder="Field 4" required />
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Step 3</h2>
            <select name="choice" required>
                <option value="" disabled selected>Select Choice</option>
                <option value="Option 1">Option 1</option>
                <option value="Option 2">Option 2</option>
            </select>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="submit" name="submit" class="submit action-button" value="Submit" />
        </fieldset>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var current_fs, next_fs, previous_fs; // fieldsets
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
            $(".progress-bar").css("width", percent + "%");
        }

        $(".submit").click(function () {
            return false;
        });
    });
</script>

</body>
</html>
