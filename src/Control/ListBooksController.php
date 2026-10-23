<?php


namespace App\Control;


use App\Repository\AuthorRepository;
use App\Repository\BookRepository;


class ListBooksController {

    public function __construct(
        private AuthorRepository $authorRepository,
        private BookRepository $bookRepository
    ) {}

    public function listByAuthor(string $name) : ?array {
        $books = [];
        return $books;
    }

    public function listByTitle(string $title) : ?array {
        $books = [];
        return $books;
    }
    
}


?>