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
    $email = $_SESSION['downloadEmail'];
    $query = "SELECT * FROM candidate_allocation WHERE email='$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $t1 = $row['teacher1'];
            $t2 = $row['teacher2'];
            $t3 = $row['teacher3'];
            $t1name = $row['t1name'];
            $t2name = $row['t2name'];
            $t3name = $row['t3name'];
        }
    }
    $query1 = "SELECT * FROM candidate_info WHERE email='$email'";
    $result1 = $conn->query($query1);
    if ($result1->num_rows > 0) {
        while($row = $result1->fetch_assoc()) {
            $iname = $row['name'];
            $iphone = $row['phone'];
            $idob = $row['dob'];
            $iage = $row['age'];
            $ibranch = $row['branch'];
            $iaddress = $row['place_of_stay'];
            $image = $row['image'];
            $icaste = $row['category'];
            $texp = $row['exp_teaching'];
            $iexp = $row['exp_industry'];
            $idate = $row['date'];
        }
    }
    $t1m1 = $t1m2 = $t1m3 = $t1m4 = $t2m1 = $t2m2 = $t2m3 = $t2m4 = $t3m1 = $t3m2 = $t3m3 = $t3m4 = $t1remarks = $t2remarks = $t3remarks = $t1total = $t2total = $t3total = '-';
    $query2 = "SELECT * FROM candidate_marks WHERE email='$email' and interviewer='$t1'";
    $result2 = $conn->query($query2);
    if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $t1m1 = $row['m1'];
            $t1m2 = $row['m2'];
            $t1m3 = $row['m3'];
            $t1m4 = $row['m4'];
            $t1total = $row['total'];
            $t1remarks = $row['remarks'];
        }
    }
    $query3 = "SELECT * FROM candidate_marks WHERE email='$email' and interviewer='$t2'";
    $result3 = $conn->query($query3);
    if ($result3->num_rows > 0) {
        while($row = $result3->fetch_assoc()) {
            $t2m1 = $row['m1'];
            $t2m2 = $row['m2'];
            $t2m3 = $row['m3'];
            $t2m4 = $row['m4'];
            $t2total = $row['total'];
            $t2remarks = $row['remarks'];
        }
    }
    $query4 = "SELECT * FROM candidate_marks WHERE email='$email' and interviewer='$t3'";
    $result4 = $conn->query($query4);
    if ($result4->num_rows > 0) {
        while($row = $result4->fetch_assoc()) {
            $t3m1 = $row['m1'];
            $t3m2 = $row['m2'];
            $t3m3 = $row['m3'];
            $t3m4 = $row['m4'];
            $t3total = $row['total'];
            $t3remarks = $row['remarks'];
        }
    }

    $query5 = "SELECT * FROM candidate WHERE email='$t1'";
    $result5 = $conn->query($query5);
    if ($result5->num_rows > 0) {
        while($row = $result5->fetch_assoc()) {
            $t1name = $row['name'];
        }
    }

    $query6 = "SELECT * FROM candidate WHERE email='$t2'";
    $result6 = $conn->query($query6);
    if ($result6->num_rows > 0) {
        while($row = $result6->fetch_assoc()) {
            $t2name = $row['name'];
        }
    }

    $query7 = "SELECT * FROM candidate WHERE email='$t3'";
    $result7 = $conn->query($query7);
    if ($result7->num_rows > 0) {
        while($row = $result7->fetch_assoc()) {
            $t3name = $row['name'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Sheet</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .marks-sheet {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        .sheet-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .sheet-header h1 {
            color: #2a3f5f;
            margin: 0;
        }

        .sheet-info p {
            color: #555;
            margin: 5px 0;
        }

        .personal-info, .marks-details {
            margin-bottom: 20px;
        }

        .personal-info h2, .marks-details h2 {
            color: #3a4a6b;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 5px;
        }

        .photo-space {
            width: 100px;
            height: 100px;
            border: 3px solid #eaeaea;
            margin: 10px 0;
            background-color: #fff;
            display: block;
            border-radius: 50%;
            background-image: url("./images/sai.jpg");
        }

        ul {
            list-style: none;
            padding: 0;
            color: #555;
        }

        ul li {
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
        }

        th {
            background-color: #eaeaea;
            color: #333;
        }

        td {
            background-color: #fff;
            color: #555;
        }

        @media (max-width: 600px) {
            .marks-sheet {
                width: 90%;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <div class="marks-sheet">
        <header class="sheet-header">
            <h1>Marks Sheet</h1>
            <div class="sheet-info">
                <p>Sheet Number: <?php echo $id ?></p>
                <p>Date: <?php echo $idate ?></p>
            </div>
        </header>
        
        <section class="personal-info">
            <h2>Personal Information</h2>
            <!-- <div class="photo-space"></div> -->
            <ul>
                <li>Name: <?php echo $iname ?></li>
                <li>Email: <?php echo $email ?></li>
                <li>Phone: <?php echo $iphone ?></li>
                <li>Address: <?php echo $iaddress ?></li>
                <li>Date of Birth: <?php echo $idob ?></li>
                <li>Age: <?php echo $iage ?></li>
                <li>Branch: <?php echo $ibranch ?></li>
                <li>Industry Experience: <?php echo $iexp ?></li>
                <li>Teaching Experience: <?php echo $texp ?></li>
                <li>Caste: <?php echo $icaste ?></li>
            </ul>
        </section>

        <section class="marks-details">
            <h2>Marks Details</h2>
            <table>
                <tr>
                    <th>Interviewer Name</th>
                    <th>Part A</th>
                    <th>Part B</th>
                    <th>Subject Knowledge</th>
                    <th>Presentation</th>
                    <th>Total</th>
                    <th>Remarks</th>
                </tr>
                <tr>
                    <td><?php echo $t1name ?></td>
                    <td><?php echo $t1m1 ?></td>
                    <td><?php echo $t1m2 ?></td>
                    <td><?php echo $t1m3 ?></td>
                    <td><?php echo $t1m4 ?></td>
                    <td><?php echo $t1total ?></td>
                    <td><?php echo $t1remarks ?></td>
                </tr>
                <tr>
                    <td><?php echo $t2name ?></td>
                    <td><?php echo $t2m1 ?></td>
                    <td><?php echo $t2m2 ?></td>
                    <td><?php echo $t2m3 ?></td>
                    <td><?php echo $t2m4 ?></td>
                    <td><?php echo $t2total ?></td>
                    <td><?php echo $t2remarks ?></td>
                </tr>
                <tr>
                    <td><?php echo $t3name ?></td>
                    <td><?php echo $t3m1 ?></td>
                    <td><?php echo $t3m2 ?></td>
                    <td><?php echo $t3m3 ?></td>
                    <td><?php echo $t3m4 ?></td>
                    <td><?php echo $t3total ?></td>
                    <td><?php echo $t3remarks ?></td>
                </tr>
                <!-- Repeat <tr>...</tr> for more entries -->
            </table>
        </section>
    </div>
</body>
</html>