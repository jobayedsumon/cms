<?php

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "112358";
$db['db_name'] = "cms";

foreach ($db as $key => $value) {
	define(strtoupper($key), $value);
}

$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($connection->connect_error)
	echo "Connecion failed!".$connection->connect_error;

?>