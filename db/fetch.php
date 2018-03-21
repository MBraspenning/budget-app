<?php

$dbh = new PDO('mysql:host=localhost;dbname=budget_app_db', 'root', 'mysql_matBras1992');
$currentMonth = intval(date('n'));

// FETCH BUDGET TABLE
$budgetStmt = $dbh->prepare('SELECT * FROM budget WHERE month = ? ORDER BY id DESC LIMIT 1');
$budgetStmt->bindParam(1, $currentMonth, PDO::PARAM_INT);
$budgetStmt->execute();

$budget = $budgetStmt->fetchAll(PDO::FETCH_ASSOC);
$budgetJSON = json_encode($budget);

// FETCH INCOME TABLE
$incomeStmt = $dbh->prepare('SELECT * FROM income WHERE MONTH(added_date) = ?');
$incomeStmt->bindParam(1, $currentMonth, PDO::PARAM_INT);
$incomeStmt->execute();

$income = $incomeStmt->fetchAll(PDO::FETCH_ASSOC);
$incomeJSON = json_encode($income);

// FETCH EXPENSE TABLE
$expenseStmt = $dbh->prepare('SELECT * FROM expense WHERE MONTH(added_date) = ?');
$expenseStmt->bindParam(1, $currentMonth, PDO::PARAM_INT);
$expenseStmt->execute();

$expense = $expenseStmt->fetchAll(PDO::FETCH_ASSOC);
$expenseJSON = json_encode($expense);

// STORE IN ARRAY, ENCODE AS JSON AND ECHO
$jsonArr = [$budgetJSON, $incomeJSON, $expenseJSON];
$jsonArrJSON = json_encode($jsonArr);

echo $jsonArrJSON;