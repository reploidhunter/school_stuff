<!DOCTYPE HTML>  
<html>
<head>
<script type="text/javascript" src="script.js">
</script>
<link rel="stylesheet" type="text/css" href="../css/site.css">
</head>
<body>

<?php
session_start();

include 'email.php';

if(sizeof($_GET) == 0 && sizeof($_POST) == 0) {
	if($_SESSION["name"] == null){
		header('Location: logon.php');
	}
	else{	
		displayCart();
	}
}
else{
	if($_GET["action"] === "remove") {
		removeFromCart($_GET["movie_id"]);
	}
	if($_GET["action"] === "add") {
		addToCart($_GET["movie_id"]);
		header('Location: index.php');
	}
	if($_GET["action"] === "checkout") {
		checkoutReceipt();
	}
}


function displayCart(){
	$count = 0;
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	echo "Welcome " . $_SESSION["name"] . "<a id=\"logout\" href=\"\">(Logout)</a>";
	echo "<br>";
	echo "myMovies Xpress! <br>";
	if($movies == ""){
		echo "Add Some Movies to Your Cart <br>";
	}
	else{
		$movieArr = explode(";", $movies);
		$count = sizeof($movieArr);
		if($count > 1) {
			echo $count;
			echo " Movies in Your Shopping Cart <br>";
		}
		elseif($count == 1) {
			echo "1 Movie in You Shopping Cart <br>";
		}
	}
	
	if($count >= 1){
		echo "<table style='width:50%'>";
		echo "<tr> <th>Cover</th> <th>Title (Year)</th> <th> </th> <th>Remove</th> </tr>";
		
		foreach($movieArr as $value){
			$search = "http://www.omdbapi.com/?apikey=cefcfae&i=" . $value . "&type=movie&r=json";
			$movie = file_get_contents($search);
			$array = explode('":', $movie);
			$titleArray = explode(",", $array[1]);
			$yearArray = explode(",", $array[2]);
			$coverArray = explode(",", $array[14]);
			$cover = trim($coverArray[0], '"');
			$title = trim($titleArray[0], '"');
			$year = trim($yearArray[0], '"');
			echo "<tr> <td align=\"center\"><img src=\"" . $cover . "\" alt=\"" . $cover . "\"></td><td align=\"center\"><a href=\"https://www.imdb.com/title/" . $value . "\" target=\"_blank\"> " . $title . " (" . $year . ")</a></td> <td align=\"center\"><a href=\"javascript:void(0);\" onclick='displayMovieInformation(\"$value\");'>View More Info</a></td> <td align=\"center\"><a class=\"remove\" href=\"\" data-movieID=\"$value\" data-title=\"$title\">X</a> </td> </tr>";
		}
		unset($value);
		echo "</table>";
	}
	if($count == 0){
		echo "<button id=\"checkout\" onclick=\"checkout();\">Checkout</button>";
	}
	else{
		echo "<button id=\"checkout\" onclick=\"checkout();\">Checkout</button>";
	}
	echo "<button type=\"button\" onClick=\"location.href = 'search.php';\">Add a Movie</button>";
	echo "<br><a href=\"/~jb664052/index.html\">ePortfolio</a>";
}

function checkoutReceipt(){
	$name = $_SESSION["name"];
	$email = $_SESSION["email"];
	$count = 0;
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	echo "Welcome " . $name . "<a id=\"logout\" href=\"\">(Logout)</a>";
	echo "<br>";
	echo "myMovies Xpress! <br>";
	if($movies == ""){
		echo "<p>There were no movies in your cart. How did you get here?</p><br>";
	}
	else{
		$movieArr = explode(";", $movies);
		$count = sizeof($movieArr);
		if($count > 1) {
			echo "<p>Congratulations on your purchase of the following " . $count . " movies!</p>";
		}
		elseif($count == 1) {
			echo "<p>Congratulations on your purchase of the following 1 movie!</p>";
		}
	}

	if($count >= 1){
		foreach($movieArr as $value){
			$movie = file_get_contents("http://www.omdbapi.com/?apikey=cefcfae&i=" . $value . "&type=movie&r=json");
			$array = json_decode($movie, true);
			$title = $array["Title"];
			$year = $array["Year"];
			echo $title . " (" . $year . ")<br>";
		}
		unset($value);
		sendEmail($email, "You have purchase " . $count . " movies from myMovies Xpress!");
	}
}

function removeFromCart($movieID){
	$writeString = "";
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	$movieArr = explode(";", $movies);
	$tempArr = array(0 => $movieID);
	$updateArr = array_diff($movieArr, $tempArr);
	foreach($updateArr as $value){
		$writeString .= $value . ";";
	}
	$writeString = substr($writeString, 0, -1);
	file_put_contents("data/cart.db", $writeString);
	displayCart();
}

function addToCart($movieID){
	$writeString = "";
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	if($movies != ""){
		$movieArr = explode(";", $movies);
		array_push($movieArr, $movieID);
		foreach($movieArr as $value){
			$writeString .= $value . ";";
		}
		$writeString = substr($writeString, 0, -1);
	}
	else{
		$writeString = $movieID;
	}
	$fileLoad = fopen("data/cart.db", "w") or die("Unable to open file!");
	fwrite($fileLoad, $writeString);
	fclose($fileLoad);
}

?>
<div id="modalWindow" class="modal">
	<div id="modalWindowContent" class="modal-content">
	</div>
</div>
</body>
</html>  