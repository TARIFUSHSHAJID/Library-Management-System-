<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<div class="container">
    <div style="margin-bottom: 20px;">
        <a href="<?= BASE_URL ?>/book" class="btn btn-secondary">&larr; Back to Books</a>
    </div>

    <div class="card" style="display: flex; gap: 40px; margin-bottom: 40px;">
        <div style="flex: 0 0 300px;">
            <img src="https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&w=500&q=80" alt="Book Cover" style="width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>
        <div style="flex: 1;">
            <h1 style="margin-bottom: 10px;"><?= htmlspecialchars($data['book']['title']) ?></h1>
            <h3 style="color: #666; margin-bottom: 20px;"><?= htmlspecialchars($data['book']['author']) ?></h3>
            
            <div style="margin-bottom: 20px;">
                <span style="background: #e2e8f0; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem;">
                    <?= htmlspecialchars($data['book']['category']) ?>
                </span>
                <span style="margin-left: 10px; color: #f1c40f; font-weight: bold; font-size: 1.1rem;">
                    ★ <?= $data['avg_rating'] > 0 ? $data['avg_rating'] : 'No ratings' ?>
                </span>
            </div>
            
            <p style="margin-bottom: 20px; color: #555;">
                ISBN: <?= htmlspecialchars($data['book']['isbn']) ?><br>
                Added on: <?= date('M d, Y', strtotime($data['book']['added_at'])) ?>
            </p>

            <div style="margin-bottom: 30px;">
                <strong>Availability:</strong>
                <?php if($data['book']['available_quantity'] > 0): ?>
                    <span style="color: green; font-weight: bold;">In Stock (<?= $data['book']['available_quantity'] ?>)</span>
                <?php else: ?>
                    <span style="color: red; font-weight: bold;">Out of Stock</span>
                <?php endif; ?>
            </div>

            <div class="actions" style="display: flex; gap: 10px;">
                <?php if($data['book']['available_quantity'] > 0): ?>
                    <form action="<?= BASE_URL ?>/loan/borrow/<?= $data['book']['id'] ?>" method="POST" style="display:inline;">
                        <?php csrf_field(); ?>
                        <button type="submit" class="btn" style="cursor: pointer;">Borrow Now</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-disabled">Unavailable</button>
                <?php endif; ?>
                
                <a href="<?= BASE_URL ?>/wishlist/add/<?= $data['book']['id'] ?>" class="btn btn-secondary">Add to Wishlist</a>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section">
        <h2 style="border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">Reviews & Ratings</h2>
        
        <!-- Add Review Form -->
        <div class="card" style="margin-bottom: 30px; background: #f8fafc;">
            <h4>Write a Review</h4>
            <?php if(isset($data['error']) && !empty($data['error'])): ?>
                <p class="error"><?= $data['error'] ?></p>
            <?php endif; ?>
            
            <form action="<?= BASE_URL ?>/book/view/<?= $data['book']['id'] ?>" method="POST">
                <?php csrf_field(); ?>
                <div class="form-group">
                    <label>Rating</label>
                    <div style="font-size: 1.5rem; color: #f1c40f;">
                        <!-- Simple Radio Rating -->
                        <label><input type="radio" name="rating" value="5" required> 5</label>
                        <label><input type="radio" name="rating" value="4"> 4</label>
                        <label><input type="radio" name="rating" value="3"> 3</label>
                        <label><input type="radio" name="rating" value="2"> 2</label>
                        <label><input type="radio" name="rating" value="1"> 1</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="comment">Your Review</label>
                    <textarea name="comment" id="comment" rows="3" placeholder="Share your thoughts..." required></textarea>
                </div>
                <button type="submit" name="submit_review" class="btn">Submit Review</button>
            </form>
        </div>

        <!-- Reviews List -->
        <div class="reviews-list">
            <?php if(empty($data['reviews'])): ?>
                <p style="color: #888; font-style: italic;">No reviews yet. Be the first to review!</p>
            <?php else: ?>
                <?php foreach($data['reviews'] as $review): ?>
                    <div class="card" style="margin-bottom: 15px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <strong><?= htmlspecialchars($review['username']) ?></strong>
                            <span style="color: #888; font-size: 0.9rem;"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                        </div>
                        <div style="color: #f1c40f; margin-bottom: 10px;">
                            <?= str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
