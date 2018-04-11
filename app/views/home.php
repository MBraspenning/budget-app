<?php include APPROOT . '/views/partials/header.php'; ?>
<?php include APPROOT . '/views/partials/navigation.php'; ?>

<div class="container">
    <div class="col-md-12 mb-5">
        <h4 class="page-header text-center mb-3 mt-4" id="monthly-budget">Budget for %month% :</h4>
        <div class="row">
            <div class="col-md-12">
            <h3 class="page-header text-center mb-4"> € <span id="monthly-budget-amount"></span></h3>
                <div class="col-md-6 offset-md-3 col-centered mb-5 mt-3">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success" id="total-income"></li>
                        <li class="list-group-item list-group-item-danger" id="total-expense"></li>
                    </ul>
                </div>
            <form action="db/insert.php" method="post">
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-control" name="select-type" id="select-type">
                            <option value="select-income">+</option>
                            <option value="select-expense">-</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="description" id="description" placeholder="Add description">       
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="number" step="any" name="amount" id="amount" placeholder="Amount">   
                    </div>
                    <div class="col-md-2">
                        <input style="width:100%;" class="btn btn-outline-success" type="submit" name="submit" id="submit" value="Add">                      
                    </div>    
                </div>
            </form> 
            </div> 
        </div>
    </div>    
           
    <hr>
       
    <div class="row mt-5">
        <div class="col-md-6">
            <h3 class="page-header text-success">Income</h3>
            <ul class="list-group list-group-flush pt-3" id="income-list">

            </ul>    
        </div>
        <div class="col-md-6">
            <h3 class="page-header text-danger">Expenses</h3>
            <ul class="list-group list-group-flush pt-3" id="expense-list">

            </ul>
        </div>    
    </div>
        
</div>  
<script src="<?php echo URLROOT ?>/js/test-ajax.js" type="text/javascript"></script>  
<script src="<?php echo URLROOT ?>/js/ajax.js" type="text/javascript"></script>  
<script src="<?php echo URLROOT ?>/js/script.js" type="text/javascript"></script>                 
<?php include APPROOT . '/views/partials/footer.php'; ?>