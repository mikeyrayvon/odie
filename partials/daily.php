<?php
$daily_sql = "SELECT username FROM daily";
$daily_query = mysqli_query( $conn, $daily_sql );
$daily_row = mysqli_fetch_assoc($daily_query);
$daily_username = $daily_row['username'];
if ($home == 'odie.us') {
	$daily_url = $daily_username . '.' . $home;
} else {
	$daily_url = $home . '?u=' . $daily_username;
}
$daily_output = '<a href="http://' . $daily_url . '">' . $daily_username . '</a>';
