<?php
    session_start();
    if (!isset($_SESSION['user_email'])) {
        header('Location: index');
        exit;
    }
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
    $query = "SELECT * FROM candidate WHERE role=1;";
    $result = $conn->query($query);
    $emails = [];
    $name = [];
    $email = [];
    $branch = [];
    $status = [];
    $pan = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }
    }
    for($i=0;$i<count($emails);$i=$i+1){
        $query = "SELECT * FROM candidate_marks WHERE email='$emails[$i]' GROUP BY email";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $name[] = $row['name'];
                $email[] = $row['email'];
                $branch[] = $row['branch'];
                $status[] = 0;
                $pan[] = $row['pan'];
            }
        }
        else{
            $query1 = "SELECT * FROM candidate_info WHERE email='$emails[$i]' GROUP BY email";
            $result1 = $conn->query($query1);
            if ($result1->num_rows > 0) {
                while($row = $result1->fetch_assoc()) {
                    $name[] = $row['name'];
                    $email[] = $row['email'];
                    $branch[] = $row['branch'];
                    $status[] = 1;
                    $pan[] = $row['pan'];
                }
            }
            else{
                $query2 = "SELECT * FROM candidate WHERE email='$emails[$i]' GROUP BY email";
                $result2 = $conn->query($query2);
                if ($result2->num_rows > 0) {
                    while($row = $result2->fetch_assoc()) {
                        $name[] = $row['name'];
                        $email[] = $row['email'];
                        $branch[] = 'N/A';
                        $status[] = 2;
                        $pan[] = $row['pan'];
                    }
                }
            }
        }
    }

    for($i=0;$i<count($emails);$i=$i+1){
        $query = "SELECT * FROM candidate_info WHERE email='$emails[$i]' GROUP BY email";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $idate[] = $row['date'];
            }
        }
        else{
            $idate[] = date("Y-m-d");
        }
    }

    if(isset($_POST["submit"])){
        $selected_email = $_POST['userEmail'];
        $sql3 = "DELETE from candidate WHERE email='$selected_email'";
        if ($conn->query($sql3) === TRUE) {
            echo "<script>alert('deleted successfully...')</script>";
            header("Location: manage-users");
        }else {
            echo '<script>alert("failed")</script>';
            echo $conn->error;
        }
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
    if(isset($_POST["submit1"])){
        $_SESSION['downloadEmail'] = $_POST['userEmail1'];
        echo '<script> alert('.$_SESSION['downloadEmail'].')</script>';
        header('Location: final-results');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
    <style>

        /* Hide the default arrow */
        .form-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding-right: 30px; /* Adjust padding to prevent text overlap with icon */
        }

        /* Style the wrapper */
        .custom-select-wrapper {
            position: relative;
        }

        /* Style and position the SVG icon */
        .custom-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none; /* Allows clicks to pass through to the select element */
        }


        /* Hide the default arrow */
        .form-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
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
<div class="d-flex float-right">
    <div class="row mr-5 d-flex align-items-center justify-content-center">
        <div class="col-md-4 custom-select-wrapper">
            <select id="filterType" class="form-select px-2 py-2" style="border-radius: 6px;">
                <option>Filter By</option>
                <option value="0">Name</option>
                <option value="1">Applied on   &nbsp;&nbsp;&nbsp;</option>
                <option value="2">Branch</option>
                <option value="3">Status</option>
            </select>
            <div class="custom-icon">
                <!-- SVG code -->
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                </svg>
            </div>
        </div>
        <div class="col-md-8">
            <input type="text" id="searchQuery" onkeyup="filterTable()" class="form-control" placeholder="Search...">
        </div>
    </div>
    <form action="logout" method="post" style="margin:10px 20px;display:flex;justify-content:end;gap:10px; align-items: end;">
        <a href="manage-users" style="text-decoration: none; "><button type="button" class="btn btn-outline-info">Manage Users</button></a>
        <div class="button-container">
            <a href="re-apply" style="text-decoration: none; "><button type="button" class="btn btn-outline-primary">Re-Applied</button></a>
            <div class="count-indicator"><?php echo $total ?></div>
        </div>
        <a href="results" style="text-decoration: none; "><button type="button" class="btn btn-outline-success">Results</button></a>
        <button type="submit" class="btn btn-outline-danger" name="logout" placeholder="logout">logout</button>
    </form>
</div>
    <table id="dataTable" class="table table-centered text-center mb-0">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>PAN</th>
                <th>Applied on</th>
                <th>Branch</th>
                <th>Status</th>
                <th>Send a mail / View / Delete Account </th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($emails); $i++): ?>
                <tr>
                    <td class="text-uppercase"><?php echo $name[$i] ?></td>
                    <td class="text-uppercase"><?php echo $pan[$i] ?></td>
                    <td class="text-uppercase"><?php echo $idate[$i] ?></td>
                    <td class="text-uppercase"><?php echo $branch[$i] ?></td>
                    <td>
                    <span class="badge 
                        <?php echo isset($status[$i]) ?
                            ($status[$i] == 0 ? 'bg-success text-white' : ($status[$i] == 1 ? 'bg-primary text-white' : 'bg-secondary text-white')) :
                            'bg-secondary text-white'; ?>">
                        <?php echo isset($status[$i]) ?
                            ($status[$i] == 0 ? 'Interview Completed' : ($status[$i] == 1 ? 'Applied' : 'Registered')) :
                            'Unknown'; ?>
                    </span>
                    </td>
                    <td class="d-flex gap-3 flex-wrap align-content-center justify-content-center">
                        <button type="button" class="mr-2 btn btn-outline-primary">Send mail</button>
                        <form action="manage-users" style="display:contents" method="post">
                            <input type="hidden" name="userEmail1" value="<?php echo htmlspecialchars($email[$i]); ?>">
                            <button type="submit" name="submit1" class="btn btn-outline-success mr-2">View</button>
                        </form>
                        <!-- <button type="button" class="mr-2 btn btn-outline-success">Selected</button> -->
                        <form action="manage-users" method="POST">
                            <input type="hidden" name="userEmail" value="<?php echo htmlspecialchars($email[$i]); ?>">
                            <button type="submit" name="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
    function filterTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchQuery");
        filter = input.value.toUpperCase();
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");
        var filterType = document.getElementById("filterType").value;

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[filterType]; // Select the column to filter on
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    document.addEventListener('DOMContentLoaded', (event) => {
    sortTableByDate();
});

function sortTableByDate() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("dataTable"); // Replace with your table's ID
    switching = true;

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[1]; // Replace 1 with your date column index
            y = rows[i + 1].getElementsByTagName("TD")[1]; // Replace 1 with your date column index

            // Compare the dates in descending order
            if (new Date(x.innerHTML) < new Date(y.innerHTML)) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

</script>
</html>