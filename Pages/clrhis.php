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
	$itemErr="";
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
			$q="select * from history";
			$result=mysqli_query($conn,$q);
			if(mysqli_num_rows($result) > 0)
			{
				$q="DELETE FROM `history`";
				mysqli_query($conn,$q);
				$itemErr="History cleared";
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
  <a href="./admin1.php">Admin</a>
  <a class="active" href="./history.php">History</a>
  <span>Logged in as:<?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>
<main>
   <font size="6">HISTORY<font><br><br>
<br>
<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method='POST'>
<?php 
	$q="select * from history order by roomno";
    $result=mysqli_query($conn,$q);
	if (mysqli_num_rows($result) > 0) {
		  echo "<h3>Are you sure you want to remove complete history? <br><br><input type='submit' name='yes' value='YES'>";
	}
	else{
		echo "No history Available";
	}
 ?>
 </form>
 </main>
</section>



</body>
</html>
