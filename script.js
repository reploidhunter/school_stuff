window.onload = function(){
var logout = document.getElementById("logout");
var reMovie = document.getElementsByClassName("remove");

	logout.onclick = function(){
		if(confirm("Are you sure you want to log out?")) {
			window.location.replace("http://192.168.100.80/~jb664052/module4/logon.php");
		}
		return false;
	}

	for(i = 0; i < reMovie.length; i++){
		reMovie[i].onclick = function(){
			if(confirm("Are you sure you want to remove '" + this.getAttribute('data-title') + "'?")){
				var movieID = this.getAttribute('data-movieID');
				window.location.replace("http://192.168.100.80/~jb664052/module4/index.php?action=remove&movie_id=" + movieID);
			}
			return false;
		}
	}
}

function addMovie(){

}