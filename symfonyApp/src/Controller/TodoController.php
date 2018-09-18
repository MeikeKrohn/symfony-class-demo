<?php

namespace App\Controller;

use App\Entity\TodoItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends AbstractController
{
    public function todoList(Request $request)
    {

        $newItem = new TodoItem();
        /*$newItem->setDescription('');
        $newItem->setDueDate(new \DateTime());
        $newItem->setIsDone(false);*/

        $form = $this->createFormBuilder($newItem)
            ->add('description', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Add new item'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $newItem = $form->getData();
            $newItem->setIsDone(false);
            $newItem->setOwner($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newItem);
            $entityManager->flush();

            return $this->redirect($request->getUri());
        }

        // TodoItem::class returns class name
        //$listData = $this->getDoctrine()->getRepository(TodoItem::class)->findAll();

        /*
         * Alternative zu Zeile 54
         *
         * $listData = $this->getDoctrine()->getRepository(TodoItem::class)
            ->findBy(array('owner' => $this->getUser()));
         */

        $listData = $this->getUser()->getTodoItems();

        return $this->render('todo/list.html.twig', array('listData' => $listData, 'newItemForm' => $form->createView()));
    }

    public function viewItem(Request $request, $itemId) {

        $itemData = $this->getDoctrine()->getRepository(TodoItem::class)->find($itemId);

        $form = $this->createFormBuilder($itemData)
            ->add('description', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Save item'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $itemData = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($itemData);
            $entityManager->flush();

            // return $this->redirectToRoute('todoList');
        }

        return $this->render('todo/viewItem.html.twig',
            array('itemData' => $itemData, 'editForm' => $form->createView()));
    }

    public function deleteItem($itemId)
    {
        $itemData = $this->getDoctrine()->getRepository(TodoItem::class)->find($itemId);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($itemData);
        $entityManager->flush();

        return new Response();
    }

    public function markAsDoneItem($itemId) {
        $itemData = $this->getDoctrine()->getRepository(TodoItem::class)->find($itemId);

        /*if(!$itemData)
        {
            throw $this->createNotFoundException
            (
              'No product found for id' . $itemId
            );
        }*/

        if($itemData->getIsDone() == true)
        {
            $itemData->setIsDone(false);
        } else
        {
            $itemData->setIsDone(true);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($itemData);
        $entityManager->flush();

        return new Response();
    }
}