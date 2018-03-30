<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php

echo "<script type=\"text/javascript\" src=\"script.js\">";
echo "</script>";

if(sizeof($_GET) == 0 && sizeof($_POST) == 0) {
	echo "<p>Required Movie ID Was NOT Provided</p>";
}
else{
	createIMessage();
}
function createIMessage(){
	$movie = file_get_contents('http://www.omdbapi.com/?apikey=cefcfae&i=' . $_GET["movie_id"] . '&type=movie&r=json');
	$array = json_decode($movie, true);

	echo "<div class='modal-header'>";
		echo "<span class='close'>[Close]</span>";
		echo "<h2>".$array[Title]." (".$array[Year].") Rated ".$array[Rated]." ".$array[Runtime]."<br />".$array[Genre]."</h2>";
	echo "</div>";
	echo "<div class='modal-body'>";
		echo "<p>Actors: ".$array[Actors]."<br />Directed By: ".$array[Director]."<br />Written By: ".$array[Writer]."</p>";
	echo "</div>";
	echo "<div class='modal-footer'>";
		echo "<p>".$array[Plot]."</p>";
	echo "</div>";
}

?>

</body>
</html>