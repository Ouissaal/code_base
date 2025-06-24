<?php
require_once 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4"><?php echo $translations[$lang]['edit_profile']; ?></h2>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                    <?php csrf_input_field(); ?>
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php echo $translations[$lang]['username']; ?></label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo $translations[$lang]['email']; ?></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3"><?php echo $translations[$lang]['change_password']; ?></h5>

                        <div class="mb-3">
                            <label for="current_password" class="form-label"><?php echo $translations[$lang]['current_password']; ?></label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <small class="text-muted"><?php echo $translations[$lang]['leave_empty_if_no_change']; ?></small>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label"><?php echo $translations[$lang]['new_password']; ?></label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label"><?php echo $translations[$lang]['confirm_password']; ?></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['save_changes']; ?></button>
                            <a href="index.php?controller=user&action=dashboard" class="btn btn-secondary"><?php echo $translations[$lang]['back_to_dashboard']; ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 