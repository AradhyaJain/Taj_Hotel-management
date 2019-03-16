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
$nameErr = "";
$emailErr = "";
$mobErr = "";
$passErr = "";
$cpassErr = "";
$addressErr="";
$cityErr="";
$v = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST["address"])) 
  {
    $addressErr = "Address is required";
	$v++;
  }
  
  if (empty($_POST["city"])) 
  {
    $cityErr = "City is required";
	$v++;
  }
  
  if (empty($_POST["name"])) 
  {
    $nameErr = "Full name is required";
	$v++;
  }
  else if(!preg_match("/^[a-zA-Z ]*$/",$_POST["name"]))
  {
	  $nameErr = "Name is Invalid";
	  $v++;
  }
  
if (empty($_POST["email"])) 
  {
    $emailErr = "Email as username is required";
	$v++;
  }
  else if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) 
  {
    $emailErr = "Invalid email/username";
	$v++;
  }
  
if (empty($_POST["phone"])) 
  {
    $mobErr = "Mobile number is required";
	$v++;
  }
  else if(!preg_match('/^(?=.*\d)[0-9]{10,10}$/',$_POST["phone"]))
  {
	  $mobErr = "Mobile number is not valid";
	  $v++;
  }
  
if (empty($_POST["pass"])) 
  {
    $passErr = "Password is required";
	$v++;
  }
else if(!preg_match('/^(?=.*\d)(?=.*[@#\-_$%&+=!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%&+=!\?]{8,20}$/',$_POST["pass"]))
{	
	$passErr="Enter a password between 8-20 characters and combination of alphabets{atleast one small and one capital letter}, numbers and special symbols {@#\-_$%&+=!}";
	$v++;
}
else if (empty($_POST["cpass"])) 
  {
    $cpassErr = "Please re-enter password";
	$v++;
  }
else if($_POST["cpass"]!=$_POST["pass"])
{
	$cpassErr="Passwords do not match!";
	$v++;
}

if($v==0)
{
	$email=$_POST['email'];
	$q="select * from users where email='$email'";
    $result=mysqli_query($conn,$q);
	if (mysqli_num_rows($result) > 0) {
	    $additem="User already exists";   
	}
	else
	{
    $name=$_POST["name"];
	$pass=$_POST["pass"];
	$address=$_POST["address"];
	$city=$_POST["city"];
	$mob=$_POST["phone"];
	$q="INSERT INTO `users` (`name`, `email`, `pass`, `mob`, `address`, `city`) VALUES ('$name', '$email', '$pass', '$mob', '$address', '$city')";
    mysqli_query($conn,$q);
	$additem="User Addition complete";
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
   <font size="6">ADD USER</font><br>
<br>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<table>
<tr><td>
<label>
Name:
</label></td>
<td><input type="text" name="name">
<span class="error">* <?php echo $nameErr; ?></span></td></tr><br><br>
<tr><td><label>
Email/Username:
</label></td>
<td><input type="email" name="email"><span class="error">* <?php echo $emailErr; ?></span></td></tr><br><br>
<tr><td><label>
Address:
</label></td>
<td><input type="text" name="address">
<span class="error">* <?php echo $addressErr; ?></span></td></tr>
<tr><td><label>
City:
</label></td>
<td><input type="text" name="city">
<span class="error">* <?php echo $cityErr; ?></span></td></tr>
<tr><td><label>
Mobile:
</label></td>
<td><input type="number" name="phone"><span class="error">* <?php echo $mobErr; ?></span></td></tr>
<tr><td><label>
Password:
</label></td>
<td><input type="password" name="pass"><span class="error">* <?php echo $passErr; ?></span></td></tr>
<tr><td><label>
Re-enter password:
</label></td>
<td><input type="password" name="cpass"><span class="error">* <?php echo $cpassErr; ?></span></td></tr>
<tr></tr><tr><th colspan="2"><input type="submit" value="Confirm USER ADDITION"></th></tr>
</table>
</form>

<span class="error"><?php echo $additem; ?></span>
</main>
</section>



</body>
</html>