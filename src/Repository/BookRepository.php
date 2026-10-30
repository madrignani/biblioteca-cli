<?php


namespace App\Repository;


use App\Enum\Era;


interface BookRepository {

    public function create(string $isbn, string $title, int $year, Era $era, string $location, int $authorId) : void;
    public function listByAuthor(string $authorName) : ?array;
    public function listByTitle(string $title) : ?array;

}


?>