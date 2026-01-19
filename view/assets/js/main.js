document.addEventListener('DOMContentLoaded', function() {
    
    // Helper function to show error
    function showError(input, message) {
        const errorSpan = document.getElementById(input.id + 'Error');
        if (errorSpan) {
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
            input.style.borderColor = 'red';
        }
    }

    // Helper function to clear error
    function clearError(input) {
        const errorSpan = document.getElementById(input.id + 'Error');
        if (errorSpan) {
            errorSpan.style.display = 'none';
            input.style.borderColor = '#ddd';
        }
    }

    // Helper function to validate email
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Login Form Validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            let isValid = true;
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            clearError(email);
            clearError(password);

            if (email.value.trim() === '') {
                showError(email, 'Email is required');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError(email, 'Invalid email format');
                isValid = false;
            }

            if (password.value.trim() === '') {
                showError(password, 'Password is required');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Register Form Validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let isValid = true;
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            clearError(username);
            clearError(email);
            clearError(password);

            if (username.value.trim() === '') {
                showError(username, 'Username is required');
                isValid = false;
            }

            if (email.value.trim() === '') {
                showError(email, 'Email is required');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                showError(email, 'Invalid email format');
                isValid = false;
            }

            if (password.value.trim() === '') {
                showError(password, 'Password is required');
                isValid = false;
            } else if (password.value.length < 6) {
                showError(password, 'Password must be at least 6 characters');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Add Book Form Validation
    const addBookForm = document.getElementById('addBookForm');
    if (addBookForm) {
        addBookForm.addEventListener('submit', function(e) {
            validateBookForm(e, addBookForm);
        });
    }

    // Edit Book Form Validation
    const editBookForm = document.getElementById('editBookForm');
    if (editBookForm) {
        editBookForm.addEventListener('submit', function(e) {
            validateBookForm(e, editBookForm);
        });
    }

    function validateBookForm(e, form) {
        let isValid = true;
        const title = form.querySelector('#title');
        const author = form.querySelector('#author');
        const isbn = form.querySelector('#isbn');

        clearError(title);
        clearError(author);
        clearError(isbn);

        if (title.value.trim() === '') {
            showError(title, 'Title is required');
            isValid = false;
        }

        if (author.value.trim() === '') {
            showError(author, 'Author is required');
            isValid = false;
        }

        if (isbn.value.trim() === '') {
            showError(isbn, 'ISBN is required');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    }
});
