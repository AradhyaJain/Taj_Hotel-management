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
  <a href="./guests.php">Guests</a>
  <a href="./orders.php">Orders</a>
  <a href="./service.php">Service</a>
  <a class="active" href="./admin1.php">Admin</a>
  <a href="./history.php">History</a>
  <span>Logged in as:<?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>
<main>
   <br><br>
   <input type="button" value="ADD ROOM" name="addroom" onclick="window.location.href='./addroom.php'">&nbsp&nbsp
   <input type="button" value="REMOVE ROOM" name="remroom" onclick="window.location.href='./remroom.php'"><br><br><br><br>
   <input type="button" value="ADD SERVICE" name="addser" onclick="window.location.href='./addser.php'">&nbsp&nbsp
   <input type="button" value="REMOVE SERVICE" name="remser" onclick="window.location.href='./remser.php'"><br><br><br><br>
   <input type="button" value="ADD MENU ITEM" name="additem" onclick="window.location.href='./additem.php'">&nbsp&nbsp
   <input type="button" value="REMOVE MENU ITEM" name="remitem" onclick="window.location.href='./remitem.php'"><br><br><br><br>
   <input type="button" value="ADD USER" name="adduser" onclick="window.location.href='./adduser.php'">&nbsp&nbsp
   <input type="button" value="REMOVE USER" name="remuser" onclick="window.location.href='./remuser.php'"><br><br><br><br>
   <input type="button" value="CLEAR HISTORY" name="clrhistory" onclick="window.location.href='./clrhis.php'">
</main>
</section>



</body>
</html>
