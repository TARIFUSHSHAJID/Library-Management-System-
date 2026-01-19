<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <h2>User Management</h2>
    
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['users'] as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role'] ?? 'user'); ?></td>
                <td><?php echo htmlspecialchars($user['created_at'] ?? 'N/A'); ?></td>
                <td>
                    <?php if(($user['role'] ?? 'user') !== 'admin'): ?>
                        <form action="<?= BASE_URL ?>/admin/deleteUser/<?php echo $user['id']; ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            <?php csrf_field(); ?>
                            <button type="submit" class="btn-danger" style="cursor: pointer;">Delete</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
