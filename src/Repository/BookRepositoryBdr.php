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

    public function delete(string $isbn) : bool {
        try {
            $sql = <<<SQL
                DELETE FROM book 
                WHERE isbn = :isbn
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [ 
                'isbn' => $isbn
            ] );
            return $statement->rowCount() > 0;
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function getByAuthor(string $authorName) : ?array {
        try {
            $sql = <<<SQL
                SELECT 
                    book.id, 
                    book.isbn,
                    book.title,
                    book.year,
                    book.era,
                    book.location, 
                    author.id as author_id, 
                    author.name as author_name
                FROM book
                JOIN author ON book.author_id = author.id
                WHERE author.name = :authorName
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'authorName' => $authorName
            ] );
            $data = $statement->fetchAll();
            return $data;
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function getByIsbn(string $isbn) : ?array {
        try{ 
            $sql = <<<SQL
                SELECT 
                    book.id, 
                    book.isbn,
                    book.title,
                    book.year,
                    book.era,
                    book.location, 
                    author.id as author_id, 
                    author.name as author_name
                FROM book
                JOIN author ON book.author_id = author.id
                WHERE book.isbn = :isbn
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'isbn' => $isbn
            ] );
            $data = $statement->fetch();
            if($data === false) {
                return null;
            }
            return $data;
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function getByTitle(string $title) : ?array {
        try {
            $sql = <<<SQL
                SELECT 
                    book.id, 
                    book.isbn,
                    book.title,
                    book.year,
                    book.era,
                    book.location, 
                    author.id as author_id, 
                    author.name as author_name
                FROM book
                JOIN author ON book.author_id = author.id
                WHERE book.title = :title
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'title' => $title
            ] );
            $data = $statement->fetchAll();
            return $data;
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
    
    public function update(string $isbn, string $title, string $location) : void {
        try {
            $sql = <<<SQL
                UPDATE book
                SET title = :title, location = :location
                WHERE isbn = :isbn
            SQL;
            $statement = $this->pdo->prepare($sql);
            $statement->execute( [
                'isbn' => $isbn,
                'title' => $title,
                'location' => $location
            ] );
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

}


?>