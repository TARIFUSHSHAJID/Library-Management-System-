<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="auth-form">
    <h2>Register</h2>
    <?php if(isset($data['error'])): ?>
        <p class="error"><?php echo $data['error']; ?></p>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/auth/register" method="POST" id="registerForm" novalidate>
        <?php csrf_field(); ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
            <span class="error-msg" id="usernameError"></span>
        </div>
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
        <button type="submit" class="btn">Register</button>
    </form>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
