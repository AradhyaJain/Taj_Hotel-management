<?php
   session_start();
   $username="";
   if(!isset($_SESSION['name']))
    {    header("Location:./login.php");
     }
   else
    {
      $conn = mysqli_connect("localhost","root","","taj");
       if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	  }
          $name=$_SESSION['name'];
          $q="select name from users where email='$name'";
	  $result = mysqli_query($conn, $q);
	  if (mysqli_num_rows($result) > 0) {
		  while($row = mysqli_fetch_assoc($result)) {
	  $username=$row["name"];
		  }
    } 
	}
?>
<html>

<head>

<style>
.mySlides {display:none;}
</style>


<title>The Taj</title>
<script language="javascript" type="text/javascript">
</script>
<link rel="stylesheet" type="text/css" href="layout2.css">
</head>
<div class="image">
<img src="./logo.png" height="125" width="300" style="position:absolute; top:0px; right:0px;">
</div>
<body background="./hotel.jpg">
<center><<font size="12" color="white">The Taj Hotel and Resort</font><center>

<header>
  <font size="4"><h2>Guests Management</h2></font>
  
</header>

<div class="topnav">
<a class="active" href="./home.php">Home</a>
  <a href="./inout.php">Rooms</a>
  <a href="./chkin.php">Check In</a>
  <a href="./chkout.php">Check Out</a>
  <a href="./guests.php">Guests</a>
  <a href="./orders.php">Orders</a>
  <a href="./service.php">Service</a>
  <a href="./admin1.php">Admin</a>
  <a href="./history.php">History</a>
  <span>Logged in as : <?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>



<main>
   <marquee><h1>Welcome! to The Taj Hotel and Resort, Guests Management System.<h1></marquee>
<br>


  <img class="mySlides" src="./rooms/room1.jpg" style="width:800px ">
  <img class="mySlides" src="./rooms/room2.jpg" style="width:800px ">
  <img class="mySlides" src="./rooms/room3.jpg" style="width:800px ">
  <img class="mySlides" src="./rooms/room5.jpg" style="width:800px ">
  <img class="mySlides" src="./rooms/room6.jpg" style="width:800px ">
  <img class="mySlides" src="./rooms/room4.jpg" style="width:800px ">



<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2000); // Change image every 2 seconds
}
</script>

</main>




</body>
</html>
