<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php

include 'email.php';
echo "<script type=\"text/javascript\" src=\"script.js\">";
echo "</script>";


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
	echo "<input type=\"button\" value=\"Cancel\" id=\"cancel\" data-form=\"create\"></input>";
	echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"></input>";
	echo "<input type=\"reset\" name=\"reset\" value=\"Reset\"></input>";
	echo "</form>";
	echo "<a href=\"/~jb664052/index.html\">ePortfolio</a>";

?>

</body>
</html>