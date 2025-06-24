
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4"><?php echo $translations[$lang]['login_title']; ?></h2>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo $translations[$lang]['email']; ?></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo $translations[$lang]['password']; ?></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['login_button']; ?></button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <p><?php echo $translations[$lang]['no_account']; ?> <a href="index.php?controller=auth&action=register"><?php echo $translations[$lang]['register_here']; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 