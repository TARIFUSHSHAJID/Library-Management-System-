<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <h2>Book Catalog</h2>
    
    <div class="search-filter">
        <form action="<?= BASE_URL ?>/book" method="GET">
            <input type="text" name="search" placeholder="Search by title or author" value="<?php echo htmlspecialchars($data['search']); ?>">
            <select name="category">
                <option value="">All Categories</option>
                <?php foreach($data['categories'] as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $data['selected_category'] === $cat ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Filter</button>
            <?php if(!empty($data['search']) || !empty($data['selected_category'])): ?>
                <a href="<?= BASE_URL ?>/book" class="btn btn-secondary">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="actions" style="margin: 20px 0;">
            <a href="<?= BASE_URL ?>/book/add" class="btn">Add New Book</a>
        </div>
    <?php endif; ?>

    <div class="book-list">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($data['books'])): ?>
                    <tr><td colspan="5">No books found.</td></tr>
                <?php else: ?>
                    <?php foreach($data['books'] as $book): ?>
                    <tr>
                        <td>
                            <a href="<?= BASE_URL ?>/book/view/<?= $book['id'] ?>" style="color: var(--primary-color); font-weight: bold; text-decoration: none;">
                                <?php echo htmlspecialchars($book['title']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['category'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($book['available_quantity'] ?? 0); ?> / <?php echo htmlspecialchars($book['quantity'] ?? 0); ?></td>
                        <td>
                            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="<?= BASE_URL ?>/book/edit/<?php echo $book['id']; ?>" class="btn-secondary">Edit</a>
                                <form action="<?= BASE_URL ?>/book/delete/<?php echo $book['id']; ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                    <?php csrf_field(); ?>
                                    <button type="submit" class="btn-danger" style="cursor: pointer;">Delete</button>
                                </form>
                            <?php else: ?>
                                <a href="<?= BASE_URL ?>/book/view/<?= $book['id'] ?>" class="btn-secondary">View</a>
                                <?php if(($book['available_quantity'] ?? 0) > 0): ?>
                                    <form action="<?= BASE_URL ?>/loan/borrow/<?php echo $book['id']; ?>" method="POST" style="display:inline;">
                                        <?php csrf_field(); ?>
                                        <button type="submit" class="btn" style="cursor: pointer;">Borrow</button>
                                    </form>
                                <?php else: ?>
                                    <span class="btn-disabled">Out of Stock</span>
                                <?php endif; ?>
                                <a href="<?= BASE_URL ?>/wishlist/add/<?php echo $book['id']; ?>" class="btn-secondary">Wishlist</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($data['total_pages'] > 1): ?>
    <div class="pagination" style="margin-top: 20px; display: flex; gap: 5px; justify-content: center;">
        <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
            <a href="<?= BASE_URL ?>/book?page=<?= $i ?>&search=<?= urlencode($data['search']) ?>&category=<?= urlencode($data['selected_category']) ?>" 
               class="btn <?= $i === $data['current_page'] ? 'btn-primary' : 'btn-secondary' ?>"
               style="<?= $i === $data['current_page'] ? 'background-color: var(--primary-dark);' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
