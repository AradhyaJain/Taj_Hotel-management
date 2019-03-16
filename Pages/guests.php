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
<title>The Taj Hotel and Resort</title>
<script language="javascript" type="text/javascript">
</script>
<link rel="stylesheet" type="text/css" href="layout2.css">
</head>
<div class="image">
<img src="./logo.png" height="125" width="300" style="position:absolute; top:0px; right:0px;">
</div>
<body>
<center><font size="12" color="white">The Taj Hotel and Resort</font><center>

<header>
  <font size="4"><h2>Guests Management</h2></font>
  
</header>

<section>
<div class="topnav">
<a href="./home.php">Home</a>
  <a href="./inout.php">Rooms</a>
  <a href="./chkin.php">Check In</a>
  <a href="./chkout.php">Check Out</a>
  <a class="active" href="./guests.php">Guests</a>
  <a href="./orders.php">Orders</a>
  <a href="./service.php">Service</a>
  <a href="./admin1.php">Admin</a>
  <a href="./history.php">History</a>
  <span>Logged in as:<?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>
<main>
   <font size="6">GUEST INFO</font><br><br>
<br>
<table border="black" style="width:900px;">
<?php 
	$q="select * from cust";
    $result=mysqli_query($conn,$q);
	if (mysqli_num_rows($result) > 0) {
		  echo "<tr><th colspan='8'>ALL Guests</th></tr>";
		  echo "<tr><td>Name</td><td>Mobile</td><td>Address</td><td>City</td><td>Check in date</td><td>ID PROOF</td><td>ID PROOF NUMBER</td><td>ROOM NO</td></tr>";
		  while($row = mysqli_fetch_array($result)) {
			  
			  echo "<tr><td>".$row['name']."</td><td>".$row['mob']."</td><td>".$row['address']."</td><td>".$row['city']."</td><td>".$row['indate']."</td><td>".$row['idproof']."</td><td>".$row['idnumber']."</td><td>".$row['room']."</td></tr>";
		  }
	}
	else{
		echo "<tr><th colspan='8'>No guests present</th></tr>";
	}
 ?>
</table>
 </main>
</section>



</body>
</html>
