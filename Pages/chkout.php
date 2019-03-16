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
	$room="";
	$chkoutErr="";
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
			$room=$_POST['room'];
			$q="select * from rooms where number=$room AND status=1";
			$result=mysqli_query($conn,$q);
			
			if(mysqli_num_rows($result)>0)
			{
				$q="DELETE FROM `cust` WHERE `cust`.`room` = $room";
				mysqli_query($conn,$q);
				$qt="UPDATE rooms SET status=0 where number = $room";
				mysqli_query($conn,$qt);
				$qtt="DELETE FROM `history` WHERE `history`.`roomno` = $room";
				mysqli_query($conn,$qtt);
				$chkoutErr="Check Out Complete";
			}
			else
			{
				$chkoutErr="Room not occupied";
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
  <a class="active" href="./chkout.php">Check Out</a>
  <a href="./guests.php">Guests</a>
  <a href="./orders.php">Orders</a>
  <a href="./service.php">Service</a>
  <a href="./admin1.php">Admin</a>
  <a href="./history.php">History</a>
  <span>Logged in as:<?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>
<main>
   <h1>Check OUT form<h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<label>Room no:</label>
<?php 
    $q="select number from rooms where status=1";
    $result=mysqli_query($conn,$q);
	if (mysqli_num_rows($result) > 0) {
		  echo "<select name='room'>";
		  while($row = mysqli_fetch_array($result)) {
			  $opt=$row['number'];
			  echo "<option value='$opt'>".$opt."</option>";
		  }
		  echo "</select>";
		  echo "<br>";
		  $dodo="<input align='center' type='submit' value='Check OUT'>";
		  echo $dodo;
	}
	else{
		echo "No rooms occupied";
	} ?>
</form>
<span class="error"><?php echo $chkoutErr; ?></span>
</main>
</section>



</body>
</html>
