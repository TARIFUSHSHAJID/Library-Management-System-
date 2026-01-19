<?php

function auth_index() {
    auth_login();
}

function auth_login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validate_csrf();
        
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = db_fetch_one("SELECT * FROM users WHERE email = ?", [$email]);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'] ?? 'user';
            
            set_flash('success', 'Welcome back, ' . $user['username'] . '!');

            if ($_SESSION['role'] === 'admin') {
                redirect('admin/dashboard'); // We need to create this if not exists, or redirect to book
            } else {
                redirect('book');
            }
        } else {
            view('auth/login', ['error' => 'Invalid email or password']);
        }
    } else {
        view('auth/login');
    }
}

function auth_register() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        validate_csrf();

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($username) || empty($email) || empty($password)) {
             view('auth/register', ['error' => 'All fields are required']);
             return;
        }

        // Check if email exists
        $existing = db_fetch_one("SELECT id FROM users WHERE email = ?", [$email]);
        if ($existing) {
            view('auth/register', ['error' => 'Email already registered']);
            return;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Use db_query for insert (returns ID)
        $result = db_query(
            "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')", 
            [$username, $email, $hashed_password]
        );
        
        if ($result) {
            set_flash('success', 'Registration successful! Please login.');
            redirect('auth/login');
        } else {
            view('auth/register', ['error' => 'Registration failed.']);
        }
    } else {
        view('auth/register');
    }
}

function auth_logout() {
    session_destroy();
    // Restart session for flash message to work on next page load? 
    // Actually session_destroy kills it. 
    // Usually we start a new session or just redirect.
    session_start();
    set_flash('success', 'You have been logged out.');
    redirect('home');
}

function auth_forgotPassword() {
    view('auth/forgot');
}
