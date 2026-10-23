<?php


namespace App\Repository;


use PDO;
use PDOException;
use App\Enum\Era;
use App\Exception\RepositoryException;


class BookRepositoryBdr implements BookRepository {

    public function __construct(
        private PDO $pdo
    ) {}

    public function create(string $isbn, string $title, int $year, Era $era, string $location, int $authorId) : void {
        try {
            $sql = <<<SQL
                INSERT INTO book (author_id, isbn, title, year, era, location)
                VALUES (:author_id, :isbn, :title, :year, :era, :location)
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'author_id' => $authorId,
                'isbn' => $isbn,
                'title' => $title,
                'year' => $year,
                'era' => $era->value,
                'location' => $location
            ] );
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
    
}


?>