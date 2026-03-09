<?php
namespace Cesi\Bookshop\Tests;

use Cesi\Bookshop\Book;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase {
    
    private $book;

    protected function setUp(): void {
        $this->book = new Book('The Hobbit', 'J.R.R. Tolkien', '9780261102217');
    }

    public function testGetTitle() {
        $this->assertSame('The Hobbit', $this->book->getTitle());
    }
    public function testGetAuthor() {
        $this->assertSame('J.R.R. Tolkien', $this->book->getAuthor());
    }
    public function testGetIsbn() {
        $this->assertSame('9780261102217', $this->book->getIsbn());
    }
}