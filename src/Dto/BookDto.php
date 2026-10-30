<?php


namespace App\Dto;


class BookDto {

    public function __construct(
        private int $id,
        private string $isbn,
        private string $title,
        private int $year,
        private string $era,
        private string $location,
        private array $author
    ) {}

    public function arrayData() : array {
        return [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'title' => $this->title,
            'year' => $this->year,
            'era' => $this->era,
            'location' => $this->location,
            'author' => $this->author
        ];
    }

}


?>