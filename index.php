<!DOCTYPE HTML>  
<html>
<head>
<script type="text/javascript" src="script.js">
</script>
</head>
<body>

<?php
session_start();

if(sizeof($_GET) == 0) {
	displayCart();
}
else{
	if($_GET["action"] === "remove") {
		removeFromCart($_GET["movie_id"]);
	}
	if($_GET["action"] === "add") {
		addToCart($_GET["movie_id"]);
	}
}


function displayCart(){
	$count = 0;
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	$movieArr = explode(";", $movies);
	array_pop($movieArr);
	echo "Welcome " . $_SESSION["name"] . "<a id=\"logout\" href=\"\">(Logout)</a>";
	echo "<br>";
	echo "myMovies Xpress! <br>";

	$count = sizeof($movieArr);
	if($count > 1) {
		echo $count;
		echo " Movies in Your Shopping Cart <br>";
	}
	elseif($count == 0) {
		echo "Add Some Movies to Your Cart <br>";
	}
	elseif($count == 1) {
		echo "1 Movie in You Shopping Cart <br>";
	}

	
	if($count >= 1){
		echo "<table style='width:50%'>";
		echo "<tr> <th>Title, Year</th> <th>Cover</th> <th>Remove</th> </tr>";
		
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
			echo "<tr> <td align=\"center\">" . $title . ", " . $year . "</td> <td align=\"center\"><img src=\"" . $cover . 
				"\" alt=\"Cover Art\"></td> <td align=\"center\"> <a class=\"remove\" href=\"\" data-movieID=\"$value\" data-title=\"$title\">X</a> </td> </tr>";
		}
		unset($value);
		echo "</table>";
		echo "<button type=\"button\" onClick=\"location.href = 'http://192.168.100.80/~jb664052/module4/search.php';\">Add a Movie</button>";
	}
}

function removeFromCart($movieID){
	$writeString = "";
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	$movieArr = explode(";", $movies);
	array_pop($movieArr);
	$tempArr = array(0 => $movieID);
	$updateArr = array_diff($movieArr, $tempArr);
	foreach($updateArr as $value){
		$writeString .= $value . ";";
	}
	file_put_contents("data/cart.db", $writeString);
	displayCart();
}

function addToCart($movieID){
	$writeString = "";
	$fileLoad = fopen("data/cart.db", "r") or die("Unable to open file!");
	$movies = fread($fileLoad,filesize("data/cart.db"));
	fclose($fileLoad);
	$movieArr = explode(";", $movies);
	array_pop($movieArr);
	array_push($movieArr, $movieID);
	foreach($movieArr as $value){
		$writeString .= $value . ";";
	}
	file_put_contents("data/cart.db", $writeString);
	displayCart();
}

?>

</body>
</html>  