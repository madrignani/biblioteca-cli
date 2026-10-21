<?php


namespace App\Config;


use PDO;
use PDOException;
use App\Exception\RepositoryException;


class Connection {

    public function connect(): PDO {
        try {
            return new PDO(
                'mysql:host=localhost;dbname=library;charset=utf8',
                'dev',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

}


?>