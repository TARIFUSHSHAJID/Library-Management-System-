<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <h2>My Loan History</h2>
    
    <div class="loan-list">
        <table>
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Borrowed Date</th>
                    <th>Due Date</th>
                    <th>Returned Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($data['loans'])): ?>
                    <tr><td colspan="6">No loans found.</td></tr>
                <?php else: ?>
                    <?php foreach($data['loans'] as $loan): ?>
                    <?php 
                        // Check for overdue
                        $isOverdue = false;
                        if ($loan['returned_at'] === null && $loan['due_date'] && strtotime($loan['due_date']) < time()) {
                            $isOverdue = true;
                        }
                    ?>
                    <tr style="<?= $isOverdue ? 'background-color: #ffebee;' : '' ?>">
                        <td>
                            <strong><?= htmlspecialchars($loan['title']) ?></strong><br>
                            <small><?= htmlspecialchars($loan['author']) ?></small>
                        </td>
                        <td><?= date('M d, Y', strtotime($loan['borrowed_at'])) ?></td>
                        <td>
                            <?php if($loan['due_date']): ?>
                                <span style="<?= $isOverdue ? 'color: red; font-weight: bold;' : '' ?>">
                                    <?= date('M d, Y', strtotime($loan['due_date'])) ?>
                                </span>
                                <?php if($isOverdue): ?>
                                    <br><small style="color: red;">(Overdue)</small>
                                <?php endif; ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $loan['returned_at'] ? date('M d, Y', strtotime($loan['returned_at'])) : '-'; ?>
                        </td>
                        <td>
                            <?php if($loan['returned_at']): ?>
                                <span class="badge badge-success">Returned</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Active</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!$loan['returned_at']): ?>
                                <form action="<?= BASE_URL ?>/loan/return/<?= $loan['id'] ?>" method="POST" style="display:inline;">
                                    <?php csrf_field(); ?>
                                    <button type="submit" class="btn-secondary" style="cursor: pointer;">Return</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
