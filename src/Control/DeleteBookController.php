<?php


namespace App\Control;


use App\Repository\BookRepository;
use App\Exception\DomainException;


class DeleteBookController {

    public function __construct(
        private BookRepository $repository
    ) {}
    
    public function delete(string $isbn) : void {
        $deleted = $this->repository->delete($isbn);
        if(!($deleted)) {
            throw DomainException::withProblems( ['Livro não encontrado para exclusão.'] );        
        }
    }

}


?>