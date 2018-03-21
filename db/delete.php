<?php

$dbh = new PDO('mysql:host=localhost;dbname=budget_app_db', 'root', 'mysql_matBras1992');

if ($_GET['type'] === 'income') {
    $stmt = $dbh->prepare('DELETE FROM income WHERE id = ?');
    $stmt->bindParam(1, intval($_GET['id']), PDO::PARAM_INT);
    $stmt->execute();
    
    $updateBudgetStmt = $dbh->prepare('UPDATE budget SET total_income = total_income - ?, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
    $updateBudgetStmt->bindParam(1, intval($_GET['amount']), PDO::PARAM_INT);
    $updateBudgetStmt->execute();
}
if ($_GET['type'] === 'expense') {
    $stmt = $dbh->prepare('DELETE FROM expense WHERE id = ?');
    $stmt->bindParam(1, intval($_GET['id']), PDO::PARAM_INT);
    $stmt->execute();
    
    $updateBudgetStmt = $dbh->prepare('UPDATE budget SET total_expense = total_expense - ?, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
    $updateBudgetStmt->bindParam(1, intval($_GET['amount']), PDO::PARAM_INT);
    $updateBudgetStmt->execute();
}
