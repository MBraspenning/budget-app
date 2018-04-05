<?php

require_once('../config.php');

$dbh = new PDO($db_dsn, $db_user, $db_password);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $now = date('Y-m-d');

    if ($_GET['type'] === 'income') {
        $getIncomeStmt = $dbh->prepare('SELECT amount FROM income WHERE id = ?');
        $getIncomeStmt->bindParam(1, intval($_GET['id']), PDO::PARAM_INT);
        $getIncomeStmt->execute();
        
        $currentIncomeAmount = $getIncomeStmt->fetch(PDO::FETCH_ASSOC);
                
        $stmt = $dbh->prepare('UPDATE income SET income = ?, amount = ? WHERE id = ?');
        $stmt->bindParam(1, $_GET['description'], PDO::PARAM_STR);        
        $stmt->bindParam(2, intval($_GET['amount']), PDO::PARAM_INT);        
        $stmt->bindParam(3, intval($_GET['id']), PDO::PARAM_INT);        
        $stmt->execute();
        
        $updateTotalIncomeAmount = intval($_GET['amount']) - intval($currentIncomeAmount['amount']);
        
        $updateBudgetStmt = $dbh->prepare('UPDATE budget SET total_income = total_income + ?, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
        $updateBudgetStmt->bindParam(1, $updateTotalIncomeAmount, PDO::PARAM_INT);
        $updateBudgetStmt->execute();
    }
    if ($_GET['type'] === 'expense') {
        $getExpenseStmt = $dbh->prepare('SELECT amount FROM expense WHERE id = ?');
        $getExpenseStmt->bindParam(1, intval($_GET['id']), PDO::PARAM_INT);
        $getExpenseStmt->execute();
        
        $currentExpenseAmount = $getExpenseStmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = $dbh->prepare('UPDATE expense SET expense = ?, amount = ? WHERE id = ?');
        $stmt->bindParam(1, $_GET['description'], PDO::PARAM_STR);        
        $stmt->bindParam(2, intval($_GET['amount']), PDO::PARAM_INT);        
        $stmt->bindParam(3, intval($_GET['id']), PDO::PARAM_INT);        
        $stmt->execute();
        
        $updateTotalExpenseAmount = intval($_GET['amount']) - intval($currentExpenseAmount['amount']);

        $updateBudgetStmt = $dbh->prepare('UPDATE budget SET total_expense = total_expense + ?, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
        $updateBudgetStmt->bindParam(1, $updateTotalExpenseAmount, PDO::PARAM_INT);
        $updateBudgetStmt->execute();
    }
};


