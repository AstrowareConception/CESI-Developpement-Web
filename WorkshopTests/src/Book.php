<?php
namespace Cesi\Bookshop;


class Book {
    
    public function __construct(private $title, private $author, private $isbn) {}

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getIsbn() {
        return $this->isbn;
    }
}