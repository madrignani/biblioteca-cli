<?php


namespace App\Model;


use DateTime;
use App\Enum\Era;


class Book {

    public function __construct(
        private int $id,
        private string $isbn,
        private string $title,
        private int $year,
        private Era $era,
        private string $location,
        private Author $author
    ) {}

    public function getId() : int {
        return $this->id;
    }

    public function getIsbn() : string {
        return $this->isbn;
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function getYear() : int {
        return $this->year;
    }

    public function getEra() : Era {
        return $this->era;
    }

    public function getLocation() : string {
        return $this->location;
    }

    public function getAuthor() : Author {
        return $this->author;
    }

    public function validate() : array {
        $problems = [];
        if(strlen($this->isbn)!=13) {
            $problems[] = 'Código ISBN do livro deve conter exatamente 13 caracteres';
        }
        if(mb_strlen($this->title)<2 || mb_strlen($this->title)>150) {
            $problems[] = 'Título do livro deve conter entre 2 e 150 caracteres.';
        }
        if($this->year < 1) {
            $problems[] = 'Ano de publicação do livro deve ser positivo.';
        }
        if($this->era===Era::AD && $this->year>((int)(new DateTime())->format('Y'))) {
            $problems[] = 'Ano de publicação do livro não pode ser no futuro.';
        } 
        if(strlen($this->location)!=4) {
            $problems[] = 'Localização do livro no estoque deve conter exatamente 4 caracteres.';
        }
        return $problems;
    }

}



?>