<?php

require_once('../config.php');

$dbh = new PDO($db_dsn, $db_user, $db_password);

$month = '';
$year = '';
if($_GET['month'] === 'current' && $_GET['year'] === 'current') {
    $month = intval(date('n'));
    $year = intval(date('Y'));
}
else {
    $month = intval($_GET['month']);
    $year = intval($_GET['year']);
}

// FETCH BUDGET TABLE
$budgetStmt = $dbh->prepare('SELECT * FROM budget WHERE month = ? AND year = ? ORDER BY id DESC LIMIT 1');
$budgetStmt->bindParam(1, $month, PDO::PARAM_INT);
$budgetStmt->bindParam(2, $year, PDO::PARAM_INT);
$budgetStmt->execute();

$budget = $budgetStmt->fetchAll(PDO::FETCH_ASSOC);
$budgetJSON = json_encode($budget);

// FETCH INCOME TABLE
$incomeStmt = $dbh->prepare('SELECT * FROM income WHERE MONTH(added_date) = ? AND YEAR(added_date) = ?');
$incomeStmt->bindParam(1, $month, PDO::PARAM_INT);
$incomeStmt->bindParam(2, $year, PDO::PARAM_INT);
$incomeStmt->execute();

$income = $incomeStmt->fetchAll(PDO::FETCH_ASSOC);
$incomeJSON = json_encode($income);

// FETCH EXPENSE TABLE
$expenseStmt = $dbh->prepare('SELECT * FROM expense WHERE MONTH(added_date) = ? AND YEAR(added_date) = ?');
$expenseStmt->bindParam(1, $month, PDO::PARAM_INT);
$expenseStmt->bindParam(2, $year, PDO::PARAM_INT);
$expenseStmt->execute();

$expense = $expenseStmt->fetchAll(PDO::FETCH_ASSOC);
$expenseJSON = json_encode($expense);

// STORE IN ARRAY, ENCODE AS JSON AND ECHO
$jsonArr = [$budgetJSON, $incomeJSON, $expenseJSON];
$jsonArrJSON = json_encode($jsonArr);

echo $jsonArrJSON;