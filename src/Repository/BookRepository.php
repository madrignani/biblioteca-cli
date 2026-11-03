<?php


namespace App\Repository;


use App\Enum\Era;


interface BookRepository {

    public function create(string $isbn, string $title, int $year, Era $era, string $location, int $authorId) : void;
    public function delete(string $isbn) : bool;
    public function getByAuthor(string $authorName) : ?array;
    public function getByIsbn(string $isbn) : ?array;
    public function getByTitle(string $title) : ?array;
    public function update(string $isbn, string $title, string $location) : void;

}


?>