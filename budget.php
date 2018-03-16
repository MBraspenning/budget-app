<?php

    $dbh = new PDO('mysql:host=localhost;dbname=budget_app_db', 'root', 'mysql_matBras1992', []);

    if(isset($_POST['submit-income'])) {
        
        $query = 'INSERT INTO income (income, amount) VALUES (?, ?)';
        $stmtIncome = $dbh->prepare($query);
        $stmtIncome->bindParam(1, $_POST['income']);
        $stmtIncome->bindParam(2, $_POST['income-amount']);
//        var_dump($_POST['income-amount']);
//        die();
        $stmtIncome->execute();
    }

    if(isset($_POST['submit-expense'])) {
        $query = 'INSERT INTO expense (expense, amount) VALUES (?, ?)';
        $stmtExpense = $dbh->prepare($query);
        $stmtExpense->bindParam(1, $_POST['expense']);
        $stmtExpense->bindParam(2, $_POST['expense-amount']);
//        var_dump($stmtExpense);
//        die();
        $stmtExpense->execute();
    }