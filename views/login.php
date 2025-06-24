<?php require 'views/includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap/css/bootstrap.min.css">

</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="text-center mb-4"><?php echo $translations[$lang]['login']; ?></h2>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?controller=auth&action=login">
                        <?php csrf_input_field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo $translations[$lang]['email']; ?></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo $translations[$lang]['password']; ?></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['loginBTN']; ?></button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p><?php echo $translations[$lang]['dontHave_account']; ?><a href="index.php?controller=auth&action=register"><?php echo $translations[$lang]['RegisterHere']; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php require 'views/includes/footer.php'; ?>
