<?php include APPROOT . '/views/partials/header.php'; ?>
<?php include APPROOT . '/views/partials/navigation.php'; ?>

<div class="container">
    <div class="col-md-6 col-centered mt-5">
        <h4 class="mb-3">Login</h4>
        <form action="<?php echo URLROOT; ?>/user/login" method="POST">
            <div class="form-group">
                <input 
                    name="email" 
                    id="email" 
                    type="text"    
                    class="form-control <?php echo (!empty($data['errors']['email_error'])) ? 'is-invalid' : ''; ?>"
                    placeholder="Email"
                > 
                <span class="invalid-feedback">
                    <?php echo $data['errors']['email_error']; ?>
                </span>   
            </div>
            <div class="form-group">
                <input 
                    name="password" 
                    id="password" 
                    type="password" 
                    class="form-control <?php echo (!empty($data['errors']['password_error'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Password"
                > 
                <span class="invalid-feedback">
                    <?php echo $data['errors']['password_error']; ?>
                </span>   
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input 
                            class="btn btn-primary" 
                            type="submit" 
                            value="Login" 
                            name="login" 
                            id="login"
                        >
                    </div>     
                </div>
                <div class="col-md-8">
                    <a href="<?php echo URLROOT; ?>/register" class="btn btn-link btn-block">
                        <span class="float-right">Don't have an account? Register</span>
                    </a>    
                </div>   
            </div>                       
        </form>
    </div>
</div>

<?php include APPROOT . '/views/partials/footer.php'; ?>