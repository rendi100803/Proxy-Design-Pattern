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

// Bad Proxy
class BadLibraryProxy implements Library {
    private $realLibrary;

    public function __construct() {
        $this->realLibrary = new RealLibrary();
    }

    public function borrowBook($bookTitle) {
        echo "Bad proxy: I am doing something, but not useful\n";
        // Bad implementation: No actual access control or logging
        $this->realLibrary->borrowBook($bookTitle);
        // Missing access checks and proper logging
    }
}

// Client Code
function clientCode(Library $library, $bookTitle) {
    $library->borrowBook($bookTitle);
}

// Example Usage
$badProxy = new BadLibraryProxy();
clientCode($badProxy, "1984");
clientCode($badProxy, "Brave New World");

?>
