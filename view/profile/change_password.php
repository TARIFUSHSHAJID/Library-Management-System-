<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <div class="auth-form">
        <h2>Change Password</h2>
        <form action="<?= BASE_URL ?>/profile/changePassword" method="POST">
            <?php csrf_field(); ?>
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password">
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password">
            </div>
            <button type="submit" class="btn">Change Password</button>
            <a href="<?= BASE_URL ?>/profile" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
