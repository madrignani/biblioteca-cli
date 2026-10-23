<?php


namespace App\Control;


use App\Enum\Era;
use App\Model\Author;
use App\Model\Book;
use App\Repository\AuthorRepositoryBdr;
use App\Repository\BookRepositoryBdr;
use App\Exception\DomainException;


class CreateBookController {

    public function __construct(
        private AuthorRepositoryBdr $authorRepository,
        private BookRepositoryBdr $bookRepository
    ) {}

    public function create(string $isbn, string $title, int $year, Era $era, string $location, string $authorName) : void {
        $authorData = $this->authorRepository->findByName($authorName);
        if(!($authorData)) {
            throw new DomainException('Autor não encontrado para o nome informado.');
        } 
        $author = new Author($authorData['id'], $authorData['name']);
        $problems = (new Book(0, $isbn, $title, $year, $era, $location, $author)->validate());
        if(!empty($problems)) {
            throw DomainException::withProblems($problems);
        }
        $this->bookRepository->create($isbn, $title, $year, $era, $location, (int)$authorData['id']);
    }
    
}


?>