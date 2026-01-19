<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <div class="auth-form">
        <h2>Add New Book</h2>
        <?php if(isset($data['error'])): ?>
            <p class="error" style="color: red;"><?php echo $data['error']; ?></p>
        <?php endif; ?>
        <form action="<?= BASE_URL ?>/book/add" method="POST" id="addBookForm" novalidate>
            <?php csrf_field(); ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title">
                <span class="error-msg" id="titleError"></span>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author">
                <span class="error-msg" id="authorError"></span>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" name="isbn" id="isbn">
                <span class="error-msg" id="isbnError"></span>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" name="category" id="category">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1" value="1">
            </div>
            <button type="submit" class="btn">Add Book</button>
            <a href="<?= BASE_URL ?>/book" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

40→<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
