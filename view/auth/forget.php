<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="auth-form">
    <h2>Forgot Password</h2>
    <?php if(isset($data['error'])): ?>
        <p class="error"><?php echo $data['error']; ?></p>
    <?php endif; ?>
    <?php if(isset($data['success'])): ?>
        <p class="success" style="color: green; background: #e6fffa; padding: 10px; border: 1px solid green;"><?php echo $data['success']; ?></p>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/auth/forgotPassword" method="POST">
        <div class="form-group">
            <label for="email">Enter your email address</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button type="submit" class="btn">Send Reset Link</button>
        <a href="<?= BASE_URL ?>/auth/login" class="btn btn-secondary">Back to Login</a>
    </form>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
