<?php


require_once __DIR__ . '/vendor/autoload.php';


use App\Config\Connection;
use App\Console\LibraryConsole;
use App\Control\CreateAuthorController;
use App\Control\CreateBookController;
use App\Control\DeleteBookController;
use App\Control\ListBooksController;
use App\Control\UpdateBookController;
use App\Repository\AuthorRepositoryBdr;
use App\Repository\BookRepositoryBdr;


$connection = new Connection();
$pdo = $connection->connect();
$authorRepo = new AuthorRepositoryBdr($pdo);
$bookRepo = new BookRepositoryBdr($pdo);
$createAuthor = new CreateAuthorController($authorRepo);
$createBook = new CreateBookController($authorRepo, $bookRepo);
$deleteBook = new DeleteBookController($bookRepo);
$listBooks = new ListBooksController($bookRepo);
$updateBook = new UpdateBookController($bookRepo);
$console = new LibraryConsole($createAuthor, $createBook, $deleteBook, $listBooks, $updateBook);
$console->menu();


?>