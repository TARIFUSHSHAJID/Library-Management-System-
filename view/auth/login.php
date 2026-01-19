<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="auth-form">
    <h2>Login</h2>
    <?php if(isset($data['error'])): ?>
        <p class="error"><?php echo $data['error']; ?></p>
    <?php endif; ?>
    
    <form action="<?= BASE_URL ?>/auth/login" method="POST" id="loginForm" novalidate>
        <?php csrf_field(); ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
            <span class="error-msg" id="emailError"></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <span class="error-msg" id="passwordError"></span>
        </div>
        <button type="submit" class="btn">Login</button>
        <div style="margin-top: 15px; text-align: center;">
            <a href="<?= BASE_URL ?>/auth/forgotPassword" style="color: #666; font-size: 0.9em;">Forgot Password?</a>
        </div>
    </form>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
