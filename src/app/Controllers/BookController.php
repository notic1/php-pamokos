<?php

namespace App\Controllers;

use App\Models\Book;
use App\View;

class BookController extends Controller
{
    public function index()
    {
        $bookModel = new Book;
        $books = $bookModel->getAll();

        echo View::make('books/index', ['books' => $books]);
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

        $_SESSION['success_message'] = 'Book successfully created.';

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
        
        $_SESSION['success_message'] = 'Book successfully updated.';

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
}