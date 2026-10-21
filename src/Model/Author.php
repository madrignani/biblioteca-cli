<?php


namespace App\Model;


class Author {

    private int $id;
    private string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() : string {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function validate() : array {
        $problems = [];
        if(mb_strlen($this->name)<2 || mb_strlen($this->name)>70) {
            $problems[] = 'Nome de autor deve conter entre 2 e 70 caracteres.';
        }
        return $problems;
    }

}


?>