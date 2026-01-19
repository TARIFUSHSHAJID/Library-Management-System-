<?php

function loan_borrow($book_id) {
    require_login();
    global $conn;
    $book_id = (int)$book_id;
    $user_id = $_SESSION['user_id'];

    // Check availability
    $book = db_fetch_one("SELECT available_quantity FROM books WHERE id = ?", [$book_id]);

    if (!$book || $book['available_quantity'] <= 0) {
        set_flash('error', 'Book is not available.');
        redirect('book');
    }

    // Start Transaction
    mysqli_begin_transaction($conn);

    // Decrease quantity
    db_query("UPDATE books SET available_quantity = available_quantity - 1 WHERE id = ?", [$book_id]);

    // Create Loan Record with Due Date (14 days from now)
    $due_date = date('Y-m-d H:i:s', strtotime('+14 days'));
    db_query("INSERT INTO loans (user_id, book_id, due_date) VALUES (?, ?, ?)", [$user_id, $book_id, $due_date]);

    mysqli_commit($conn);
    set_flash('success', 'Book borrowed successfully! Due date: ' . date('M d, Y', strtotime($due_date)));
    redirect('loan/history');
}

function loan_history() {
    require_login();
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT loans.*, books.title, books.author 
            FROM loans 
            JOIN books ON loans.book_id = books.id 
            WHERE loans.user_id = ? 
            ORDER BY loans.borrowed_at DESC";
    
    $loans = db_query($sql, [$user_id]);

    view('loan/history', ['loans' => $loans]);
}

function loan_return($id) {
    require_login();
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        set_flash('error', 'Invalid request.');
        redirect('loan/history');
    }
    validate_csrf();

    $id = (int)$id;
    $user_id = $_SESSION['user_id'];

    // Verify loan belongs to user and is active
    $loan = db_fetch_one("SELECT book_id FROM loans WHERE id = ? AND user_id = ? AND returned_at IS NULL", [$id, $user_id]);
    
    if (!$loan) {
        set_flash('error', 'Invalid loan record.');
        redirect('loan/history');
    }

    $book_id = $loan['book_id'];

    mysqli_begin_transaction($conn);

    // Update loan status
    db_query("UPDATE loans SET returned_at = NOW(), status = 'returned' WHERE id = ?", [$id]);

    // Increase book quantity
    db_query("UPDATE books SET available_quantity = available_quantity + 1 WHERE id = ?", [$book_id]);

    mysqli_commit($conn);
    set_flash('success', 'Book returned successfully!');
    redirect('loan/history');
}
