<?php


namespace App\Control;


use App\Repository\BookRepository;


class UpdateBookController {

    public function __construct(
        private BookRepository $bookRepository
    ) {}
    
    public function update(string $isbn) : void {
        
    }
    
}


?>