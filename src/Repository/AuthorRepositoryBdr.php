<?php


namespace App\Repository;


use PDO;
use PDOException;
use App\Exception\RepositoryException;
use Override;

class AuthorRepositoryBdr implements AuthorRepository {

    public function __construct(
        private PDO $pdo
    ) {}
    
    public function create(string $name) : void {
        try {
            $sql = <<<SQL
                INSERT INTO author (name)
                VALUES (:name)
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'name' => $name
            ] );
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function findByName(string $name): ?array {
        try {
            $sql = <<<SQL
                SELECT id, name FROM author
                WHERE name = :name;
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'name' => $name
            ] );
            $data = $statement->fetch();
            return $data;
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
    
}


?>