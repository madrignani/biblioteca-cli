<?php


namespace App\Control;


use App\Repository\AuthorRepositoryBdr;
use App\Model\Author;
use App\Exception\DomainException;


class CreateAuthorController {

    public function __construct(
        private AuthorRepositoryBdr $authorRepository
    ) {}
    
    public function create(string $name) : void {
        $problems = (new Author(0, $name))->validate();
        if(!empty($problems)) {
            throw DomainException::withProblems($problems);
        }
        $this->authorRepository->create($name);
    }
    
}


?>