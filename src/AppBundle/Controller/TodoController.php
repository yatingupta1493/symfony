<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function indexAction()
    {
        //die("something great");
        $todosList = $this->getDoctrine()
                          ->getRepository("AppBundle:Todos")
                          ->findAll();

        return $this->render('todo/index.html.twig', array(
          "todosList" => $todosList
        ));
    }
    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        //die("something great");
        $todos = new Todos();
        $form = $this->createFormBuilder($todos)
                     ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                     ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                     ->add('priority', ChoiceType::class, array('choices' => array('Low' => "low", 'Medium' => "medium", 'High' => "high"), 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                     ->add('due_date', DateTimeType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
                     ->add('save', SubmitType::class, array('label' => 'Save', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
                     ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          //Get Data
          $name = $form['name']->getData();
          $description = $form['description']->getData();
          $priority = $form['priority']->getData();
          $due_date = $form['due_date']->getData();

          $now = new\DateTime('now');
          $todos->setName($name);
          $todos->setDescription($description);
          $todos->setPriority($priority);
          $todos->setDueDate($due_date);
          $todos->setCreateDate($now);

          $em = $this->getDoctrine()->getManager();
          $em->persist($todos);
          $em->flush();

          $this->addFlash('notice', 'New Todo task is added');
          $this->redirectToRoute('todo_list');
        }
        else {
          echo "doing nothing!!";
        }

        return $this->render('todo/create.html.twig', array(
          "form" => $form->createView()
        ));
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
