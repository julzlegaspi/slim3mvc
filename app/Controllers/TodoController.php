<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index ($request, $response) {
        $this->flash->addMessage('info', 'This is a simple flash message');
        $data = Todo::all();
        return $this->view->render($response, 'home.twig', [
            'data' => $data,
        ]);
    }

    public function testcsrf ($request, $response) {
        return "Successfull :)";
    }
}