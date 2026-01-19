<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/view/assets/css/style.css">
</head>
<body>
<nav>
    <a href="<?= BASE_URL ?>/" class="logo">
        <span style="font-size: 1.5rem;">LibraryApp</span>
    </a>
    <ul>
        <li><a href="<?= BASE_URL ?>/">Home</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <li><a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a></li>
                <li><a href="<?= BASE_URL ?>/book">Books</a></li>
                <li><a href="<?= BASE_URL ?>/admin/users">Users</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>/book">Browse</a></li>
                <li><a href="<?= BASE_URL ?>/loan/history">My Loans</a></li>
                <li><a href="<?= BASE_URL ?>/wishlist">Wishlist</a></li>
                <li><a href="<?= BASE_URL ?>/profile">Profile</a></li>
            <?php endif; ?>
            <li><a href="<?= BASE_URL ?>/auth/logout" class="btn-nav">Logout</a></li>
        <?php else: ?>
            <li><a href="<?= BASE_URL ?>/auth/login">Login</a></li>
            <li><a href="<?= BASE_URL ?>/auth/register" class="btn-nav">Get Started</a></li>
        <?php endif; ?>
    </ul>
</nav>
<div class="container" style="padding-top: 2rem;">
    <!-- Flash Messages -->
    <?php if ($msg = get_flash('success')): ?>
        <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: 8px; border: 1px solid #c3e6cb;">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>
    <?php if ($msg = get_flash('error')): ?>
        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border-radius: 8px; border: 1px solid #f5c6cb;">
            <?= htmlspecialchars($msg) ?>
        </div>
    <?php endif; ?>
