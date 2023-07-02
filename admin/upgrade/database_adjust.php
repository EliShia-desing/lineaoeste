<?
include("../config.php");
include("../lang/lang.admin." . LANGUAGE_CODE . ".php");

mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die(mysqli_error());
mysqli_select_db(DB_NAME) or die(mysqli_error());

$sql = "SELECT id, start_time, end_time FROM " . DB_TABLE_PREFIX . "mssgs";
$result = mysqli_query($sql) or die(mysqli_error());

$count = 0;

while($row = mysqli_fetch_array($result)) {
	
	if ( $row[1] == "00:00:00" && $row[2] == "00:00:00" ) {
		
		$sql = "UPDATE " . DB_TABLE_PREFIX . "mssgs SET start_time='55:55:55', end_time='55:55:55' ";
		$sql .= "WHERE id=" . $row[0];
		
		mysqli_query($sql) or die(mysqli_error());
		
		$count++;
	}
}

echo "$count records adjusted.  Database adjustment successful";
?>
