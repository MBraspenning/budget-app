var monthlyBudget = document.getElementById('monthly-budget');
var currentMonth = new Date().getMonth();
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

monthlyBudget.innerHTML = monthlyBudget.innerHTML.replace(/%month%/, months[currentMonth]);

var typeSelect = document.getElementById('select-type');
var submitBtn = document.getElementById('submit');

typeSelect.addEventListener('change', function(){
    typeSelect.classList.toggle('red-focus');
    submitBtn.classList.toggle('btn-outline-danger');
});

