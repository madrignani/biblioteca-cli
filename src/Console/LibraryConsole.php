<?php


namespace App\Console;

use App\Control\CreateAuthorController;
use App\Control\CreateBookController;
use App\Control\DeleteBookController;
use App\Control\ListBooksController;
use App\Control\UpdateBookController;
use App\Enum\Era;
use App\Exception\DomainException;
use App\Exception\RepositoryException;
use Exception;


class LibraryConsole {

    public function __construct(
        private CreateAuthorController $createAuthorController,
        private CreateBookController $createBookController,
        private DeleteBookController $deleteBookController,
        private ListBooksController $listBooksController,
        private UpdateBookController $updateBookController
    ) { }

    public function menu() : void {
        while(true){
            echo('Escolha abaixo a opção desejada:');
            echo(
                '1 para cadastrar autor' . PHP_EOL . 
                '2 para cadastrar livro' . PHP_EOL . 
                '3 para listar livros de um autor' . PHP_EOL .
                '4 para pesquisar livro' . PHP_EOL . 
                '5 para atualizar dados de um livro' . PHP_EOL . 
                '6 para excluir livro' . PHP_EOL .
                '0 para sair'
            );
            $option = readline();
            switch($option) {
                case '1':
                    $this->createAuthor();
                    break;
                case '2':
                    $this->createBook();
                    break;
                case '3':
                    $this->listBooks();
                    break;
                case '4':
                    $this->searchBook();
                    break;
                case '5':
                    $this->updateBook();
                    break;
                case '6':
                    $this->deleteBook();
                    break;
                case '0':
                    return;
                default:
                    echo('Opção inválida.');
                    break;
            }
        }
    }

    private function createAuthor() : void {
        echo('Informe o nome do autor: ');
        $name = readline();
        try{ 
            $this->createAuthorController->create($name);
            echo('Autor cadastrado com sucesso.');
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        } 
    }

    private function createBook() : void {
        echo('Informe o ISBN do livro: ');
        $isbn = trim(readline());
        echo('Informe o título do livro: ');
        $title = trim(readline());
        echo('Informe o ano de publicação: ');
        $year = (int) trim(readline());
        echo('Informe a era da publicação (BC ou AD): ');
        $era = Era::tryFrom(strtoupper(trim(readline())));
        echo('Informe a localização do livro: ');
        $location = trim(readline());
        echo('Informe o nome do autor: ');
        $authorName = trim(readline());

        try{ 
            $this->createBookController->create(
                $isbn,
                $title,
                $year,
                $era,
                $location,
                $authorName
            );
            echo('Livro cadastrado com sucesso.');
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function listBooks() : void {
        echo('Informe o nome do autor: ');
        $name = trim(readline());

        try{ 
            $books = $this->listBooksController->listByAuthor($name);
            foreach ($books as $book) {
                print_r($book);
            }
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function searchBook() : void {
        echo('Informe o título do livro: ');
        $title = trim(readline());

        try{ 
            $books = $this->listBooksController->listByTitle($title);
            foreach ($books as $book) {
                print_r($book);
            }
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function updateBook() : void {
        echo('Informe o ISBN do livro: ');
        $isbn = trim(readline());

        try{ 
            $updated = $this->updateBookController->update($isbn);
            if ($updated) {
                echo('Livro atualizado com sucesso.');
            } else {
                echo('Nenhum livro foi atualizado.');
            }
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function deleteBook() : void {
        echo('Informe o ISBN do livro: ');
        $isbn = trim(readline());

        try{ 
            $deleted = $this->deleteBookController->delete($isbn);
            if ($deleted) {
                echo('Livro excluído com sucesso.');
            } else {
                echo('Nenhum livro foi excluído.');
            }
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

}


?>