<?php include APPROOT . '/views/partials/header.php'; ?>
<?php include APPROOT . '/views/partials/navigation.php'; ?>

<div class="container">
    <div class="col-md-6 col-centered mt-5">
        <h4 class="mb-3">Register Account</h4>
        <form action="<?php echo URLROOT; ?>/user/register" method="POST">
            <div class="form-group">
                <input 
                    name="username" 
                    id="username" 
                    type="text" 
                    class="form-control <?php echo (!empty($data['errors']['username_error'])) ? 'is-invalid' : ''; ?>"                     
                    placeholder="Username"
                    <?php if (!empty($data['user_register_input']['username'])) : ?>
                    value="<?php echo $data['user_register_input']['username'] ?>"
                    <?php endif; ?>
                >   
                <span class="invalid-feedback">
                    <?php echo $data['errors']['username_error']; ?>
                </span> 
            </div>
            <div class="form-group">
                <input 
                    name="email" 
                    id="email" 
                    type="text"    
                    class="form-control <?php echo (!empty($data['errors']['email_error'])) ? 'is-invalid' : ''; ?>"                    
                    placeholder="Email"
                    <?php if (!empty($data['user_register_input']['email'])) : ?>
                    value="<?php echo $data['user_register_input']['email'] ?>"
                    <?php endif; ?>
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
            <div class="form-group">
                <input 
                    name="confirm_password" 
                    id="confirm_password" 
                    type="password" 
                    class="form-control <?php echo (!empty($data['errors']['confirm_password_error'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Confirm Password"
                > 
                <span class="invalid-feedback">
                    <?php echo $data['errors']['confirm_password_error']; ?>
                </span>   
            </div> 
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input 
                            class="btn btn-primary" 
                            type="submit" 
                            value="Register" 
                            name="register" 
                            id="register"
                        >
                    </div>     
                </div>
                <div class="col-md-8">
                    <a href="<?php echo URLROOT; ?>/login" class="btn btn-link btn-block">
                        <span class="float-right">Have an account? Login</span>
                    </a>    
                </div>   
            </div>            
        </form>
    </div>
</div>

<?php include APPROOT . '/views/partials/footer.php'; ?>