<?php
function startup()
{
	// Настройки подключения к БД.
	$hostname = 'localhost';	
	$username = 'root'; 
	$password = '';
	$dbName   = 'test';
	
	// Подключение к БД.
	$connect = mysqli_connect($hostname, $username, $password) or die('No connect with data base'); 
	mysqli_query($connect, 'SET NAMES utf-8');
	mysqli_select_db($connect, $dbName) or die('No data base');

	// Открытие сессии.
	session_start();	

	$_SESSION['mysql_connect'] = $connect;
}
