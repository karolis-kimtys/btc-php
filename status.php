<?php
include 'database.php';
$db_selected = mysqli_select_db($conn, $database);

$db = $conn->query('SELECT DATABASE()');
$table = $conn->query('SHOW TABLES FROM bitcoin');
$fetch_db = $db->fetch_row();
$fetch_table = $table->fetch_row();

$res = (object) ['database' => $fetch_db[0], 'table' => $fetch_table[0]];
$json_res = json_encode($res);
echo $json_res;

?>