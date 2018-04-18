<?php include APPROOT . '/views/partials/header.php'; ?>
<?php include APPROOT . '/views/partials/navigation.php'; ?>

<div class="container">
    <div class="col-md-6 col-centered mt-5">
        <form action="" method="POST">
            <div class="form-group">
                <input name="username" id="username" type="text" class="form-control" placeholder="Username">    
            </div>
            <div class="form-group">
                <input name="email" id="email" type="text" class="form-control" placeholder="Email">    
            </div>
            <div class="form-group">
                <input name="password" id="password" type="password" class="form-control" placeholder="Password">    
            </div>
            <div class="form-group">
                <input name="confirm_password" id="confirm_password" type="password" class="form-control" placeholder="Confirm Password">    
            </div> 
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Register" name="register" id="register">
            </div>           
        </form>
    </div>
</div>

<?php include APPROOT . '/views/partials/footer.php'; ?>