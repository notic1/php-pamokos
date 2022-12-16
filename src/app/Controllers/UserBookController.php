<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Session;
use App\View;

class UserBookController extends Controller
{
    public function reserve()
    {
        $bookId = $_POST['id'];
        $user = User::getUser();

        $book = new Book();
        $book = $book->find($bookId);

        if ($book->quantity < 1) {
            Session::sessionMessage('All books are taken.', 'warning');

            return header('Location: /books');
        }

        if ($user->getBook($book)) {
            Session::sessionMessage('You already have this book', 'danger');

            return header('Location: /books');
        }

        if ($user->takeBook($book)) {
            /** @var Book $book */
            $book->decreaseQuantity();

            Session::sessionMessage('Successfully taken', 'success');

            return header('Location: /user/books');
        }

        Session::sessionMessage('Something went wrong', 'danger');

        return header('Location: /books');
    }

    public function index()
    {
        $books = User::getUser()->takenBooks();

        echo View::make('users/books/index', ['books' => $books]);
    }

    public function return()
    {
        $user = User::getUser();
        $book = (new Book)->find($_POST['id']);
        $user->returnBook($book);

        return header('Location: /user/books');
    }
}
