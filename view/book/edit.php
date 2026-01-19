<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <div class="auth-form">
        <h2>Edit Book</h2>
        <form action="<?= BASE_URL ?>/book/edit/<?php echo $data['book']['id']; ?>" method="POST" id="editBookForm" novalidate>
            <?php csrf_field(); ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($data['book']['title']); ?>">
                <span class="error-msg" id="titleError"></span>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" value="<?php echo htmlspecialchars($data['book']['author']); ?>">
                <span class="error-msg" id="authorError"></span>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($data['book']['isbn']); ?>">
                <span class="error-msg" id="isbnError"></span>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($data['book']['category'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1" value="<?php echo htmlspecialchars($data['book']['quantity'] ?? 1); ?>">
            </div>
            <button type="submit" class="btn">Update Book</button>
            <a href="<?= BASE_URL ?>/book" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

37→<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
