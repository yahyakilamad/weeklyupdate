<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yahya
 * Date: 13/08/2018
 * Time: 10:32
 * Database connection
 */
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'accounts';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
