<?php

$dbh = new PDO('mysql:host=localhost;dbname=budget_app_db', 'root', 'mysql_matBras1992');

$stmt = $dbh->prepare('SELECT * FROM ')