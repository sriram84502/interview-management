<?php 
    session_start();
    if($_SESSION['role']==1)
    {
        header('Location: 404');
        exit();
    }
    if($_SESSION['role']==0)
    {
        header('Location: 404');
        exit();
    }
    if (!isset($_SESSION['user_email'])) {
        header('Location: index');
        exit();
    }
    include 'conn.php';
    $query = "SELECT email FROM candidate_info ORDER BY name ASC";
    $result = $conn->query($query);
    $names = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $names[] = $row['email'];
        }
    }
    if(isset($_POST["submit"])){
        $_SESSION['selected_email'] = $_POST['name'];
        echo '<script> alert('.$_SESSION['selected_email'].')</script>';
        header('Location: administrations');
        exit();
    }
    $query = "SELECT COUNT(*) as total FROM apply";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
    } else {
        echo "Error: " . $conn->error;
        $total = 0; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/iofrm-theme15.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
    <style>
        #myList li:hover {
            cursor: pointer;
        }
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
        #myList {
            max-height: 250px;
            overflow-y: auto;
        }
        #myList::-webkit-scrollbar {
            display: none;
        }
        #myList {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #myList li:hover {
            cursor: pointer;
        }

        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .button-container {
            position: relative;
            display: inline-block;
        }

        .count-indicator {
            position: absolute;
            top: 0;
            right: 0;
            background-color: blue;
            color: white;
            border-radius: 50%;
            padding: 1px 5px 1px 5px;
            font-size: 10px;
        }

    </style>
</head>
<body>
    <div class="form-body">
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder" style="top: 5%; right: 35%; width: auto; height: 100px;">
                    <img src="./assets/images/logo1-dark.png" alt="" srcset="" height="100px" style="width: auto;">
                </div>
                <div class="info-holder">
                    <h3>Welcome back, <?php echo ''.$_SESSION['name'].'';?></h3>
                    <!-- <p><b>Complete Personal Details:</b><br>&nbsp; Start by filling in your name, contact information, and address accurately. <br><br>
                        <b>Educational Background:</b><br>&nbsp; Detail your degrees, certifications, and any specialties. <br><br>
                        <b>Teaching Experience:</b><br>&nbsp; Outline your experience, subjects taught, and any notable achievements. <br><br>
                        <b>Submit Supporting Documents:</b><br>&nbsp; Attach your resume, cover letter, and any relevant certifications. <br></p> -->
                </div>
            </div>
            <div class="form-holder">
                <form action="logout" method="post" style="margin:10px 20px;display:flex;justify-content:end;gap:10px; align-items: end;">
                    <a href="manage-users" style="text-decoration: none; "><button type="button" class="btn btn-outline-info">Manage Users</button></a>
                    <div class="button-container">
                        <a href="re-apply" style="text-decoration: none; "><button type="button" class="btn btn-outline-primary">Re-Applied</button></a>
                        <div class="count-indicator"><?php echo $total ?></div>
                    </div>
                    <a href="results" style="text-decoration: none; "><button type="button" class="btn btn-outline-success">Results</button></a>
                    <button type="submit" class="btn btn-outline-danger" name="logout" placeholder="logout">logout</button>
                </form>
                <div class="form-content form-sm">
                    <div class="form-items">
                        <h3 class="form-title">Complete the form</h3>
                        <form action="admin" method="post" id="firstform">
                            <div class="form-group">
                                <label>Personal Information</label>
                                <input class="form-control" id="myInput" name="name" type="text" placeholder="Email of the candidate">
                                <ul class="list-group" id="myList">
                                    <?php foreach ($names as $name): ?>
                                        <li class="list-group-item"><?php echo htmlspecialchars($name); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="form-button text-right">
                                <button id="submit" type="submit" name="submit" class="ibtn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
$(document).ready(function() {
    // Initially hide the list
    $('#myList').hide();

    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        
        if (value) {
            $('#myList').show();
        } else {
            $('#myList').hide();
        }

        $("#myList li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    $("#myList li").click(function() {
        $("#myInput").val($(this).text());

        // Hide the list after selection
        $('#myList').hide();
    });
});
</script>
</body>
</html>