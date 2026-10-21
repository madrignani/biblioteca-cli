<?php


require_once __DIR__ . 'vendor/autoload.php';


use App\Console\LibraryConsole;
use App\Control\CreateAuthorController;
use App\Control\CreateBookController;
use App\Control\DeleteBookController;
use App\Control\ListBooksController;
use App\Control\UpdateBookController;

$createAuthor = new CreateAuthorController();
$createBook = new CreateBookController();
$deleteBook = new DeleteBookController();
$listBooks = new ListBooksController();
$updateBook = new UpdateBookController();

$console = new LibraryConsole($createAuthor, $createBook, $deleteBook, $listBooks, $updateBook);
$console->menu();


?>