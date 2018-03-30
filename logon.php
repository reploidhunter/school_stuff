<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php

include 'email.php';
echo "<script type=\"text/javascript\" src=\"script.js\">";
echo "</script>";

if(sizeof($_POST) == 0 and sizeof($_GET) == 0){
	session_start();
	session_destroy();
	displayLogon();
}

elseif(sizeof($_POST) == 0){
	
	if($_GET["action"] != ""){
		if($_GET["action"] == 'validate'){
			validateUser();
		}
		elseif($_GET["action"] == 'forgot'){
			forgotPassword();
		}
	}
	if($_GET["form"] != ""){
		if($_GET["form"] == 'create'){
			createAccountForm();
		}
		elseif($_GET["form"] == 'reset'){
			forgotPasswordForm();
		}
	}

}

elseif(sizeof($_GET) == 0){
	if($_POST["action"] == 'login'){
		authenticateUser();
	} 
	elseif($_POST["action"] == 'create'){
		createUser();
	}
	elseif($_POST["action"] == 'reset'){
		resetPassword();
	}
}

function displayLogon(){
	echo "<h2>Please log in to continue</h2>";
	echo "<table style='width:50%'>";
	echo "<form action=\"logon.php\" method=\"post\">";
	echo "<input type=\"text\" name=\"action\" value=\"login\" hidden>";
	echo "<tr><td>Username: </td> <td><input id=\"userName\" type=\"text\" name=\"userName\" value=\"" . $_POST["userName"] . "\" required></td></tr>";
	echo "<tr><td>Password: </td> <td><input type=\"password\" name=\"passwd\" value=\"" . $_POST["passwd"] . "\" required></td></tr></table>";
	echo "<button type=\"submit\" name=\"submit\" value=\"Submit\">Submit</button>";
	echo "<button type=\"reset\" name=\"reset\" value=\"Reset\">Reset</button>";
	echo "</form>";
	echo "<br><a id=\"create\" href=\"javascript:create()\">Create User</a> ";
	if($_POST["failed"] == true){
		echo " <a id=\"reset\" href=\"javascript:reset()\">Forgot Password</a><br>";
	}
	else{
		echo "<br>";
	}
	echo "<a href=\"/~jb664052/index.html\">ePortfolio</a>";
}

function createAccountForm(){
	echo "<h2>New User Account</h2>";
	echo "<p>myMovies Xpress!</p>";
	echo "<form action=\"logon.php\" onsubmit=\"return validateCreateAccountForm();\" method=\"post\">";
	echo "<table style='width:50%'>";
	echo "<tr><td>Display Name: </td> <td><input type=\"text\" id=\"displayName\" name=\"displayName\" value=\"" . $_POST["displayName"] . "\" required></td></tr>";
	echo "<tr><td>Username: </td> <td><input type=\"text\" id=\"userName\" name=\"userName\" value=\"" . $_POST["userName"] . "\" required></td></tr>";
	echo "<tr><td>Email: </td> <td><input type=\"text\" id=\"email\"name=\"email\" value=\"" . $_POST["email"] . "\" required></td></tr>";
	echo "<tr><td>Confirm Email: </td> <td><input type=\"text\" id=\"confirmEmail\"name=\"\" value=\"\" required></td></tr>";
	echo "<input type=\"text\" name=\"action\" value=\"create\" hidden>";
	echo "<tr><td>Password: </td> <td><input type=\"password\" id=\"passwd\" name=\"passwd\" value=\"" . $_POST["passwd"] . "\" required></td></tr>";
	echo "<tr><td>Confirm Password: </td> <td><input id=\"confirmPasswd\" type=\"password\" name=\"\" value=\"\" required></td></tr></table>";
	echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"></input>";
	echo "<input type=\"reset\" name=\"reset\" value=\"Reset\"></input>";
	echo "</form>";
	echo "<button id=\"cancel\" onclick=\"cancel('create');\" >Cancel</button>";
	echo "<a href=\"/~jb664052/index.html\">ePortfolio</a>";}

function forgotPasswordForm(){
	echo "<h2>Reset Password</h2>";
	echo "<p>myMovies Xpress!</p>";
	echo "<form action=\"logon.php\" onsubmit=\"return validateResetPasswordForm();\" method=\"post\">";	
	echo "<table style='width:50%'>";
	echo "<tr><td> Username: </td> <td><input type=\"text\" id=\"displayName\" name=\"userName\" value=\""
		 . $_GET["username"] . "\" readonly></td></tr>";
	echo "<input type=\"text\" name=\"action\" value=\"reset\" hidden>";
	echo "<tr><td>Password: </td><td><input type=\"password\" id=\"passwd\" name=\"passwd\" value=\"\" required></td></tr>";
	echo "<tr><td>Confirm Password:</td> <td><input type=\"password\" id=\"confirmPasswd\" name=\"\" value=\"\" required></td></tr></table>";
	echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"></input>";
	echo "<input type=\"reset\" name=\"reset\" value=\"Reset\"></input>";
	echo "</form>";
	echo "<button id=\"cancel\" onclick=\"cancel('reset');\" >Cancel</button>";
	echo "<a href=\"/~jb664052/index.html\">ePortfolio</a>";
}

function forgotPassword(){
	$userName = $_GET["username"];
	$credentials = fopen("data/credentials.db", "r") or die("Unable to open file!");
	$fullData = fread($credentials,filesize("data/credentials.db"));
	fclose($credentials);
	$userArray = explode("|", $fullData);
	while ($value1 = current($userArray)){
		$userArray[key($userArray)] = explode(",", $value1);
		if($userName == $userArray[key($userArray)][0]){
			$displayName = $userArray[key($userArray)][2];
			$email = $userArray[key($userArray)][3];
			break;
		}
		next($userArray);
	}
	$message = "Hello, " . $displayName . "click the following linkt to reset you password: http://139.62.210.181/~jb664052/module5/logon.php?form=reset&username=" . $userName;
	sendEmail($email, $message);
	echo "A password reset email was sent to " . $email;
	displayLogon();
}

function resetPassword(){
	$userName = $_POST["userName"];
	$newPasswd = $_POST["passwd"];
	$writeString = "";
	$credentials = fopen("data/credentials.db", "r") or die("Unable to open file!");
	$fullData = fread($credentials,filesize("data/credentials.db"));
	fclose($credentials);
	$userArray = explode("|", $fullData);
	while ($value1 = current($userArray)){
		$userArray[key($userArray)] = explode(",", $value1);
		if($userName == $userArray[key($userArray)][0]){
			$userArray[key($userArray)][1] = $newPasswd;
		}
		foreach($userArray[key($userArray)] as $value2){
			$writeString .= $value2 . ",";
		}
		$writeString = substr($writeString, 0, -1);
		$writeString .= "|";
		unset($value2);
		next($userArray);
	}
	
	$writeString = substr($writeString, 0, -1);
	file_put_contents("data/credentials.db", $writeString);
	echo "<p>Password has been reset for " . $userName;
	displayLogon();

}

function createUser(){
	$displayName = $_POST["displayName"];
	$userName = $_POST["userName"];
	$passwd = $_POST["passwd"];
	$email = $_POST["email"];
	$writeString = "";
	$credentials = fopen("data/credentials.db", "r") or die("Unable to open file!");
	$fullData = fread($credentials,filesize("data/credentials.db"));
	fclose($credentials);
	if($fullData != null){
		$userArray = explode("|", $fullData);
		while ($value1 = current($userArray)){
			$userArray[key($userArray)] = explode(",", $value1);
			if($userName == $userArray[key($userArray)][0]){
				echo "<p>The desired username already exists. Please use a different username.</p>";
				createAccountForm();
				return;
			}
			next($userArray);
		}
	}
	session_start();
	$_SESSION["displayName"] = $displayName;
	$_SESSION["userName"] = $userName;
	$_SESSION["passwd"] = $passwd;
	$_SESSION["email"] = $email;
	$send = "http://139.62.210.181/~jb664052/module5/logon.php?action=validate&username=" . $userName;
	sendEmail($email, $send);
	echo "Validation email sent to " . $email . ".";
	displayLogon();
}

function validateUser(){
	session_start();
	$file = "data/credentials.db";
	if($_SESSION["userName"] == $_GET["username"]){
		$newUser = "|" . $_SESSION["userName"] . ',' . $_SESSION["passwd"] . ',' . $_SESSION["displayName"] . ',' . $_SESSION["email"];
		file_put_contents($file, $newUser, FILE_APPEND | LOCK_EX);
		echo "New user added!";
	}
	else{
		echo "The validation link is invalid. Please try again or log in.";
	}
	session_destroy();
	displayLogon();
}

function authenticateUser(){
	$userName = $passwd = "";
	$userName = test_input($_POST["userName"]);
	if (!preg_match("/^[a-zA-Z0-9]*$/",$userName)) {
		displayLogon();
		echo "Usernames may contain only upper and lower case alphanumeric characters"; 
		return;
	}
	$passwd = test_input($_POST["passwd"]);
	if (!preg_match("/^[a-zA-Z0-9]*$/",$passwd)) {
		displayLogon();
		echo "Passwords may contain only upper and lower case alphanumeric characters";
		return;
	}
	$credentials = fopen("data/credentials.db", "r") or die("Unable to open file!");
	$fullData = fread($credentials,filesize("data/credentials.db"));
	fclose($credentials);
	$userArray = explode("|", $fullData);
	$authorizedUser = $userName . " " . $passwd;
	while ($value = current($userArray)){
		$userArray[key($userArray)] = explode(",", $value);
		if($userName == $userArray[key($userArray)][0]){
			$userLogin = $userArray[key($userArray)][0] . " " . $userArray[key($userArray)][1];
			if($authorizedUser == $userLogin){
				session_start();
				$_SESSION["name"] = $userArray[key($userArray)][2];	
				$_SESSION["email"] = $userArray[key($userArray)][3];
				header("Location: index.php");
			}
		}
		next($userArray);
	}
	echo "Your username or password was incorrect. <br>";
	$_POST["failed"] = true;
	displayLogon();
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>

</body>
</html>