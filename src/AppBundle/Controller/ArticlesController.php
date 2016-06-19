<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Articles;

/**
 * Articles controller.
 *
 * @Route("/articles")
 */
class ArticlesController extends BaseController
{
    /**
     * Creates a new Articles entity.
     *
     * @Route("/new", name="articles_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $article = new Articles();
        $form = $this->createForm('AppBundle\Form\ArticlesType', $article);
        $form->handleRequest($request);
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('articles_show', array('id' => $article->getId()));
        }elseif (!$form->isSubmitted()){
            $form->get('name')->setData($user->getUsername());
        }

        return $this->render('articles/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Articles entity.
     *
     * @Route("/{id}", name="articles_show")
     * @Method("GET")
     */
    public function showAction(Articles $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('articles/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Articles entity.
     *
     * @Route("/{id}/edit", name="articles_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Articles $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('AppBundle\Form\ArticlesType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'notice',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('articles_index', array('id' => $article->getId()));
        }

        return $this->render('articles/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Articles entity.
     *
     * @Route("/{id}/delete", name="articles_delete")
     * Method("DELETE")
     */
    public function deleteAction(Request $request, Articles $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('articles_index');
    }
}
