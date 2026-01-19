<?php

function book_index() {
    require_login();
    
    // Pagination Setup
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    // Search & Filter Params
    $search   = isset($_GET['search']) ? trim($_GET['search']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';

    // Build Query
    $where  = ["1=1"];
    $params = [];
    $types  = "";

    if (!empty($search)) {
        $where[] = "(title LIKE ? OR author LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types   .= "ss";
    }

    if (!empty($category)) {
        $where[] = "category = ?";
        $params[] = $category;
        $types   .= "s";
    }

    $whereClause = implode(" AND ", $where);

    // Count Total
    $countSql  = "SELECT COUNT(*) AS total FROM books WHERE $whereClause";
    $totalRow  = db_fetch_one($countSql, $params, $types);
    $totalBooks = $totalRow['total'];
    $totalPages = ceil($totalBooks / $limit);

    
    $sql = "SELECT * FROM books 
            WHERE $whereClause 
            ORDER BY id DESC 
            LIMIT ? OFFSET ?";

    $params[] = $limit;
    $params[] = $offset;
    $types   .= "ii";

    $books = db_query($sql, $params, $types);

    // Categories for filter
    $catRows = db_query(
        "SELECT DISTINCT category 
         FROM books 
         WHERE category IS NOT NULL AND category != '' 
         ORDER BY category ASC"
    );
    $categories = array_column($catRows, 'category');

    view('book/index', [
        'books' => $books,
        'categories' => $categories,
        'search' => $search,
        'selected_category' => $category,
        'current_page' => $page,
        'total_pages' => $totalPages
    ]);
}

function book_view($id) {
    require_login();
    $id = (int)$id;

    // Fetch Book
    $book = db_fetch_one("SELECT * FROM books WHERE id = ?", [$id]);

    if (!$book) {
        set_flash('error', 'Book not found.');
        redirect('book');
    }

    // Fetch Reviews
    $reviews = db_query(
        "SELECT reviews.*, users.username
         FROM reviews
         JOIN users ON reviews.user_id = users.id
         WHERE reviews.book_id = ?
         ORDER BY reviews.created_at DESC",
        [$id]
    );

    // Average Rating
    $avgRating = 0;
    if (!empty($reviews)) {
        $sum = array_sum(array_column($reviews, 'rating'));
        $avgRating = round($sum / count($reviews), 1);
    }

    // Review Submission
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
        validate_csrf();

        $rating  = (int)$_POST['rating'];
        $comment = trim($_POST['comment']);
        $userId  = $_SESSION['user_id'];

        if ($rating < 1 || $rating > 5) {
            $error = "Rating must be between 1 and 5";
        } else {
            $check = db_fetch_one(
                "SELECT id FROM reviews WHERE user_id = ? AND book_id = ?",
                [$userId, $id]
            );

            if ($check) {
                $error = "You have already reviewed this book.";
            } else {
                $result = db_query(
                    "INSERT INTO reviews (user_id, book_id, rating, comment)
                     VALUES (?, ?, ?, ?)",
                    [$userId, $id, $rating, $comment]
                );

                if ($result) {
                    set_flash('success', 'Review submitted successfully!');
                    redirect("book/view/$id");
                } else {
                    $error = "Failed to submit review.";
                }
            }
        }
    }

    view('book/view', [
        'book' => $book,
        'reviews' => $reviews,
        'avg_rating' => $avgRating,
        'error' => $error
    ]);
}

function book_add() {
    require_admin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validate_csrf();

        $title    = trim($_POST['title']);
        $author   = trim($_POST['author']);
        $isbn     = trim($_POST['isbn']);
        $category = trim($_POST['category']);
        $quantity = (int)$_POST['quantity'];

        if (empty($title) || empty($author) || empty($isbn)) {
            view('book/add', ['error' => 'Title, Author and ISBN are required']);
            return;
        }

        $result = db_query(
            "INSERT INTO books (title, author, isbn, category, quantity, available_quantity)
             VALUES (?, ?, ?, ?, ?, ?)",
            [$title, $author, $isbn, $category, $quantity, $quantity]
        );

        if ($result) {
            set_flash('success', 'Book added successfully!');
            redirect('book');
        } else {
            view('book/add', ['error' => 'Failed to add book.']);
        }
    } else {
        view('book/add');
    }
}

function book_edit($id) {
    require_admin();
    $id = (int)$id;

    $book = db_fetch_one("SELECT * FROM books WHERE id = ?", [$id]);
    if (!$book) redirect('book');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validate_csrf();

        $title    = trim($_POST['title']);
        $author   = trim($_POST['author']);
        $isbn     = trim($_POST['isbn']);
        $category = trim($_POST['category']);
        $quantity = (int)$_POST['quantity'];

        if (empty($title) || empty($author) || empty($isbn)) {
            view('book/edit', ['book' => $book, 'error' => 'Title, Author and ISBN are required']);
            return;
        }

        $diff = $quantity - $book['quantity'];
        $new_available = max(0, $book['available_quantity'] + $diff);

        $result = db_query(
            "UPDATE books 
             SET title=?, author=?, isbn=?, category=?, quantity=?, available_quantity=?
             WHERE id=?",
            [$title, $author, $isbn, $category, $quantity, $new_available, $id]
        );

        if ($result !== false) {
            set_flash('success', 'Book updated successfully!');
            redirect('book');
        } else {
            view('book/edit', ['book' => $book, 'error' => 'Update failed']);
        }
    } else {
        view('book/edit', ['book' => $book]);
    }
}

function book_delete($id) {
    require_admin();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validate_csrf();
        $id = (int)$id;
        db_query("DELETE FROM books WHERE id = ?", [$id]);
        set_flash('success', 'Book deleted successfully.');
    } else {
        set_flash('error', 'Invalid request method.');
    }

    redirect('book');
}
