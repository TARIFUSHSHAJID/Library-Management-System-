<?php

function wishlist_index() {
    require_login();
    global $conn;
    
    // JSON Storage for Wishlist
    $wishlistData = json_read_file('wishlist');
    $userId = $_SESSION['user_id'];
    
    $userWishlist = array_filter($wishlistData, function($item) use ($userId) {
        return $item['user_id'] == $userId;
    });
    
    // Enhance with Book Data (from MySQL)
    foreach ($userWishlist as &$item) {
        $bookId = (int)$item['book_id'];
        $book = db_fetch_one("SELECT * FROM books WHERE id = ?", [$bookId]);
        
        if ($book) {
            $item['book'] = $book;
        } else {
            // Handle case where book was deleted
            $item['book'] = [
                'title' => 'Unknown Book',
                'author' => 'Unknown',
                'id' => $bookId
            ];
        }
    }
    
    view('wishlist/index', ['wishlist' => $userWishlist]);
}

function wishlist_add($bookId) {
    require_login();
    
    $wishlistData = json_read_file('wishlist');
    $newItem = [
        'id' => uniqid(),
        'user_id' => $_SESSION['user_id'],
        'book_id' => $bookId,
        'added_at' => date('Y-m-d H:i:s')
    ];
    
    // Check duplicate
    foreach ($wishlistData as $item) {
        if ($item['user_id'] == $_SESSION['user_id'] && $item['book_id'] == $bookId) {
            redirect('wishlist');
            return;
        }
    }
    
    $wishlistData[] = $newItem;
    json_write_file('wishlist', $wishlistData);
    
    redirect('wishlist');
}

function wishlist_remove($bookId) {
    require_login();
    
    $wishlistData = json_read_file('wishlist');
    $userId = $_SESSION['user_id'];
    
    $newWishlist = array_filter($wishlistData, function($item) use ($userId, $bookId) {
        return !($item['user_id'] == $userId && $item['book_id'] == $bookId);
    });
    
    // Re-index array
    $newWishlist = array_values($newWishlist);
    
    json_write_file('wishlist', $newWishlist);
    redirect('wishlist');
}
