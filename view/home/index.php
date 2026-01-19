<?php require_once BASE_PATH . '/view/layouts/header.php'; ?>

<!-- Hero Section with Background Image -->
<div class="hero" style="background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.7)), url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
    <div class="hero-content">
        <h1>Welcome to LibraryApp</h1>
        <p>Discover a universe of stories, knowledge and inspiration. Your next great adventure is just a click away.</p>
        
        <?php if(!isset($_SESSION['user_id'])): ?>
            <div class="hero-actions">
                <a href="<?= BASE_URL ?>/auth/register" class="btn btn-large">Get Started Free</a>
                <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline btn-large">Member Login</a>
            </div>
        <?php else: ?>
            <div class="hero-actions">
                <a href="<?= BASE_URL ?>/book" class="btn btn-large">Browse Collection</a>
                <a href="<?= BASE_URL ?>/profile" class="btn btn-outline btn-large">My Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Features Section -->
<div class="container">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h2>Experience Modern Reading</h2>
        <p>We've digitized the library experience for your convenience.</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <h3>Vast Collection</h3>
            <p>Explore thousands of titles ranging from classic literature to modern technology and science.</p>
        </div>
        <div class="feature-card">
            <h3>Instant Access</h3>
            <p>Check real-time availability and borrow books instantly with our seamless digital system.</p>
        </div>
        <div class="feature-card">
            <h3>Premium Experience</h3>
            <p>Manage your reading list, track due dates, and build your personal wishlist effortlessly.</p>
        </div>
        <div class="feature-card">
            <h3>Secure & Private</h3>
            <p>Your reading history and personal data are protected with industry-standard security.</p>
        </div>
    </div>
</div>

<!-- Featured Books Preview (Static for now, could be dynamic) -->
<div class="container" style="margin-top: 4rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Trending Now</h2>
        <a href="<?= BASE_URL ?>/book" class="btn btn-secondary">View All Books</a>
    </div>
    
    <div class="features-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
        <!-- Dummy Book Cards for Visuals -->
        <div class="card" style="padding: 0; overflow: hidden;">
            <img src="view\assets\images\TheArtofCode.jpg" alt="Book" style="width: 100%; height: 250px; object-fit: cover;">
            <div style="padding: 1rem;">
                <h4 style="margin-bottom: 0.5rem;">The Art of Code</h4>
                <p style="font-size: 0.9rem; margin-bottom: 0;">By Alan Turing</p>
            </div>
        </div>
        <div class="card" style="padding: 0; overflow: hidden;">
            <img src="view\assets\images\DesignSystems.jpg" alt="Book" style="width: 100%; height: 250px; object-fit: cover;">
            <div style="padding: 1rem;">
                <h4 style="margin-bottom: 0.5rem;">Design Systems</h4>
                <p style="font-size: 0.9rem; margin-bottom: 0;">By Alla Kholmatova</p>
            </div>
        </div>
        <div class="card" style="padding: 0; overflow: hidden;">
            <img src="view\assets\images\FutureTech.jpg" alt="Book" style="width: 100%; height: 250px; object-fit: cover;">
            <div style="padding: 1rem;">
                <h4 style="margin-bottom: 0.5rem;">Future Tech</h4>
                <p style="font-size: 0.9rem; margin-bottom: 0;">By Elon Musk</p>
            </div>
        </div>
        <div class="card" style="padding: 0; overflow: hidden;">
            <img src="view\assets\images\DeepLearniing.jpg" alt="Book" style="width: 100%; height: 250px; object-fit: cover;">
            <div style="padding: 1rem;">
                <h4 style="margin-bottom: 0.5rem;">Deep Learning</h4>
                <p style="font-size: 0.9rem; margin-bottom: 0;">By Ian Goodfellow</p>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . '/view/layouts/footer.php'; ?>
