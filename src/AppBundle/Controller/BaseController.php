<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Articles;

/**
 * Default controller.
 *
 * @Route("/")
 */
class BaseController extends Controller
{
    /**
     * Creates a form to delete a Articles entity.
     *
     * @param Articles $article The Articles entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm(Articles $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('articles_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
