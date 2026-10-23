<?php


namespace App\Repository;


interface AuthorRepository {

    public function create(string $name) : void;
    public function findByName(string $name) : ?array;

}


?>