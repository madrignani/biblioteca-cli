<?php


namespace App\Repository;


use App\Enum\Era;


interface BookRepository {

    public function create(string $isbn, string $title, int $year, Era $era, string $location, int $authorId) : void;

}


?>