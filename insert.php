<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "root", "odie");

// Check connection
if($link === false){
    die("ERROR: Could not connect.");
}
 
// Escape user inputs for security
$username = mysqli_real_escape_string($link, $_POST['username']);
$url = mysqli_real_escape_string($link, $_POST['url']);
$title = mysqli_real_escape_string($link, $_POST['title']);
$description = mysqli_real_escape_string($link, $_POST['description']);
 
// attempt insert query execution
$result = mysqli_query($link, "SELECT * FROM users WHERE username = '$username'");

if(mysqli_num_rows($result) == 0) {
	$sql = "INSERT INTO `users` (username, url, title, description)
	SELECT '$username', '$url', '$title', '$description'";
	if(mysqli_query($link, $sql)){
		$response = 'success'; 
	} else{
		$response = 'error'; 
	}
} else { //username already exists in db
	$response = 'exists'; 
}

// return response
echo $response;

// close connection
mysqli_close($link);
?>