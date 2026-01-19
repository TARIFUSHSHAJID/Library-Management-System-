<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="auth-form">
    <h2>Reset Password</h2>
    <?php if(isset($data['error'])): ?>
        <p class="error"><?php echo $data['error']; ?></p>
    <?php endif; ?>

    <form action="/auth/resetPassword/<?php echo $data['token']; ?>" method="POST">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" required minlength="6">
        </div>
        <button type="submit" class="btn">Update Password</button>
    </form>
</div>

18→<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
