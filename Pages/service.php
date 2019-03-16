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
	$itemErr="";
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{       if(empty($_POST['quantity']))
		{
			$itemErr="Enter quantity as a positive number";
		}
		else
		{
            $room=$_POST['room'];
            $product=$_POST['service'];
			$quan=(int)$_POST['quantity'];
			$q="select price from services where service='$product'";
			$result=mysqli_query($conn,$q);
			while($row = mysqli_fetch_array($result)) {
			  $price=(int)$row['price'];
			}
			$amount=$price*$quan;
			$qtt="INSERT INTO `history` (`roomno`, `product`, `quantity`, `amount`) VALUES ('$room', '$product', '$quan', '$amount')";
			mysqli_query($conn,$qtt);
			$itemErr="SERVICE AVAILED";
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
  <a class="active" href="./service.php">Service</a>
  <a href="./admin1.php">Admin</a>
  <a href="./history.php">History</a>
  <span>Logged in as:<?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>
<main>
   <h1>AVAIL A SERVICE<h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<?php 
	$q="select * from services";
    $result=mysqli_query($conn,$q);
	$qt="select number from rooms where status=1";
    $res=mysqli_query($conn,$qt);
	if (mysqli_num_rows($result) > 0 && mysqli_num_rows($res) > 0) {	 
		  echo "<label>Room number:</label>";
		  echo "<select name='room'>";
		  while($rowt = mysqli_fetch_array($res)) {
			  $opt=$rowt['number'];
			  echo "<option value='$opt'>".$opt."</option>";
		  }
		  echo "</select>";
          echo "&nbsp &nbsp &nbsp";        
		  echo "<label>Service name:</label>";
		  echo "<select name='service'>";
		  while($row = mysqli_fetch_array($result)) {
			  $opt=$row['service'];
			  echo "<option value='$opt'>".$opt."</option>";
		  }
		  echo "</select> &nbsp &nbsp &nbsp";
		  echo "<label>Number of times:</label><input type='number' name='quantity' value='1'>";
		  echo "<br><br>";
		  $dodo="<input align='center' type='submit' value='Avail service'>";
		  echo $dodo;
		  echo "<br><br>";
		 $result=mysqli_query($conn,$q);
		 echo "<table border='' style='width:300px;'><tr><th colspan='2'>Items Present</th></tr><tr><th>Item name</th><th>Price</th></tr>";
		 while($row = mysqli_fetch_array($result))
		 {
			 echo "<tr><td>".$row['service']."</td><td>".$row['price']."</td></tr>";
		 }
		 echo "</table>";
		 
	}
	else if(mysqli_num_rows($result) == 0)
	{
		echo "No services available";
	}
	else
	{
		echo"No rooms occupied";
	}
	?>
</form>
<span class="error"><?php echo $itemErr; ?></span>
</main>
</section>



</body>
</html>