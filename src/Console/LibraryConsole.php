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
    ) {}

    public function menu() : void {
        while(true) {
            echo(
                'Escolha abaixo a opção desejada:' . str_repeat(PHP_EOL, 2) .
                '1 para cadastrar autor' . PHP_EOL . 
                '2 para cadastrar livro' . PHP_EOL . 
                '3 para listar livros de um autor' . PHP_EOL .
                '4 para pesquisar livro pelo título' . PHP_EOL . 
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
                    $this->listBooksByAuthor();
                    break;
                case '4':
                    $this->listBooksByTitle();
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
            foreach($exception->getProblems() as $problem) {
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
        $isbn = readline();
        echo('Informe o título do livro: ');
        $title = readline();
        echo('Informe o ano de publicação: ');
        $year = (int)readline();
        echo('Informe a era da publicação (AC ou DC): ');
        $inputEra = strtoupper(readline());
        $era = match($inputEra) {
            'AC' => Era::BC,
            'DC' => Era::AD,
            default => null,
        };
        if ($era === null) {
            echo('[ERRO] Informe a era corretamente.');
            return;
        }
        echo('Informe a localização do livro: ');
        $location = readline();
        echo('Informe o nome do autor: ');
        $authorName = readline();
        try{ 
            $this->createBookController->create($isbn, $title, $year, $era, $location, trim($authorName));
            echo('Livro cadastrado com sucesso.');
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch (Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function listBooksByAuthor() : void {
        echo('Informe o nome do autor: ');
        $name = readline();
        try{ 
            $books = $this->listBooksController->listByAuthor(trim($name));
            if(empty($books)) {
                echo('Nenhum livro encontrado para o autor pesquisado.');
                return;
            }
            foreach ($books as $book) {
                print_r($book);
            }
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch(Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function listBooksByTitle() : void {
        echo('Informe o título do livro: ');
        $title = readline();
        try{ 
            $books = $this->listBooksController->listByTitle(trim($title));
            if(empty($books)) {
                echo('Nenhum livro encontrado para o título pesquisado.');
                return;
            }
            foreach ($books as $book) {
                print_r($book);
            }
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch(Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function updateBook() : void {
        echo('Informe o ISBN do livro: ');
        $isbn = readline();
        try{ 
            $this->updateBookController->update($isbn);
            echo('Livro atualizado com sucesso.');
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch(Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

    private function deleteBook() : void {
        echo('Informe o ISBN do livro: ');
        $isbn = readline();
        try{ 
            $this->deleteBookController->delete($isbn);
            echo('Livro excluído com sucesso.');
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo('[ERRO DE DOMÍNIO] ' . $problem . ', ');
            }
        } catch(RepositoryException $exception) {
            echo('[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.');
        } catch(Exception $exception) {
            echo('[ERRO] ' . $exception->getMessage() . '.');
        }
    }

}


?>