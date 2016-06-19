<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Articles;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends BaseController
{
    /**
     * Lists all Articles entities.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="articles_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $thisPage = $request->get('page') ? $request->get('page') : 1;
        
        $limit = $this->container->getParameter('articles_per_page');
        $pager = $this->getDoctrine()
                      ->getRepository('AppBundle:Articles')
                      ->getAllArticles($thisPage, $limit );
        $deleteForms = array();
        foreach ($pager  as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity)->createView();
        }
        $maxPages = ceil($pager->count() / $limit);
        return $this->render('articles/index.html.twig', compact('deleteForms','pager', 'maxPages', 'thisPage'));
    }
    

}
