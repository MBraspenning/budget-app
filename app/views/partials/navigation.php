<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav mr-auto ml-4">
            <li class="nav-item">
                <a class="nav-item nav-link" href="<?php echo URLROOT; ?>">Home</a>    
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link" href="<?php echo URLROOT; ?>/archive">Archive</a>    
            </li>                           
        </ul>
        <?php if (isLoggedIn()) : ?>
        <ul class="navbar-nav ml-auto mr-4">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo URLROOT; ?>/user/logout">Logout</a>        
            </li>
        </ul>
        <?php endif; ?>                     
    </div>
</nav>