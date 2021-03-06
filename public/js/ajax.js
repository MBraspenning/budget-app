const urlroot = 'http://localhost/budgetapp';

loadData();

document.getElementById('submit').addEventListener('click', addIncExp);
document.getElementById('income-list').addEventListener('click', editItem);
document.getElementById('expense-list').addEventListener('click', editItem);

function addIncExp(e) {
    e.preventDefault();
    
    var submit = document.getElementById('submit').value;
    var selectType = document.getElementById('select-type').value;
    var description = document.getElementById('description').value;
    var amount = document.getElementById('amount').value;
    
    var params = "submit=" + submit + "&select-type=" + selectType + "&description=" + description + "&amount=" + amount;
    
    var xhrAdd = new XMLHttpRequest();
    xhrAdd.open('POST', urlroot + '/ajax/insert', true);
    xhrAdd.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhrAdd.onload = function() {
        if(this.status === 200 && this.readyState === 4) {
            loadData();
        }
    }
    xhrAdd.send(params);
    document.getElementById('description').value = '';
    document.getElementById('amount').value = '';
}

function showEditForm(index, type) {
    var editForm = document.getElementById(type+'-edit-form-'+index);
    if (editForm.style.display === '') {
        editForm.style.display = 'block';
    } else {
        editForm.style.display = '';
    }
}

function editItem(e) {
    e.preventDefault();
    var itemId = e.target.id;
    
    if (e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id === 'income-list') {
        if (!isNaN(itemId) && itemId > 0) {
            var description = document.getElementById('income-description'+itemId).value;
            var amount = document.getElementById('income-amount'+itemId).value;

            var params = "id=" + itemId + "&type=income&description=" + description + "&amount=" + amount;

            var xhrEdit = new XMLHttpRequest();
            xhrEdit.open('PUT', urlroot + '/ajax/edit?'+params, true);
            xhrEdit.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhrEdit.onload = function() {
                if (this.status === 200 && this.readyState === 4) {
                    loadData();
                    showEditForm();
                }
            }
            xhrEdit.send(); 
        }   
    }
    
    if (e.target.parentElement.parentElement.parentElement.parentElement.parentElement.id === 'expense-list') {
        if (!isNaN(itemId) && itemId > 0) {
            var description = document.getElementById('expense-description'+itemId).value;
            var amount = document.getElementById('expense-amount'+itemId).value;

            var params = "id=" + itemId + "&type=expense&description=" + description + "&amount=" + amount;

            var xhrEdit = new XMLHttpRequest();
            xhrEdit.open('PUT', urlroot + '/ajax/edit?'+params, true);
            xhrEdit.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhrEdit.onload = function() {
                if (this.status === 200 && this.readyState) {
                    loadData();
                    showEditForm();
                }
            }
            xhrEdit.send();
        }    
    }

}

function deleteIncExp(id, type, amount) {    
    var xhrDelete = new XMLHttpRequest();
    xhrDelete.open('DELETE', urlroot + '/ajax/delete?id='+id+'&type='+type+'&amount='+amount, true);
    xhrDelete.onload = function() {
        if(this.status === 200) {
            loadData();        
        }
    }
    xhrDelete.send();
}


function loadData() {
    console.log('load function');
    var xhr = new XMLHttpRequest();

    xhr.open('GET', urlroot + '/ajax/fetch', true);
    xhr.onload = function() {
        if(this.status === 200) {
            var responseData = JSON.parse(this.responseText);
            var budget = JSON.parse(responseData[0]);
            var income = JSON.parse(responseData[1]);
            var expense = JSON.parse(responseData[2]);

            var budgetDOM = document.getElementById('monthly-budget');
            var budgetAmountDOM = document.getElementById('monthly-budget-amount');
            var incomeDOM = document.getElementById('total-income');
            var expenseDOM = document.getElementById('total-expense');
            
            var totalBudget;
            var totalIncome;
            var totalExpense;
            
            if (typeof(budget[0]) === 'undefined') {
                totalBudget = '0.00';
                totalIncome = '0.00';
                totalExpense = '0.00';
            } else {
                totalBudget = budget[0].total_budget;
                totalIncome = budget[0].total_income;
                totalExpense = budget[0].total_expense;
            }
                        
            budgetAmountDOM.innerHTML = totalBudget;
            incomeDOM.innerHTML = 'Total Income : € ' + totalIncome;
            expenseDOM.innerHTML = 'Total Expenses : € ' + totalExpense;

            var incomeOuput = '';
            for (var i = income.length - 1; i >= 0; i--) {
                incomeOuput += '<li class=\'list-group-item\'>'
                        +income[i].income+
                        '<span class=\'text-success float-right list-amount\'>+ '
                        +income[i].amount+
                        '&nbsp;&nbsp;'
                        +'<span class="edit-span ml-3">'
                        +'<i class="fas fa-edit" onclick="showEditForm('+income[i].id+', \'income\')"></i>'
                        +'</span>'
                        +'&nbsp;&nbsp;'
                        +'<span style="color:grey!important;">&verbar;</span>'
                        +'&nbsp;&nbsp;'
                        +'<span class="trash-can-span">'
                        +'<i class="fas fa-trash-alt text-danger" id="delete-income-item-'+income[i].id+'" onclick="deleteIncExp('+income[i].id+', \'income\', '+income[i].amount+')">'
                        +'</span>'
                        +'</i>'
                        +'</span></li>'
                
                        +'<li class="list-group-item edit-form" id="income-edit-form-'+income[i].id+'">'
                        +'<form action="" method="post">'
                        +'<div class="row">'
                        +'<div class="col-md-6 mt-3">'
                        +'<input class="form-control" type="text" name="income-description'+income[i].id+'" id="income-description'+income[i].id+'" value="'+income[i].income+'">'         
                        +'</div>'
                        +'<div class="col-md-3 mt-3">'
                        +'<input class="form-control" type="number" step="any" name="income-amount'+income[i].id+'" id="income-amount'+income[i].id+'" value="'+income[i].amount+'">'   
                        +'</div>'
                        +'<div class="col-md-3 mb-3 mt-3">'
                        +'<input style="width:100%;" class="btn btn-outline-primary edit-submit-button" type="submit" name="submitIncome'+income[i].id+'" id="'+income[i].id+'" value="Edit">'                      
                        +'</div>'
                        +'</div>'
                        +'</form>'
                        +'</li>';  
            }

            document.getElementById('income-list').innerHTML = incomeOuput;
            
            var expenseOuput = '';
            for(var i = expense.length - 1; i >= 0; i--) {
                expenseOuput += '<li class=\'list-group-item\'>'
                        +expense[i].expense
                        +'<span class=\'text-danger float-right list-amount\'>- '
                        +expense[i].amount
                        +'&nbsp;&nbsp;'
                        +'<span class="edit-span ml-3">'
                        +'<i class="fas fa-edit" onclick="showEditForm('+expense[i].id+', \'expense\')"></i>'
                        +'</span>'
                        +'&nbsp;&nbsp;<span style="color:grey!important;">&verbar;</span>'
                        +'&nbsp;&nbsp;'
                        +'<span class="trash-can-span">'
                        +'<i class="fas fa-trash-alt text-danger" id="delete-expense-item-'+expense[i].id+'" onclick="deleteIncExp('+expense[i].id+', \'expense\', '+expense[i].amount+')">'
                        +'</span>'
                        +'</i>'
                        +'</span></li>'  
                        
                        +'<li class="list-group-item edit-form" id="expense-edit-form-'+expense[i].id+'">'
                        +'<form action="" method="post">'
                        +'<div class="row">'
                        +'<div class="col-md-6 mt-3">'
                        +'<input class="form-control" type="text" name="expense-description'+expense[i].id+'" id="expense-description'+expense[i].id+'" value="'+expense[i].expense+'">'         
                        +'</div>'
                        +'<div class="col-md-3 mt-3">'
                        +'<input class="form-control" type="number" step="any" name="expense-amount'+expense[i].id+'" id="expense-amount'+expense[i].id+'" value="'+expense[i].amount+'">'   
                        +'</div>'
                        +'<div class="col-md-3 mb-3 mt-3">'
                        +'<input style="width:100%;" class="btn btn-outline-primary edit-submit-button" type="submit" name="submitExpense'+expense[i].id+'" id="'+expense[i].id+'" value="Edit">'                      
                        +'</div>'
                        +'</div>'
                        +'</form>'
                        +'</li>';  
            }

            document.getElementById('expense-list').innerHTML = expenseOuput;
        }
    }
    xhr.send(); 
}
