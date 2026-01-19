<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <h2>Admin Dashboard</h2>
    
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3>Total Users</h3>
            <p style="font-size: 2em; font-weight: bold;"><?php echo $data['total_users']; ?></p>
        </div>
        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3>Total Books</h3>
            <p style="font-size: 2em; font-weight: bold;"><?php echo $data['total_books']; ?></p>
        </div>
        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3>Active Loans</h3>
            <p style="font-size: 2em; font-weight: bold;"><?php echo $data['active_loans']; ?></p>
        </div>
    </div>

    <h3>Recent Loans</h3>
    <table>
        <thead>
            <tr>
                <th>Loan ID</th>
                <th>User</th>
                <th>Book</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['recent_loans'] as $loan): ?>
            <tr>
                <td><?php echo htmlspecialchars($loan['id']); ?></td>
                <td><?php echo htmlspecialchars($loan['username']); ?></td>
                <td><?php echo htmlspecialchars($loan['book_title']); ?></td>
                <td><?php echo htmlspecialchars($loan['borrowed_at']); ?></td>
                <td><?php echo htmlspecialchars($loan['status']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
