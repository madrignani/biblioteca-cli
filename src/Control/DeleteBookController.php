<?php


namespace App\Control;


use App\Repository\BookRepository;
use DomainException;

class DeleteBookController {

    public function __construct(
        private BookRepository $repository
    ) {}
    
    public function delete(string $isbn) : void {
        $deleted = $this->repository->delete($isbn);
        if(!($deleted)) {
            throw new DomainException('Livro não encontrado para exclusão.');        
        }
    }

}


?>