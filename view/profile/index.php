<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <div class="auth-form" style="max-width: 800px;"> <!-- Increased width for profile content -->
        <h2>My Profile</h2>
        
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($data['user']['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($data['user']['email']); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($data['user']['role'] ?? 'user'); ?></p>
            <p><strong>Member Since:</strong> <?php echo htmlspecialchars($data['user']['created_at'] ?? 'N/A'); ?></p>
        </div>
        
        <div class="actions" style="margin-top: 20px;">
            <a href="<?= BASE_URL ?>/profile/edit" class="btn">Edit Profile</a>
            <a href="<?= BASE_URL ?>/profile/changePassword" class="btn btn-secondary">Change Password</a>
        </div>
    </div>


    <!-- Active Loans Section 
    <div style="margin-top: 40px;">
        <h3>My Active Loans</h3>
        <?php  if(empty($data['loans'])): ?> 
            <p>You have no active loans.</p>
        <?php  else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Borrowed Date</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['loans'] as $loan): ?>
                        <tr>
                            <td><?= htmlspecialchars($loan['book_title']) ?></td>
                            <td><?= date('M d, Y', strtotime($loan['borrowed_at'])) ?></td>
                            <td><?= date('M d, Y', strtotime($loan['borrowed_at'] . ' + 14 days')) ?></td>
                            <td>
                                <form action="<?= BASE_URL ?>/loan/return/<?= $loan['id'] ?>" method="POST" style="display:inline;">
                                    <?php csrf_field(); ?>
                                    <button type="submit" class="btn" style="cursor: pointer;">Return</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
-->

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
