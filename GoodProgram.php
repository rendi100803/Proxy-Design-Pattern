<?php

// Subject Interface
interface Library {
    public function borrowBook($bookTitle);
}

// Real Subject
class RealLibrary implements Library {
    private $availableBooks;

    public function __construct() {
        $this->availableBooks = [
            "1984" => true,
            "Brave New World" => true,
            "Fahrenheit 451" => true,
        ];
    }

    public function borrowBook($bookTitle) {
        if (isset($this->availableBooks[$bookTitle]) && $this->availableBooks[$bookTitle]) {
            $this->availableBooks[$bookTitle] = false;
            echo "Borrowing book: $bookTitle\n";
        } else {
            echo "Sorry, the book $bookTitle is not available.\n";
        }
    }
}

// Good Proxy
class GoodLibraryProxy implements Library {
    private $realLibrary;
    private $permissions;

    public function __construct($permissions) {
        $this->realLibrary = new RealLibrary();
        $this->permissions = $permissions;
    }

    public function borrowBook($bookTitle) {
        if ($this->checkAccess()) {
            $this->realLibrary->borrowBook($bookTitle);
            $this->logAccess($bookTitle);
        } else {
            echo "Access denied. You do not have permission to borrow books.\n";
        }
    }

    private function checkAccess() {
        // Check if user has permission to borrow books
        return $this->permissions['canBorrow'];
    }

    private function logAccess($bookTitle) {
        // Log the borrowing action
        echo "Logging: Book '$bookTitle' was borrowed.\n";
    }
}

// Client Code
function clientCode(Library $library, $bookTitle) {
    $library->borrowBook($bookTitle);
}

// Example Usage
$permissions = ['canBorrow' => true]; // or false
$goodProxy = new GoodLibraryProxy($permissions);

clientCode($goodProxy, "1984");
clientCode($goodProxy, "Brave New World");
clientCode($goodProxy, "The Great Gatsby"); // not available in the library

?>
