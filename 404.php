<?php
  if(isset($_POST["submit"])){
    header('Location: index');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 PAGE NOT FOUND</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome-all.min.css">
    <link rel="icon" type="image/x-icon" href="./assets/images/svec.png">
    <style>
        
/*======================
    404 page
=======================*/


.page_404{ padding:40px 0; background:#fff; font-family: 'Arvo', serif;
}

.page_404  img{ width:100%;}

.four_zero_four_bg{
 
 background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
    height: 400px;
    background-position: center;
 }
 
 .text-center{
  display: contents;
 }
 .four_zero_four_bg h1{
 font-size:80px;
 }
 
  .four_zero_four_bg h3{
       font-size:80px;
       }
       
       .link_404{      
  color: #fff!important;
    padding: 10px 20px;
    background: #39ac31;
    margin: 20px 0;
    display: inline-block;}
  .contant_box_404{ margin-top:-50px;}
    </style>
</head>
<body>
    <section class="page_404">
        <div class="container">
          <div class="row"> 
          <div class="col-sm-12 ">
          <div class="col-sm-10 col-sm-offset-1  text-center ">
          <div class="four_zero_four_bg">
            <h1 class="text-center ">404</h1>
          
          
          </div>
          
          <div class="contant_box_404">
          <h3 class="h2">
          Look like you're lost
          </h3>
          
          <p>the page you are looking for not avaible!</p>
          <form action="404" method="post">
            <button type="submit" name="submit" class="btn btn-success">Back To Home <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
              </svg>
            </button>
          </form>
        </div>
          </div>
          </div>
          </div>
        </div>
      </section>
</body>
</html>