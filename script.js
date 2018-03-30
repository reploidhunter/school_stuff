window.onload = function(){
var logout = document.getElementById("logout");
var reMovie = document.getElementsByClassName("remove");
var addMovie = document.getElementsByClassName("add");

	logout.onclick = function(){
		if(confirm("Are you sure you want to log out?")) {
			window.location.replace("http://139.62.210.181/~jb664052/module5/logon.php");
		}
		return false;
	}

	for(i = 0; i < reMovie.length; i++){
		reMovie[i].onclick = function(){
			if(confirm("Are you sure you want to remove '" + this.getAttribute('data-title') + "'?")){
				var movieID = this.getAttribute('data-movieID');
				window.location.replace("http://139.62.210.181/~jb664052/module5/index.php?action=remove&movie_id=" + movieID);
			}
			return false;
		}
	}

	for(i = 0; i < addMovie.length; i++){
		addMovie[i].onclick = function(){
			var movieID = this.getAttribute('data-movieID');
			window.location.replace("http://139.62.210.181/~jb664052/module5/index.php?action=add&movie_id=" + movieID);
			return false;
		}
	}
}

function validateCreateAccountForm(){
	var displayName = document.getElementById("displayName").value;
	var username = document.getElementById("userName").value;
	var email = document.getElementById("email").value;
	var confirmEmail = document.getElementById("confirmEmail").value;
	var passwd = document.getElementById("passwd").value;
	var confirmPasswd = document.getElementById("confirmPasswd").value;
	if(username.indexOf(' ') != -1){
		alert("Usernames may not contain any spaces!");
		return false;
	}
	if(email.indexOf(' ') != -1){
		alert("Email address may not contain any spaces!");
		return false;
	}
	if(confirmEmail.indexOf(' ') != -1){
		alert("Email address may not contain any spaces!");
		return false;
	}
	if(passwd.indexOf(' ') != -1){
		alert("Passwords may not contain any spaces!");
		return false;
	}
	if(confirmPasswd.indexOf(' ') != -1){
		alert("Passwords may not contain any spaces!");
		return false;
	}
	if(email != confirmEmail){
		alert("Emails must match!");
		return false;
	}
	if(passwd != confirmPasswd){
		alert("Passwords must match!");
		return false;
	}
	return true;
}

function reset(){
	var userName = document.getElementById("userName").value;
	if(userName == null){
		alert("A username is required!");
		return false;
	}
	else{
		var location = "http://139.62.210.181/~jb664052/module5/logon.php?action=forgot&username=" + userName;
		window.location.replace(location);
		return true;
	}
	return true;
}

function create(){
	window.location.replace("http://139.62.210.181/~jb664052/module5/logon.php?form=create");
	return false;
}

function validateResetPasswordForm(){
	var passwd = document.getElementById("passwd").value;
	var confirmPasswd = document.getElementById("confirmPasswd").value;
	if(passwd.indexOf(' ') != -1){
		alert("Passwords may not contain any spaces!");
		return false;
	}
	if(confirmPasswd.indexOf(' ') != -1){
		alert("Passwords may not contain any spaces!");
		return false;
	}
	if(passwd != confirmPasswd){
		alert("Passwords must match!");
		return false;
	}
	return true;
}

function checkout(){
	window.location.replace("http://139.62.210.181/~jb664052/module5/index.php?action=checkout");
	return true;
}

function cancel(form){
	if(form == "create"){
		if(confirm("Are you sure you want to cancel creating a new account?")) {
			window.location.replace("http://139.62.210.181/~jb664052/module5/logon.php");
			return true;		
		}
	}
	else if(form == "reset"){
		if(confirm("Are you sure you want to cancel resetting your password?")) {
			window.location.replace("http://139.62.210.181/~jb664052/module5/logon.php");
			return true;
		}
	}
	return false;
}

function displayMovieInformation(movie_id){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		document.getElementById("modalWindowContent").innerHTML= this.responseText;
		showModalWindow();
	}
	xhttp.open("GET", "movieinfo.php?movie_id=" + movie_id, true);
	xhttp.send();
	showModalWindow();
}

function showModalWindow() {
    var modal = document.getElementById('modalWindow');
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() { 
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
 
    modal.style.display = "block";
}