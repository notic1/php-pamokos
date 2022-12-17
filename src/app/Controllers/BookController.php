<?php

namespace App\Controllers;

use App\Exceptions\RouteNotFoundException;
use App\Models\Book;
use App\Session;
use App\View;

class BookController extends Controller
{
    public function index()
    {
        $bookModel = new Book;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if ($currentPage == 0) {
            $currentPage = 1;
        }

        if (isset($_GET['query'])) {
            $query = $this->checkFormInput($_GET['query']);
            $books = (new Book)->search($query, $currentPage);
            $pagesCount = $bookModel->pagesCount(query: $query);
        } else {
            $pagesCount = $bookModel->pagesCount();
            $books = $bookModel->getAll(
                page: (int)$currentPage
            );
        }

        $paginator = $this->getPages($currentPage, $pagesCount);

        echo View::make('books/index', ['books' => $books, 'pages' => $pagesCount, 'paginator' => $paginator]);
    }

    public function create()
    {
        echo View::make('books/create');
    }

    public function store()
    {
        $validated = $this->validate(
            $_POST,
            [
                'author' => [
                    'required',
                    'string'
                ],
                'title' => [
                    'required',
                    'string'
                ],
                'year_released' => [
                    'required',
                    'date'
                ],
                'quantity' => [
                    'required',
                    'integer'
                ]
            ]
        );

        if (isset($validated['has_errors']) && $validated['has_errors']) {
            $_SESSION['login_form_errors'] = $validated;

            return header('Location: /books/create', true, 302);
        }

        $book = new Book();
        $book->create($validated);

        Session::sessionMessage('Book successfully created.', 'success');

        return header('Location: /books');
    }

    public function edit()
    {
        $bookModel = new Book();
        $book = $bookModel->find($_GET['id']);

        echo View::make('books/edit', ['book' => $book]);
    }

    public function update()
    {
        $validated = $this->validate(
            $_POST,
            [
                'author' => [
                    'required',
                    'string'
                ],
                'title' => [
                    'required',
                    'string'
                ],
                'year_released' => [
                    'required',
                    'date'
                ],
                'quantity' => [
                    'required',
                    'integer'
                ]
            ]
        );

        $bookModel = new Book();
        $book = $bookModel->find($_POST['id']);

        $book->update($validated);

        Session::sessionMessage('Book successfully updated.', 'success');

        return header('Location: /books');
    }

    public function delete()
    {
        $bookModel = new Book();
        $book = $bookModel->find($_POST['id']);
        $book->delete();

        $_SESSION['success_message'] = 'Book successfully deleted.';

        return header('Location: /books');
    }

    public function search()
    {
        $bookModel = new Book;
        $currentPage = isset($_POST['page']) ? (int)$_POST['page'] : 1;

        if ($currentPage == 0) {
            $currentPage = 1;
        }

        if (isset($_POST['query'])) {
            $query = $this->checkFormInput($_POST['query']);
            $books = (new Book)->search($query, $currentPage);
            $pagesCount = $bookModel->pagesCount(query: $query);
        } else {
            $pagesCount = $bookModel->pagesCount();
            $books = $bookModel->getAll(
                page: (int)$currentPage
            );
        }
        $paginator = $this->getPages($currentPage, $pagesCount);
        
        echo json_encode([
            ['books' => $books, 'pages' => $pagesCount, 'paginator' => $paginator]
        ]);

    }
}
