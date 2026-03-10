<?php
namespace Cesi\Bookshop\Tests;

use Cesi\Bookshop\Book;
use Cesi\Bookshop\Library;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase {
    
    
    private $library;
    private $book1;
    private $book2;

    protected function setUp(): void {
        $this->library = new Library();
        $this->book1 = new Book('The Hobbit', 'J.R.R. Tolkien', '9780261102217');
        $this->book2 = new Book('1984', 'George Orwell', '9780451524935');
    }
    
    public function testAddBook() {
       $this->library->addBook($this->book1);
       $this->assertCount(1, $this->library->getBooks());
       $this->assertSame($this->book1, $this->library->getBooks()[0]);
    }
    
    public function testFindBookByIsbn() {
        $this->library->addBook($this->book1);
        $this->library->addBook($this->book2);
        
        $foundBook = $this->library->findBookByIsbn('9780261102217');
        $this->assertSame($this->book1, $foundBook);
        
        $notFoundBook = $this->library->findBookByIsbn('0000000000');
        $this->assertNull($notFoundBook);
    }
    
    public function testRemoveBookByIsbn() {
        $this->library->addBook($this->book1);
        $this->library->addBook($this->book2);
        
        $result = $this->library->removeBookByIsbn('9780261102217');
        $this->assertTrue($result);
        $this->assertCount(1, $this->library->getBooks());
        $this->assertNull($this->library->findBookByIsbn('9780261102217'));
        
        $resultFail = $this->library->removeBookByIsbn('0000000000');
        $this->assertFalse($resultFail);
    }
}