<?php
$loginErr="";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if (empty($_POST["username"])) 
  {
    $loginErr = "Username is required";
  }
  else if (!filter_var($_POST["username"],FILTER_VALIDATE_EMAIL)) 
  {
    $loginErr = "Invalid username, Enter your registered email as username";
  }
  else
  {
	  $conn = mysqli_connect("localhost","root","","taj");
	  if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	  }
	  $name=$_POST['username'];
	  $q="select pass from users where email='$name'";
	  $result = mysqli_query($conn, $q);
	  if (mysqli_num_rows($result) > 0) {
		  while($row = mysqli_fetch_assoc($result)) {
	  $cpass=$row["pass"];
		  }
	  if($cpass==$_POST['pass'])
	  {
		  session_start();
		$_SESSION['name']=$_POST['username'];
		header("Location:./home.php");
	  }
	 else
	{
		  $loginErr="Incorrect password";
	}
	  }
	  else
	  {
		  $loginErr="User not found";
	  }
  
  }

}
?>
<html>
<head>

<title>
Admin Login
</title>
<link rel="stylesheet" type="text/css" href="ss1.css">	
</head>
<body background="./hotel.jpg" style="width:800px;height:600px;">

	

<img src="./logo.png" height="200" width="350" style="position:absolute; top:0px; right:0px;">



<br><br><br><br><br>
<br><br><br><br><br>
<div>
<table class="center"><tr><td>
<h1 style="color:black;" class="ontop">Admin Login</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<field>
</td></tr>

<tr><td>
<Input type="text" name="username" placeholder="Username" class="ontop">
</td></tr></field>
<br>
<field>
<tr><td><Input type="password" name="pass" placeholder="Password" class="ontop">
<td></tr></field>
<br>
<field>
<tr><td><Input type="submit" value="LOGIN" style="cursor:pointer; width:150px;" class="ontop">
</td></tr>

</field>
</form>
<tr><td>
<span class="error"><?php echo $loginErr; ?></span>
</td></tr>
</table></div>

</body>
</html>
