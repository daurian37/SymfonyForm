<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/task', name: 'app_task')]
    public function new(EntityManagerInterface $entityManager,ManagerRegistry $registry , Request $request): Response
    {

        // creates a task object and initializes some data for this example

        $form = $this->createForm(TaskForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
          /*
            $task = new Task();
            $task->setTask($data['task']);
            $task->setDueDate($data['dueDate']);
          */

            $entityManager = $registry->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

           //   $this->addFlash('success','Tache enregistrée avec succes !');

            return $this->redirectToRoute('app_home');
        }

        return $this->renderForm('task/index.html.twig', [
            'form' => $form,
        ]);
    }
}
