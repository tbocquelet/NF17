<?php

function fConnect()
{
	$conn = pg_connect("host=tuxa.sme.utc port=5432 dbname=dbnf17p055 user=nf17p055 password=gK0zqTUq");
	return $conn;
}

?>
