const urlroot = 'http://localhost/budgetapp';

document.getElementById('getArchive').addEventListener('click', fetchArchive);

var months = [
    'January', 
    'February', 
    'March', 
    'April', 
    'May', 
    'June', 
    'July', 
    'August', 
    'September', 
    'October', 
    'November', 
    'December'
];

function fetchArchive(e) {
    e.preventDefault();
    
    var month = document.getElementById('month').value;
    var year = document.getElementById('year').value;
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', urlroot + '/ajax/fetch?month='+month+'&year='+year, true);
    xhr.onload = function() {
        if(this.status === 200) {            
            var responseData = JSON.parse(this.responseText);
            var budget = JSON.parse(responseData[0]);
            var income = JSON.parse(responseData[1]);
            var expense = JSON.parse(responseData[2]);
                        
            console.log(budget);
            
            var domElement = document.createElement('div');
            domElement.id = "child";
            
            if (budget.length > 0) {
                domElement.classList.add('row');
                
                
                
                var domColumn12 = document.createElement('div');
                domColumn12.classList.add('col-md-12');
                domElement.appendChild(domColumn12);
                
                var jumbotron = document.createElement('div');
                jumbotron.classList.add('mb-5');
                domColumn12.appendChild(jumbotron);
                
                var totalBudgetElement = document.createElement('h4');
                var totalBudgetElement2 = document.createElement('h4');
                totalBudgetElement.classList.add('text-center');
                totalBudgetElement2.classList.add('text-center');
                var totalBudgetText = document.createTextNode('Budget for ' + months[month-1] + ' ' + year);
                var totalBudgetTextAmount = document.createTextNode('€ ' + budget[0].total_budget);
                totalBudgetElement.appendChild(totalBudgetText);
                totalBudgetElement2.appendChild(totalBudgetTextAmount);
                jumbotron.appendChild(totalBudgetElement);
                jumbotron.appendChild(totalBudgetElement2);
                
                var domRow = document.createElement('div');
                domRow.classList.add('row');
                domColumn12.appendChild(domRow);
                
                var domColumn6 = document.createElement('div');
                domColumn6.classList.add('col-md-6');
                domRow.appendChild(domColumn6);

                var incomeHeader = document.createElement('h3');
                incomeHeader.classList.add('page-header');
                incomeHeader.classList.add('text-success');
                
                var incomeText = document.createTextNode('Income');
                incomeHeader.appendChild(incomeText);
                domColumn6.appendChild(incomeHeader);
                
                var incomeList = document.createElement('ul');
                incomeList.id = 'income-list';
                incomeList.classList.add('list-group');
                incomeList.classList.add('list-group-flush');
                incomeList.classList.add('pt-3');
                domColumn6.appendChild(incomeList);
                
                var incomeTotalListItem = document.createElement('li');
                incomeTotalListItem.classList.add('list-group-item');
                incomeTotalListItem.style.borderTop = 'none';
                incomeList.appendChild(incomeTotalListItem);
                
                var incomeTotalListHeader = document.createElement('h6');
                var incomeTotalText = document.createTextNode('Total Income');
                incomeTotalListHeader.appendChild(incomeTotalText);
                var incomeTotalAmountNode = document.createElement('span');
                incomeTotalAmountNode.classList.add('float-right');
                incomeTotalAmountNode.classList.add('text-success');
                var incomeTotalAmountText = document.createTextNode('+ ' + budget[0].total_income);
                incomeTotalAmountNode.appendChild(incomeTotalAmountText);
                incomeTotalListHeader.appendChild(incomeTotalAmountNode);
                incomeTotalListItem.appendChild(incomeTotalListHeader);
                
                for (var i = income.length - 1; i >= 0; i--) {
                    
                    var incomeListItem = document.createElement('li');
                    incomeListItem.classList.add('list-group-item');
                    
                    var incomeListItemDescription = document.createTextNode(income[i].income);
                    var incomeListItemAmountSpan = document.createElement('span');
                    incomeListItemAmountSpan.classList.add('text-success');
                    incomeListItemAmountSpan.classList.add('float-right');
                    var incomeListItemAmountText = document.createTextNode('+ ' + income[i].amount);
                    incomeListItemAmountSpan.appendChild(incomeListItemAmountText);
                    
                    incomeListItem.appendChild(incomeListItemDescription);
                    incomeListItem.appendChild(incomeListItemAmountSpan);
                    
                    incomeList.appendChild(incomeListItem);
                    
                }
                
                var domColumn6number2 = document.createElement('div');
                domColumn6number2.classList.add('col-md-6');
                domRow.appendChild(domColumn6number2);
                
                var expenseHeader = document.createElement('h3');
                expenseHeader.classList.add('page-header');
                expenseHeader.classList.add('text-danger');
                
                var expenseText = document.createTextNode('Expense');
                expenseHeader.appendChild(expenseText);
                domColumn6number2.appendChild(expenseHeader);
                
                var expenseList = document.createElement('ul');
                expenseList.id = 'expense-list';
                expenseList.classList.add('list-group');
                expenseList.classList.add('list-group-flush');
                expenseList.classList.add('pt-3');
                domColumn6number2.appendChild(expenseList);
                
                var expenseTotalListItem = document.createElement('li');
                expenseTotalListItem.classList.add('list-group-item');
                expenseTotalListItem.style.borderTop = 'none';
                expenseList.appendChild(expenseTotalListItem);
                
                var expenseTotalListHeader = document.createElement('h6');
                var expenseTotalText = document.createTextNode('Total Expense');
                expenseTotalListHeader.appendChild(expenseTotalText);
                var expenseTotalAmountNode = document.createElement('span');
                expenseTotalAmountNode.classList.add('float-right');
                expenseTotalAmountNode.classList.add('text-danger');
                var expenseTotalAmountText = document.createTextNode('- ' + budget[0].total_expense);
                expenseTotalAmountNode.appendChild(expenseTotalAmountText);
                expenseTotalListHeader.appendChild(expenseTotalAmountNode);
                expenseTotalListItem.appendChild(expenseTotalListHeader);
                
                for (var i = expense.length - 1; i >= 0; i--) {
                    
                    var expenseListItem = document.createElement('li');
                    expenseListItem.classList.add('list-group-item');
                    
                    var expenseListItemDescription = document.createTextNode(expense[i].expense);
                    var expenseListItemAmountSpan = document.createElement('span');
                    expenseListItemAmountSpan.classList.add('text-danger');
                    expenseListItemAmountSpan.classList.add('float-right');
                    var expenseListItemAmountText = document.createTextNode('- ' + expense[i].amount);
                    expenseListItemAmountSpan.appendChild(expenseListItemAmountText);
                    
                    expenseListItem.appendChild(expenseListItemDescription);
                    expenseListItem.appendChild(expenseListItemAmountSpan);
                    
                    expenseList.appendChild(expenseListItem);
                    
                }
            
                domElement.appendChild(domColumn12);
                
            } else {
                var domContent = document.createTextNode('You don\'t have any entries in the archive for ' + months[month - 1] + ' ' + year);
                domElement.classList.add('alert');
                domElement.classList.add('alert-danger');
                
                domElement.appendChild(domContent);
            }
            
            document.querySelector('#parent').replaceChild(domElement, document.querySelector('#child'));
        
        }
    }
    xhr.send();
}