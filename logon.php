<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
$userNameErr = $passwdErr = $userName = $passwd = $userCred = $name = "";
session_destroy();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["userName"])) {
		$userNameErr = "Please enter your username.";
	} 
	else {
		$userName = test_input($_POST["userName"]);
		if (!preg_match("/^[a-zA-Z0-9]*$/",$userName)) {
			$userNameErr = "Usernames may contain only upper and lower case alphanumeric characters"; 
		}
	}
  
	if (empty($_POST["passwd"])) {
		$passwdErr = "Please enter your password.";
	} 
	else {
		$passwd = test_input($_POST["passwd"]);
		if (!preg_match("/^[a-zA-Z0-9]*$/",$passwd)) {
			$passwdErr = "Passwords may contain only upper and lower case alphanumeric characters";
		}
	}
}
	
$credentials = fopen("data/credentials.db", "r") or die("Unable to open file!");
$fullData = fread($credentials,filesize("data/credentials.db"));
$splitData = explode(":", $fullData);
$authorizedUser = $splitData[0];
$name = $splitData[1];
fclose($credentials);

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if($userName != "" && $passwd != "") {
	$userCred = $userName . " ";
	$userCred .= $passwd;
	if($userCred == $authorizedUser) {
		session_start();
		$_SESSION["name"] = $name;
		header("Location: index.php");
	}
	else{
		$userCred = "";
		$passwd = "";
	}
}
?>

<h2>Please log in to continue</h2>
	<form method="post">
	Username: <input type="text" name="userName">
	<span class="error">* <?php echo $userNameErr ;?></span>
	<br><br>
	Password: <input type="text" name="passwd">
	<span class="error">* <?php echo $passwdErr ;?></span>
	<button type="submit" name="submit" value="Submit">Submit</button>
	<button type="reset" name="reset" value="Reset">Reset</button>
</form>
<a href="/~jb664052/index.html">ePortfolio</a>
</body>
</html>