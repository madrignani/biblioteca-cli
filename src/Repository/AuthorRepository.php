<?php


namespace App\Repository;


interface AuthorRepository {

    public function create(string $name) : void;
    public function getByName(string $name) : ?array;

}


?>