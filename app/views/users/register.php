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
                    class="form-control <?php echo (!empty($data['username_error'])) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $data['username']; ?>" 
                    placeholder="Username"
                >   
                <span class="invalid-feedback">
                    <?php echo $data['username_error']; ?>
                </span> 
            </div>
            <div class="form-group">
                <input 
                    name="email" 
                    id="email" 
                    type="text"    
                    class="form-control <?php echo (!empty($data['email_error'])) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $data['email']; ?>" 
                    placeholder="Email"
                > 
                <span class="invalid-feedback">
                    <?php echo $data['email_error']; ?>
                </span>   
            </div>
            <div class="form-group">
                <input 
                    name="password" 
                    id="password" 
                    type="password" 
                    class="form-control <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $data['password']; ?>" 
                    placeholder="Password"
                > 
                <span class="invalid-feedback">
                    <?php echo $data['password_error']; ?>
                </span>   
            </div>
            <div class="form-group">
                <input 
                    name="confirm_password" 
                    id="confirm_password" 
                    type="password" 
                    class="form-control <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid' : ''; ?>" 
                    value="<?php echo $data['confirm_password']; ?>" 
                    placeholder="Confirm Password"
                > 
                <span class="invalid-feedback">
                    <?php echo $data['confirm_password_error']; ?>
                </span>   
            </div> 
            <div class="form-group">
                <input 
                    class="btn btn-primary" 
                    type="submit" 
                    value="Register" 
                    name="register" 
                    id="register"
                >
            </div>           
        </form>
    </div>
</div>

<?php include APPROOT . '/views/partials/footer.php'; ?>