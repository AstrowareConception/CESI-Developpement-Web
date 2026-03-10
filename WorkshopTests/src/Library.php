<?php
namespace Cesi\Bookshop;
class Library {
    private $books = [];
   
    public function addBook(Book $book) {
        $this->books[] = $book;
    }
    
    public function getBooks() {
        return $this->books;
    }

    public function findBookByIsbn($isbn) {
        foreach ($this->books as $book) {
            if ($book->getIsbn() === $isbn) {
                return $book;
            }
        }
        return null;
    }

    public function removeBookByIsbn($isbn) {
        foreach ($this->books as $key => $book) {
            if ($book->getIsbn() === $isbn) {
                unset($this->books[$key]);
                return true;
            }
        }
        return false;
    }

}