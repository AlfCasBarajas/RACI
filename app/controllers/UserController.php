<?php
require_once 'models/User.php';
require_once 'models/Role.php';

class UserController {
    public function index() {
        $users = User::all();
        require 'views/users/index.php';
    }

    public function create() {
        $roles = Role::getAll();
        require 'views/users/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            User::create($_POST);
            header('Location: /?controller=user&action=index');
        }
    }

    public function delete() {
        $id = $_GET['id'];
        User::delete($id);
        header('Location: /?controller=user&action=index');
    }
}
