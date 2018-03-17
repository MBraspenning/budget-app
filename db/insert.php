<?php

$dbh = new PDO('mysql:host=localhost;dbname=budget_app_db', 'root', 'mysql_matBras1992');
$now = date('Y-m-d');
$currentMonth = intval(date('n'));

$budgetStmt = $dbh->prepare('SELECT month FROM budget ORDER BY id DESC LIMIT 1');
$budgetStmt->execute();
$budgetMonth = $budgetStmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    if ($_POST['select-type'] === 'select-income') {
        $stmt = $dbh->prepare('INSERT INTO income (income, amount, added_date) VALUES (?, ?, ?)');
        $stmt->bindParam(1, $_POST['description']);
        $stmt->bindParam(2, $_POST['amount']);
        $stmt->bindParam(3, $now);
        $stmt->execute();
        
        if (intval($budgetMonth['month']) === $currentMonth) {
            $updateBudgetStmt = $dbh->prepare('UPDATE budget SET total_income = total_income + ?, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
            $updateBudgetStmt->bindParam(1, $_POST['amount']);
            $updateBudgetStmt->execute();
        } else {
            $newBudgetStmt = $dbh->prepare('INSERT INTO budget (month, total_income, total_budget) VALUES (?, ?, ?)');
            $newBudgetStmt->bindParam(1, $currentMonth, PDO::PARAM_INT);
            $newBudgetStmt->bindParam(2, $_POST['amount']);
            $newBudgetStmt->bindParam(3, $_POST['amount']);
            $newBudgetStmt->execute();
        }
    }
    if ($_POST['select-type'] === 'select-expense') {
        $stmt = $dbh->prepare('INSERT INTO expense (expense, amount, added_date) VALUES (?, ?, ?)');
        $stmt->bindParam(1, $_POST['description']);
        $stmt->bindParam(2, $_POST['amount']);
        $stmt->bindParam(3, $now);
        $stmt->execute();
        
        if (intval($budgetMonth['month']) === $currentMonth) {
            $updateBudgetStmt = $dbh->prepare('UPDATE budget SET total_expense = total_expense + ?, total_budget = total_income - total_expense ORDER BY id DESC LIMIT 1');
            $updateBudgetStmt->bindParam(1, $_POST['amount']);
            $updateBudgetStmt->execute();
        } else {
            $newBudgetStmt = $dbh->prepare('INSERT INTO budget (month, total_expense, total_budget) VALUES (?, ?, ?)');
            $newBudgetStmt->bindParam(1, $currentMonth, PDO::PARAM_INT);
            $newBudgetStmt->bindParam(2, $_POST['amount']);
            $new_total_budget = 0.00 - $_POST['amount'];
            $newBudgetStmt->bindParam(3, $new_total_budget);
            $newBudgetStmt->execute();
        }
    }
}
