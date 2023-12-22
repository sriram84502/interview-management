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
    $query = "SELECT email FROM apply";
    $result = $conn->query($query);
    $emails = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }
    }
    $name = [];
    $email = [];
    $marks1 = [];
    $marks2 = [];
    $marks3 = [];
    $marks4 = [];
    for($i=0;$i<count($emails);$i=$i+1){
      $query = "SELECT * FROM candidate_marks WHERE email='$emails[$i]' GROUP BY email";
      $result = $conn->query($query);
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $name[] = $row['name'];
              $email[] = $row['email'];
              $marks1[] = $row['m3'];
              $marks2[] = $row['m4'];
              $marks3[] = $row['m1'];
              $marks4[] = $row['m2'];
          }
      }
    }

    if(isset($_POST["submit"])){
      $_SESSION['downloadEmail'] = $_POST['userEmail'];
      echo '<script> alert('.$_SESSION['downloadEmail'].')</script>';
      header('Location: final-results');
      exit();
  }

  if(isset($_POST["submit1"])){
    $selected_email = $_POST['userEmail1'];
    $sql3 = "DELETE from apply WHERE email='$selected_email'";
    if ($conn->query($sql3) === TRUE) {
        echo "<script>alert('deleted successfully...')</script>";
        header("Location: re-apply");
    }else {
        echo '<script>alert("failed")</script>';
        echo $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Re-Applied</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
  <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
  <style>
    body {
      background: #f5f7fa; /* subtle background color */
      padding: 2rem 0;
    }

    .card-custom {
        border-radius: 25px; /* Increased border-radius */
        color: #343a40;
        font-weight: bold;
        margin: 1rem; /* Added margin around cards */
        box-shadow: 0 4px 8px rgba(0,0,0,0.2); /* Subtle box-shadow */
        display: inline-block;
        width: 100%;
        break-inside: avoid; /* Prevent card split across columns */
        background: #fff; /* White background for the card */
        }

        /* Maintain spacing around the container */
        .container {
        padding: 2rem;
        /* margin: 2rem; */
        max-width: 100vw;
        }

        /* Custom columns layout */
        .cards-column {
        column-gap: 2rem; /* Gap between columns */
        }

        @media (min-width: 768px) {
        .cards-column {
            column-count: 2; /* two columns for medium screens and up */
        }
        }

        @media (min-width: 992px) {
        .cards-column {
            column-count: 4; /* four columns for large screens and up */
        }
        }


    .card-header-custom {
      background: linear-gradient(to right, #0062cc, #0096ff);
      color: #fff;
      padding: 0.75rem;
      font-size: 1.25rem;
    }

    .card-body-custom {
      background: #ffffff;
      color: #212529;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .party-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.5rem 0.75rem;
      background-color: #e9ecef;
      border-radius: 10px;
      margin-bottom: 0.5rem;
      font-size: 1rem;
    }

    .details-btn {
      text-decoration: none;
      color: #0056b3;
      font-weight: bold;
      background: #e7f5ff;
      border: 2px solid #0056b3;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      transition: all 0.3s ease;
      align-self: center;
      margin-top: auto;
    }

    .details-btn:hover {
      background-color: #0056b3;
      color: #fff;
    }

    /* Custom columns layout */
    .cards-column {
      column-count: 1; /* one single column by default */
    }

    @media (min-width: 768px) {
      .cards-column {
        column-count: 2; /* two columns for medium screens and up */
      }
    }

    @media (min-width: 992px) {
      .cards-column {
        column-count: 4; /* four columns for large screens and up */
      }
    }

    .card-custom {
      display: inline-block;
      width: 100%;
      break-inside: avoid; /* Prevent card split across columns */
    }
  </style>
</head>
<body>
<form action="logout" method="post" style="margin:10px 20px;display:flex;justify-content:end;gap:10px; align-items: end;">
<div class="input-group">
    <input type="text" class="form-control" id="searchInput" onkeyup="filterCards()" placeholder="Search for names..." aria-label="Recipient's username" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
    </div>
  </div>
    <a href="admin" style="text-decoration: none; "><button type="button" class="btn btn-outline-primary">Home</button></a>
    <a href="results" style="text-decoration: none; "><button type="button" class="btn btn-outline-success">Results</button></a>
    <button type="submit" class="btn btn-outline-danger" name="logout" placeholder="logout">logout</button>
</form>
<div class="container">
    <div class="row row-cols-1 row-cols-md-4 g-4"> 
    <?php for ($i = 0; $i < count($name); $i++): ?>
      <div class="col"> 
        <div class="card card-custom">
          <div class="card-header card-header-custom text-center d-flex align-items-center justify-content-between">
            <?php echo $name[$i];?>
            <form action="re-apply" method="POST">
              <input type="hidden" name="userEmail1" value="<?php echo htmlspecialchars($email[$i]); ?>">
              <button type="submit" name="submit1" class="btn btn-outline-light">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
              </svg>
              </button>
            </form>
          </div>
          <div class="card-body card-body-custom">
            <h6 class="text-muted ">Email: <?php echo $email[$i];?></h6>
            <div class="party-row">
              <span>Written test</span>
              <span><?php echo $marks3[$i]+$marks4[$i];?></span>
            </div>
            <div class="party-row">
              <span>Subject Knowledge</span>
              <span><?php echo $marks1[$i];?></span>
            </div>
            <div class="party-row">
              <span>Presentation</span>
              <span><?php echo $marks2[$i];?></span>
            </div>
            <form action="re-apply" style="display:contents" method="post">
              <input type="hidden" name="userEmail" value="<?php echo htmlspecialchars($email[$i]); ?>">
              <button type="submit" name="submit" class="details-btn">View Details</button>
            </form>
            <!-- <a href="final-results" class="details-btn">Download resume</a> -->
          </div>
        </div>
      </div>
    <?php endfor; ?>
  </div>
</div>




<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
function filterCards() {
    var input, filter, cards, cardContainer, title, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementsByClassName("row")[0];
    cards = cardContainer.getElementsByClassName("col");

    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card-header-custom");
        if (title) {
            txtValue = title.textContent || title.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
}
</script>

</body>
</html>