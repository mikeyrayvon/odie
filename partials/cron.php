<?php

$url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
$query = (parse_url($url, PHP_URL_QUERY));
parse_str($query);

if ($c == 'go' || $argv['1'] == 'go') {

	include('vars.php');

	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	if(! $conn ) { die('Could not connect: ' . mysqli_error()); }

	$sql_get = "SELECT username FROM users ORDER BY RAND() LIMIT 0,1 ";
	$query_get = mysqli_query( $conn, $sql_get );
	$row = mysqli_fetch_array($query_get, MYSQL_ASSOC);
	$username = $row['username'];

	$sql_set = "UPDATE daily SET username = '$username'";
	$query_set = mysqli_query( $conn, $sql_set );

	mysqli_close($conn);

	echo $username;

} else {
	die('no, fuck u');
}

?>

