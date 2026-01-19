<?php

function profile_index() {
    require_login();
    
    $userId = $_SESSION['user_id'];
    $user = db_fetch_one("SELECT * FROM users WHERE id = ?", [$userId]);
    
    // Fetch active loans
    $loans = db_query("SELECT loans.*, books.title as book_title FROM loans JOIN books ON loans.book_id = books.id WHERE loans.user_id = ? AND loans.status = 'borrowed' ORDER BY loans.borrowed_at DESC", [$userId]);
    
    view('profile/index', ['user' => $user, 'loans' => $loans]);
}

function profile_edit() {
    require_login();
    $userId = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validate_csrf();
        
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        
        // Basic validation
        if (empty($username) || empty($email)) {
            set_flash('error', 'Username and email are required.');
            redirect('profile');
        }

        $result = db_query("UPDATE users SET username=?, email=? WHERE id=?", [$username, $email, $userId]);
        
        if ($result !== false) {
            $_SESSION['username'] = $username;
            set_flash('success', 'Profile updated successfully.');
            redirect('profile');
        } else {
            set_flash('error', 'Failed to update profile.');
            redirect('profile');
        }
    } else {
        $user = db_fetch_one("SELECT * FROM users WHERE id = ?", [$userId]);
        view('profile/edit', ['user' => $user]);
    }
}

function profile_changePassword() {
    require_login();
    $userId = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validate_csrf();
        
        $current = $_POST['current_password'];
        $new = $_POST['new_password'];
        
        if (empty($current) || empty($new)) {
             set_flash('error', 'All fields are required.');
             redirect('profile');
        }
        
        $user = db_fetch_one("SELECT password FROM users WHERE id = ?", [$userId]);
        
        if ($user && password_verify($current, $user['password'])) {
            $newHash = password_hash($new, PASSWORD_DEFAULT);
            db_query("UPDATE users SET password=? WHERE id=?", [$newHash, $userId]);
            set_flash('success', 'Password changed successfully.');
            redirect('profile');
        } else {
            set_flash('error', 'Incorrect current password.');
            redirect('profile');
        }
    } else {
        view('profile/change_password');
    }
}
