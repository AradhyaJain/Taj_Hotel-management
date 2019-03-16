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
	$additem="";
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
   <font size="6">ADD ITEM</font><br>
<br>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<table><tr><td><label>Item name:</label></td><td><input type="text" name="name"></td></tr><br><br>
<tr><td><label>Price</label></td><td><input type="number" name="price"><br></td></tr>
<tr><br></tr>
<tr><th colspan="2"><input type="submit" value="CONFIRM ADD"> </th></tr></table>
</form>
<?php 
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
	if(empty($_POST["name"]))
	{
		$additem="Enter item name";
	}	
    else if(empty($_POST["price"]))
    {
	   $additem="Enter item price";
    }	
	else
	{
	$item=$_POST['name'];
	$q="select * from orders where item='$item'";
    $result=mysqli_query($conn,$q);
	if (mysqli_num_rows($result) > 0) {
	    $additem="Item already exists";   
	}
	else
	{
    $price=$_POST["price"];	
	$q="INSERT INTO `orders` (`item`, `price`) VALUES ('$item','$price')";
    mysqli_query($conn,$q);
	$additem="Addition of item complete";
	}
	}
	}
 ?>
<span class="error"><?php echo $additem; ?></span>
 </main>
</section>



</body>
</html>
