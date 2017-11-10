<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function indexAction()
    {
        //die("something great");
        return $this->render('todo/index.html.twig');
    }
    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        //die("something great");
        return $this->render('todo/create.html.twig');
    }
    /**
     * @Route("/todos/edit/{id}", name="todo_edit")
     */
    public function editAction(Request $request)
    {
        //die("something great");
        return $this->render('todo/edit.html.twig');
    }
    /**
     * @Route("/todos/delete/{id}", name="todo_delete")
     */
    public function deleteAction(Request $request)
    {
        //die("something great");
        return $this->render('todo/delete.html.twig');
    }

}
