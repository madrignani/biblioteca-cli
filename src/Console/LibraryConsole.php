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
                PHP_EOL .
                '========================================' . PHP_EOL .
                '            BIBLIOTECA - CLI'             . PHP_EOL .
                '========================================' . PHP_EOL . PHP_EOL .
                'Selecione uma opção:' . PHP_EOL . PHP_EOL .
                '  1 - Cadastrar autor' . PHP_EOL .
                '  2 - Cadastrar livro' . PHP_EOL .
                '  3 - Listar livros de um autor' . PHP_EOL .
                '  4 - Pesquisar livro pelo título' . PHP_EOL .
                '  5 - Atualizar dados de um livro' . PHP_EOL .
                '  6 - Excluir livro' . PHP_EOL .
                '  0 - Sair' . PHP_EOL . PHP_EOL .
                'Opção: '
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
                    echo(PHP_EOL . '[ERRO] Opção inválida.' . PHP_EOL);
                    break;
            }
        }
    }

    private function createAuthor() : void {
        echo(PHP_EOL . '--- Cadastro de autor ---' . PHP_EOL . PHP_EOL);
        echo('Nome do autor: ');
        $name = readline();
        try{ 
            $this->createAuthorController->create($name);
            echo(PHP_EOL . '[SUCESSO] Autor cadastrado com sucesso.' . PHP_EOL);
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo(PHP_EOL . '[ERRO DE DOMÍNIO] ' . $problem . '.' . PHP_EOL);
            }
        } catch(RepositoryException $exception) {
            echo(PHP_EOL . '[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } catch (Exception $exception) {
            echo(PHP_EOL . '[ERRO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } 
    }

    private function createBook() : void {
        echo(PHP_EOL . '--- Cadastro de livro ---' . PHP_EOL . PHP_EOL);
        echo('ISBN do livro: ');
        $isbn = readline();
        echo('Título do livro: ');
        $title = readline();
        echo('Ano de publicação: ');
        $year = (int)readline();
        echo('Era da publicação (AC ou DC): ');
        $inputEra = strtoupper(readline());
        $era = match($inputEra) {
            'AC' => Era::BC,
            'DC' => Era::AD,
            default => null,
        };
        if ($era === null) {
            echo(PHP_EOL . '[ERRO] Informe uma era válida: AC ou DC.' . PHP_EOL);
            return;
        }
        echo('Localização do livro: ');
        $location = readline();
        echo('Nome do autor: ');
        $authorName = readline();
        try{ 
            $this->createBookController->create($isbn, $title, $year, $era, $location, trim($authorName));
            echo(PHP_EOL . '[SUCESSO] Livro cadastrado com sucesso.' . PHP_EOL);
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo(PHP_EOL . '[ERRO DE DOMÍNIO] ' . $problem . '.' . PHP_EOL);
            }
        } catch(RepositoryException $exception) {
            echo(PHP_EOL . '[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } catch (Exception $exception) {
            echo(PHP_EOL . '[ERRO] ' . $exception->getMessage() . '.' . PHP_EOL);
        }
    }

    private function listBooksByAuthor() : void {
        echo(PHP_EOL . '--- Livros por autor ---' . PHP_EOL . PHP_EOL);
        echo('Nome do autor: ');
        $name = readline();
        try{ 
            $books = $this->listBooksController->listByAuthor(trim($name));
            if(empty($books)) {
                echo(PHP_EOL . 'Nenhum livro foi encontrado para o autor informado.' . PHP_EOL);
                return;
            }
            foreach ($books as $book) {
                echo(PHP_EOL . 'Livro encontrado:' . PHP_EOL);
                print_r($book);
            }
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo(PHP_EOL . '[ERRO DE DOMÍNIO] ' . $problem . '.' . PHP_EOL);
            }
        } catch(RepositoryException $exception) {
            echo(PHP_EOL . '[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } catch(Exception $exception) {
            echo(PHP_EOL . '[ERRO] ' . $exception->getMessage() . '.' . PHP_EOL);
        }
    }

    private function listBooksByTitle() : void {
        echo(PHP_EOL . '--- Livros por título ---' . PHP_EOL . PHP_EOL);
        echo('Título do livro: ');
        $title = readline();
        try{ 
            $books = $this->listBooksController->listByTitle(trim($title));
            if(empty($books)) {
                echo(PHP_EOL . 'Nenhum livro foi encontrado para o título informado.' . PHP_EOL);
                return;
            }
            foreach ($books as $book) {
                echo(PHP_EOL . 'Livro encontrado:' . PHP_EOL);
                print_r($book);
            }
        } catch(DomainException $exception) {
            foreach($exception->getProblems() as $problem) {
                echo(PHP_EOL . '[ERRO DE DOMÍNIO] ' . $problem . '.' . PHP_EOL);
            }
        } catch(RepositoryException $exception) {
            echo(PHP_EOL . '[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } catch(Exception $exception) {
            echo(PHP_EOL . '[ERRO] ' . $exception->getMessage() . '.' . PHP_EOL);
        }
    }

    private function updateBook() : void {
        echo(PHP_EOL . '--- Atualização de livro ---' . PHP_EOL . PHP_EOL);
        echo('ISBN do livro: ');
        $isbn = readline();
        try{ 
            $book = $this->listBooksController->listByIsbn(trim($isbn));
            if(!($book)) {
                echo(PHP_EOL . 'Nenhum livro foi encontrado para o ISBN informado.' . PHP_EOL);
                return;
            }
            echo(PHP_EOL . 'Editando livro.' . PHP_EOL);
            echo('Pressione ENTER para manter o valor atual.' . PHP_EOL . PHP_EOL);
            echo('Título atual: ' . $book['title'] . PHP_EOL);
            echo('Novo título: ');
            $newTitle = readline();
            $title = ( trim($newTitle) === '' ? $book['title'] : trim($newTitle) );
            echo(PHP_EOL . 'Localização atual: ' . $book['location'] . PHP_EOL);
            echo('Nova localização: ');
            $newLocation = readline();
            $location = ( trim($newLocation) === '' ? $book['location'] : trim($newLocation) );
            $this->updateBookController->update($book['isbn'], $title, $location);
            echo(PHP_EOL . '[SUCESSO] Livro atualizado com sucesso.' . PHP_EOL);
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo(PHP_EOL . '[ERRO DE DOMÍNIO] ' . $problem . '.' . PHP_EOL);
            }
        } catch(RepositoryException $exception) {
            echo(PHP_EOL . '[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } catch(Exception $exception) {
            echo(PHP_EOL . '[ERRO] ' . $exception->getMessage() . '.' . PHP_EOL);
        }
    }

    private function deleteBook() : void {
        echo(PHP_EOL . '--- Exclusão de livro ---' . PHP_EOL . PHP_EOL);
        echo('ISBN do livro: ');
        $isbn = readline();
        try{ 
            $this->deleteBookController->delete(trim($isbn));
            echo(PHP_EOL . '[SUCESSO] Livro excluído com sucesso.' . PHP_EOL);
        } catch(DomainException $exception) {
            foreach ($exception->getProblems() as $problem) {
                echo(PHP_EOL . '[ERRO DE DOMÍNIO] ' . $problem . '.' . PHP_EOL);
            }
        } catch(RepositoryException $exception) {
            echo(PHP_EOL . '[ERRO DE REPOSITÓRIO] ' . $exception->getMessage() . '.' . PHP_EOL);
        } catch(Exception $exception) {
            echo(PHP_EOL . '[ERRO] ' . $exception->getMessage() . '.' . PHP_EOL);
        }
    }

}


?>