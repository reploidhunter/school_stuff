<!DOCTYPE HTML>  
<html>
<head>
<script type="text/javascript" src="script.js">
</script>
</head>
<body>
<?php

session_start();

if(sizeof($_POST) == 0) {
	displaySearch();
}
else{
	displayResults(test_input($_POST["keyword"]));
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function displaySearch() {
	echo "Welcome " . $_SESSION["name"] . "<a id=\"logout\" href=\"\">(Logout)</a> <br>";
	echo "myMovies Xpress! <br>";
	echo "Please enter a search keyword: ";
	echo "<form action=\"search.php\" method=\"post\"> <input type=\"text\" name=\"keyword\" required> <br> 
		<button type=\"button\" onClick=\"location.href = 'index.php';\">Cancel</button> 
		<input type=\"submit\"> </form>";
}

function displayResults($keyword) {
	echo "Welcome " . $_SESSION["name"] . "<a id=\"logout\" href=\"\">(Logout)</a> <br>";
	echo "myMovies Xpress! <br>";
	$results = file_get_contents('http://www.omdbapi.com/?apikey=cefcfae&s='.urlencode($keyword).'&type=movie&r=json');
	$resultsArr = json_decode($results, true)["Search"];
	$resultCount = sizeof($resultsArr);
	if($resultCount > 1) {
		echo "Your search returned " . $resultCount . " results. <br>";
	}
	elseif($resultCount == 0) {
		echo "Your search returned no results <br>";
	}
	elseif($resultCount == 1) {
		echo "Your search returned 1 result. <br>";
	}
	if($resultCount >= 1){
		echo "<table style='width:50%'>";
		echo "<tr> <th>Title (Year)</th> <th>Cover</th> <th>Add</th> </tr>";
		foreach($resultsArr as $value) {
				$title = $value["Title"];
				$year = $value["Year"];
				$cover = $value["Poster"];
				$movieId = $value["imdbID"];
				echo "<tr> <td align=\"center\"><a href=\"https://www.imdb.com/title/" . $movieId . "\" target=\"_blank\"> " . $title . " (" . $year . ")</a></td> <td align=\"center\"><img src=\"" . $cover . "\" alt=\"Cover Art\"></td> <td align=\"center\"> <a class=\"add\" href=\"\" data-movieID=\"$movieId\" data-title=\"$title\">+</a> </td> </tr>";
		}
		unset($value);
		echo "</table>";
	}
	
}
echo "<br><a href=\"/~jb664052/index.html\">ePortfolio</a>";
?>
</body>
</html>