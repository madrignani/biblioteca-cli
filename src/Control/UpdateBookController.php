<?php


namespace App\Control;


use App\Model\Author;
use App\Model\Book;
use App\Enum\Era;
use App\Repository\BookRepository;
use App\Exception\DomainException;


class UpdateBookController {

    public function __construct(
        private BookRepository $repository
    ) {}
    
    public function update(string $isbn, string $title, string $location): void {
        $bookData = $this->repository->getByIsbn($isbn);
        if ($bookData === null) {
            throw DomainException::withProblems( ['Livro não encontrado.'] );
        }
        $author = new Author( (int)$bookData['author_id'], $bookData['author_name'] );
        $book = new Book(
            ( (int)$bookData['id'] ),
            $bookData['isbn'],
            $title,
            ( (int) $bookData['year'] ),
            ( Era::from($bookData['era']) ),
            $location,
            $author
        );
        $problems = $book->validate();
        if (!empty($problems)) {
            throw DomainException::withProblems($problems);
        }
        $this->repository->update($isbn, $title, $location);
    }
    
}


?>