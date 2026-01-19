<?php

function admin_dashboard() {
    require_admin();
    
    // Stats
    $usersCount = db_fetch_one("SELECT COUNT(*) as c FROM users")['c'];
    $booksCount = db_fetch_one("SELECT COUNT(*) as c FROM books")['c'];
    $activeLoansCount = db_fetch_one("SELECT COUNT(*) as c FROM loans WHERE status = 'borrowed'")['c'];
    
    // Recent Loans
    $recentLoans = db_query("SELECT loans.*, users.username, books.title as book_title 
            FROM loans 
            JOIN users ON loans.user_id = users.id 
            JOIN books ON loans.book_id = books.id 
            ORDER BY loans.borrowed_at DESC LIMIT 5");

    $data = [
        'total_users' => $usersCount,
        'total_books' => $booksCount,
        'active_loans' => $activeLoansCount,
        'recent_loans' => $recentLoans
    ];

    view('admin/dashboard', $data);
}

function admin_users() {
    require_admin();
    $users = db_query("SELECT * FROM users ORDER BY created_at DESC");
    view('admin/users', ['users' => $users]);
}

function admin_deleteUser($id) {
    require_admin();
    $id = (int)$id;
    
    if ($id == $_SESSION['user_id']) {
        set_flash('error', 'Cannot delete yourself.');
        redirect('admin/users');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validate_csrf();
        db_query("DELETE FROM users WHERE id = ?", [$id]);
        set_flash('success', 'User deleted successfully.');
    } else {
        set_flash('error', 'Invalid request method.');
    }
    redirect('admin/users');
}
