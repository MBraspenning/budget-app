//var xhr = new XMLHttpRequest();
//
//xhr.open('GET', 'http://localhost/budgetapp/ajax/fetch', true);
//xhr.onload = function() {
//    if(this.status === 200) {
//        console.log(this.responseText);
//        
//        var responseData = JSON.parse(this.responseText);
//        var budget = JSON.parse(responseData[0]);
//        var income = JSON.parse(responseData[1]);
//        var expense = JSON.parse(responseData[2]);
//
//        var budgetDOM = document.getElementById('monthly-budget');
//        var budgetAmountDOM = document.getElementById('monthly-budget-amount');
//        var incomeDOM = document.getElementById('total-income');
//        var expenseDOM = document.getElementById('total-expense');
//
//        var totalBudget;
//        var totalIncome;
//        var totalExpense;
//
//        if (typeof(budget[0]) === 'undefined') {
//            totalBudget = '0.00';
//            totalIncome = '0.00';
//            totalExpense = '0.00';
//        } else {
//            totalBudget = budget[0].total_budget;
//            totalIncome = budget[0].total_income;
//            totalExpense = budget[0].total_expense;
//        }
//
//        budgetAmountDOM.innerHTML = totalBudget;
//        incomeDOM.innerHTML = 'Total Income : € ' + totalIncome;
//        expenseDOM.innerHTML = 'Total Expenses : € ' + totalExpense;
//
//        var incomeOuput = '';
//        for (var i = income.length - 1; i >= 0; i--) {
//            incomeOuput += '<li class=\'list-group-item\'>'
//                    +income[i].income+
//                    '<span class=\'text-success float-right list-amount\'>+ '
//                    +income[i].amount+
//                    '&nbsp;&nbsp;'
//                    +'<span class="edit-span ml-3">'
//                    +'<i class="fas fa-edit" onclick="showEditForm('+income[i].id+', \'income\')"></i>'
//                    +'</span>'
//                    +'&nbsp;&nbsp;'
//                    +'<span style="color:grey!important;">&verbar;</span>'
//                    +'&nbsp;&nbsp;'
//                    +'<span class="trash-can-span">'
//                    +'<i class="fas fa-trash-alt text-danger" id="delete-income-item-'+income[i].id+'" onclick="deleteIncExp('+income[i].id+', \'income\', '+income[i].amount+')">'
//                    +'</span>'
//                    +'</i>'
//                    +'</span></li>'
//
//                    +'<li class="list-group-item edit-form" id="income-edit-form-'+income[i].id+'">'
//                    +'<form action="" method="post">'
//                    +'<div class="row">'
//                    +'<div class="col-md-6 mt-3">'
//                    +'<input class="form-control" type="text" name="income-description'+income[i].id+'" id="income-description'+income[i].id+'" value="'+income[i].income+'">'         
//                    +'</div>'
//                    +'<div class="col-md-3 mt-3">'
//                    +'<input class="form-control" type="number" step="any" name="income-amount'+income[i].id+'" id="income-amount'+income[i].id+'" value="'+income[i].amount+'">'   
//                    +'</div>'
//                    +'<div class="col-md-3 mb-3 mt-3">'
//                    +'<input style="width:100%;" class="btn btn-outline-primary edit-submit-button" type="submit" name="submitIncome'+income[i].id+'" id="'+income[i].id+'" value="Edit">'                      
//                    +'</div>'
//                    +'</div>'
//                    +'</form>'
//                    +'</li>';  
//
//        }
//
//        document.getElementById('income-list').innerHTML = incomeOuput;
//
//        var expenseOuput = '';
//        for(var i = expense.length - 1; i >= 0; i--) {
//            expenseOuput += '<li class=\'list-group-item\'>'
//                    +expense[i].expense
//                    +'<span class=\'text-danger float-right list-amount\'>- '
//                    +expense[i].amount
//                    +'&nbsp;&nbsp;'
//                    +'<span class="edit-span ml-3">'
//                    +'<i class="fas fa-edit" onclick="showEditForm('+expense[i].id+', \'expense\')"></i>'
//                    +'</span>'
//                    +'&nbsp;&nbsp;<span style="color:grey!important;">&verbar;</span>'
//                    +'&nbsp;&nbsp;'
//                    +'<span class="trash-can-span">'
//                    +'<i class="fas fa-trash-alt text-danger" id="delete-expense-item-'+expense[i].id+'" onclick="deleteIncExp('+expense[i].id+', \'expense\', '+expense[i].amount+')">'
//                    +'</span>'
//                    +'</i>'
//                    +'</span></li>'  
//
//                    +'<li class="list-group-item edit-form" id="expense-edit-form-'+expense[i].id+'">'
//                    +'<form action="" method="post">'
//                    +'<div class="row">'
//                    +'<div class="col-md-6 mt-3">'
//                    +'<input class="form-control" type="text" name="expense-description'+expense[i].id+'" id="expense-description'+expense[i].id+'" value="'+expense[i].expense+'">'         
//                    +'</div>'
//                    +'<div class="col-md-3 mt-3">'
//                    +'<input class="form-control" type="number" step="any" name="expense-amount'+expense[i].id+'" id="expense-amount'+expense[i].id+'" value="'+expense[i].amount+'">'   
//                    +'</div>'
//                    +'<div class="col-md-3 mb-3 mt-3">'
//                    +'<input style="width:100%;" class="btn btn-outline-primary edit-submit-button" type="submit" name="submitExpense'+expense[i].id+'" id="'+expense[i].id+'" value="Edit">'                      
//                    +'</div>'
//                    +'</div>'
//                    +'</form>'
//                    +'</li>';  
//        }
//
//        document.getElementById('expense-list').innerHTML = expenseOuput;
//    }
//}
//xhr.send();