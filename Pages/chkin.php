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
	$v=0;
	$chkinErr="";
	$nameErr="";
	$mobErr="";
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$cname=$_POST["cname"];
		$address=$_POST["address"];
		$city=$_POST["city"];
		$indate=$_POST["indate"];
		$mob=$_POST["mob"];
		$idt=$_POST["idt"];
		$idno=$_POST["idno"];
		$room=$_POST["room"];
		if (empty($indate)) 
		{
			$v++;
		}
		if (empty($idt)) 
		{
			$v++;
		}
		if (empty($idno)) 
		{
			$v++;
		}
		
		if (empty($cname)) 
		{
			$nameErr = "First name is required";
			$v++;
		}
		else if(!preg_match("/^[a-zA-Z ]*$/",$cname))
		{
			$nameErr="Invalid name";
			$v++;
		}
		if (empty($mob)) 
		{
			$mobErr = "Mobile number is required";
			$v++;
			}
		else if(!preg_match('/^(?=.*\d)[0-9]{10,10}$/',$mob))
		{
			$mobErr = "Mobile number is not valid";
			$v++;
		}
		if($v==0)
		{   $room=$_POST['room'];
			$q="select * from rooms where number=$room AND status=0";
			$result=mysqli_query($conn,$q);
			if(mysqli_num_rows($result) == 0)
			{
				$chkinErr="Room not present";
			}
			else
			{
			while( $row = mysqli_fetch_array($result))
			{
				$q="INSERT INTO `cust` (`name`, `mob`, `address`, `city`, `indate`, `idproof`, `idnumber`, `room`) VALUES ('$cname', '$mob', '$address', '$city', '$indate', '$idt', '$idno', '$room')";
				mysqli_query($conn,$q);
			}
			$q="UPDATE rooms SET status=1 where number=$room";
			mysqli_query($conn,$q);
			$chkinErr="Checkin Complete";
		}
	}
	else
	{
		$chkinErr="Form Incomplete";
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
  <a class="active" href="./chkin.php">Check In</a>
  <a href="./chkout.php">Check Out</a>
  <a href="./guests.php">Guests</a>
  <a href="./orders.php">Orders</a>
  <a href="./service.php">Service</a>
  <a href="./admin1.php">Admin</a>
  <a href="./history.php">History</a>
  <span>Logged in as:<?php echo $username; ?></span>
   <a href="./logout.php">Logout</a>
</div>
<main>
   <h1>Check in form<h1>
   <p>Please check the type and price of room carefully</p>
<br>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<label>Room no:</label>
<?php 
    $q="select number from rooms where status=0";
    $result=mysqli_query($conn,$q);
	if (mysqli_num_rows($result) > 0) {
		  echo "<select name='room'>";
		  while($row = mysqli_fetch_array($result)) {
			  $opt=$row['number'];
			  echo "<option value='$opt'>".$opt."</option>";
		  }
		  echo "</select>";
		  
		$dodo="<table><tr><td><label>Customer name:</label></td><td><input type='text' name='cname' placeholder='Full name'><span class='error'>* <?php echo $nameErr; ?></span></td></tr>

<tr><td><label>Address:</label></td><td><input type='text' name='address' placeholder='Address of corrrespondence'></td></tr> &nbsp 

<tr><td><label>City:</label></td><td><input type='text' name='city' placeholder='Home city'></td></tr>

<tr><td><label>Check in date:</label></td><td><input type='date' name='indate'><span class='error'>*</span> </td></tr> &nbsp 

<tr><td><label>Customer mobile:</label></td><td><input type='text' name='mob' placeholder='10 Digit'><span class='error'>* <?php echo $mobErr; ?></span></td></tr>

<tr><td><label>ID Proof type:</label></td><td><input type='list' name='idt'></td></tr><span class='error'>* </span>&nbsp 

<tr><td><label>ID number:</label></td><td><input type='text' name='idno' placeholder='Keep photocopy'><span class='error'>*</span></td></tr></table>
<br><br>
<input align='center' type='submit' value='Check IN'>";
		  echo $dodo;
	
	}
	else{
		echo "No rooms available";
	} ?>
</form>
<span class="error"> <?php echo $chkinErr; ?></span>
</main>
</section>



</body>
</html>
