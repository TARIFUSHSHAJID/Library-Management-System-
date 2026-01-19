<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <h2>My Wishlist</h2>
    
    <table>
        <thead>
            <tr>
                <th>Book Title</th>
                <th>Author</th>
                <th>Added Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($data['wishlist'])): ?>
                <tr><td colspan="4">Your wishlist is empty.</td></tr>
            <?php else: ?>
                <?php foreach($data['wishlist'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['book']['title'] ?? 'Unknown Book'); ?></td>
                    <td><?php echo htmlspecialchars($item['book']['author'] ?? 'Unknown'); ?></td>
                    <td><?php echo htmlspecialchars($item['added_at']); ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/wishlist/remove/<?php echo $item['book_id']; ?>" class="btn-danger">Remove</a>
                        <?php if(($item['book']['available_quantity'] ?? 0) > 0): ?>
                            <a href="<?= BASE_URL ?>/loan/borrow/<?php echo $item['book_id']; ?>" class="btn">Borrow Now</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
