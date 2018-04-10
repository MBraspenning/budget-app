<?php include APPROOT . '/views/partials/header.php'; ?>   
<?php include APPROOT . '/views/partials/navigation.php'; ?>
    
<?php

//    require_once('config.php');
//
//    $dbh = new PDO($db_dsn, $db_user, $db_password);
//    $fetchAllDates = $dbh->prepare('SELECT added_date FROM income');
//    $fetchAllDates->execute();
//
//    $allDates = $fetchAllDates->fetchAll(PDO::FETCH_ASSOC);
//
//    $years = [];
//
//    foreach($allDates as $date) {
//        $years[] = substr($date['added_date'], 0, 4);
//    }
//    $yearsUnique = array_unique($years);

?>
   
<div class="container">
    <h1 class="page-header text-center mb-5 mt-4">Archive</h1>  
    <div class="row  mb-5">
        <div class="col-md-8 mx-auto">
            <form action="/db/archive/fetch.php" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" name="month" id="month">
                            <option selected disabled>Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>    
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="year" id="year">
                            <option selected disabled>Year</option>
                            <?php
                                foreach($yearsUnique as $year) {
                                    echo '<option value="'.$year.'">'.$year.'</option>';
                                }
                            ?>
                        </select>    
                    </div>
                    <div class="col-md-2">
                        <input class="btn btn-primary" type="submit" name="getArchive" id="getArchive" value="Search">                
                    </div>
                </div> 
            </form>    
        </div>
    </div>
    
    <hr>
    
    <div id="parent" class="mt-5">
        <div id="child">
            
        </div>   
    </div>
    
</div>
     
<script src="<?php echo URLROOT ?>/js/archive-ajax.js" type="text/javascript"></script>      
<?php include APPROOT . '/views/partials/footer.php'; ?>