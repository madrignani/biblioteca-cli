<?php


namespace App\Control;


use App\Dto\AuthorDto;
use App\Dto\BookDto;
use App\Repository\BookRepository;


class ListBooksController {

    public function __construct(
        private BookRepository $repository
    ) {}

    public function listByAuthor(string $authorName) : ?array {
        $books = $this->repository->getByAuthor($authorName);
        $booksDto = [];
        foreach ($books as $book) {
            $authorDto = ( 
                new AuthorDto($book['author_id'], $book['author_name'])
            )->arrayData();
            $dto = (
                new BookDto($book['id'], $book['isbn'], $book['title'], $book['year'], $book['era'], $book['location'], $authorDto)
            )->arrayData();
            $booksDto[] = $dto;
        }
        return $booksDto;
    }

    public function listByTitle(string $title) : ?array {
        $books = $this->repository->getByTitle($title);
        $booksDto = [];
        foreach ($books as $book) {
            $authorDto = ( 
                new AuthorDto($book['author_id'], $book['author_name'])
            )->arrayData();
            $dto = (
                new BookDto($book['id'], $book['isbn'], $book['title'], $book['year'], $book['era'], $book['location'], $authorDto)
            )->arrayData();
            $booksDto[] = $dto;
        }
        return $booksDto;
    }

    public function listByIsbn(string $isbn) : ?array {
        $book = $this->repository->getByIsbn($isbn);
        if(!($book)) {
            return null;
        }
        $authorDto = ( 
            new AuthorDto($book['author_id'], $book['author_name'])
        )->arrayData();
        $dto = (
            new BookDto($book['id'], $book['isbn'], $book['title'], $book['year'], $book['era'], $book['location'], $authorDto)
        )->arrayData();
        return $dto;
    }
    
}


?>