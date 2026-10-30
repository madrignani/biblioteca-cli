<?php


namespace App\Dto;


class AuthorDto {

    public function __construct(
        private int $id,
        private string $name
    ) {}

    public function arrayData() : array {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }

}


?>