<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <div class="auth-form">
        <h2>Edit Profile</h2>
        <form action="<?= BASE_URL ?>/profile/edit" method="POST">
            <?php csrf_field(); ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($data['user']['username']); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($data['user']['email']); ?>">
            </div>
            <button type="submit" class="btn">Update Profile</button>
            <a href="<?= BASE_URL ?>/profile" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
