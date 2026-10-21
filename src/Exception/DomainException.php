<?php


namespace App\Exception;


class DomainException extends \RuntimeException {

    private array $problems = [];

    public function __construct(string $message = '', array $problems = []) {
        parent::__construct($message);
        $this->problems = $problems;
    }

    public function getProblems() : array {
        return $this->problems;
    }

    public static function withProblems(array $problems) : DomainException {
        return new self( ('Problemas: ' . implode(', ', $problems)), $problems);
    }

}


?>