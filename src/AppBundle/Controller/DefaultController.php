<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;
use AppBundle\Repository\TodoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $todo = new Todo();
        $form = $this->createForm(new TodoType(), $todo);
        if($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em->persist($todo);
                $em->flush();
                return $this->redirect($this->generateUrl('homepage'));
            }
        }

        /** @var TodoRepository $repository */
        $repository = $em->getRepository('AppBundle:Todo');
        $items = $repository->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'items' => $items,
        ]);
    }

    /**
     * @Route("/done", name="done")
     */
    public function doneAction(Request $request)
    {
        if($request->getMethod() == 'POST') {
            $id = $request->request->get('id', 0);
            $em = $this->getDoctrine()->getManager();
            /** @var TodoRepository $repository */
            $repository = $em->getRepository('AppBundle:Todo');
            /** @var Todo $todo */
            $todo = $repository->find($id);
            $todo->setDone(true);
            $em->persist($todo);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function deleteAction(Request $request)
    {
        if($request->getMethod() == 'POST') {
            $id = $request->request->get('id', 0);
            $em = $this->getDoctrine()->getManager();
            /** @var TodoRepository $repository */
            $repository = $em->getRepository('AppBundle:Todo');
            $todo = $repository->find($id);
            $em->remove($todo);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('homepage'));
    }
}
