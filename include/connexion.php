<?php

$bddname = "mysql:host=db5000303652.hosting-data.io;dbname=dbs296639";
$user = "dbu526615";
$pass = "5(9|zhXJ";

try
{
	$bdd = new PDO($bddname, $user, $pass);
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
