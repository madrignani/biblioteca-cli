<?php


namespace App\Control;


use App\Repository\BookRepository;


class DeleteBookController {

    public function __construct(
        private BookRepository $bookRepository
    ) {}
    
    public function delete(string $isbn) : void {
       
    }

}


?>