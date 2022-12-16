<?php 

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;
use App\Session;
use App\View;

class UserController extends Controller
{
    public function index()
    {
        $users = (new User)->getAll();

        echo View::make('admin/users/index', ['users' => $users]);
    }

    public function create()
    {
        echo View::make('admin/users/create');
    }

    public function store()
    {
        $validated = $this->validate(
            $_POST,
            [
                'name' => [
                    'required',
                    'min:6'
                ],
                'email' => [
                    'required',
                    'email'
                ],
                'password' => [
                    'required',
                    'min:6',
                    'confirmed'
                ]
            ]
        );

        $user = (new User)->create($validated);
        
        Session::sessionMessage('User successfully created', 'success');

        return header('Location: /admin/users');
    }

    public function edit()
    {
        $user = (new User)->find($_GET['id']);

        echo View::make('admin/users/edit', ['user' => $user]);
    }

    public function update()
    {
        $validated = $this->validate(
            $_POST,
            [
                'name' => [
                    'required',
                    'min:6'
                ],
                'email' => [
                    'required',
                    'email'
                ]
            ]
        );

        $user = (new User)->find($_POST['id'])->update($validated);
        Session::sessionMessage('User successfully updated', 'success');


        return header('Location: /admin/users');
    }

    public function delete()
    {
        $user = (new User)->find($_POST['id'])->delete();

        Session::sessionMessage('User successfully deleted', 'success');

        return header('Location: /admin/users');
    }
}