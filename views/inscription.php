<?php require 'views/includes/header.php'; ?>



<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4"><?php echo $translations[$lang]['register_title']; ?></h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form action="index.php?controller=auth&action=register" method="POST">
                        <?php csrf_input_field(); ?>
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php echo $translations[$lang]['username']; ?></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo $translations[$lang]['email']; ?></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo $translations[$lang]['password']; ?></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="text-muted"><?php echo $translations[$lang]['password_requirements']; ?></small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label"><?php echo $translations[$lang]['confirm_password']; ?></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['register_button']; ?></button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p><?php echo $translations[$lang]['already_account']; ?> <a href="index.php?controller=auth&action=login"><?php echo $translations[$lang]['login_here']; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'views/includes/footer.php'; ?>
