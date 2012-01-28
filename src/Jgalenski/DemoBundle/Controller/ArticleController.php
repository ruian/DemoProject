<?php

namespace Jgalenski\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jgalenski\DemoBundle\Entity\Article;
use Jgalenski\DemoBundle\Form\Type\ArticleType;


/**
 * Controller used for Article
 *
 * @author jgalenski
 */
class ArticleController extends Controller
{
    const ARTICLE_PER_PAGE = 10;
    
    /**
     * Render all articles with a pagination
     */
    public function indexAction()
    {
        // Get the paginator service
        $paginator = $this->get('knp_paginator');
        $page = $this->get('request')->query->get('page');

        // Get the Article repository
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('JgalenskiDemoBundle:Article');

        // Reach all Articles
        $entities = $repo->findBy(array(), array('created_at' => 'DESC'));

        // Make a pagination of these entities
        $pagination = $paginator->paginate(
            $entities,
            $page/*page number*/,
            self::ARTICLE_PER_PAGE/*limit per page*/
        );

        return $this->render('JgalenskiDemoBundle:Article:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Render all articles with a pagination
     * But with an optimization of doctrine request
     */
    public function index_optimizedAction()
    {
        // Get the paginator service
        $paginator = $this->get('knp_paginator');
        $page = $this->get('request')->query->get('page');

        // Get the Article repository
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('JgalenskiDemoBundle:Article');

        // Get the query to reach All articles
        $query = $repo->queryFindBy(array(), array('created_at' => 'DESC'));

        // Make a pagination of these entities
        $pagination = $paginator->paginate(
            $query,
            $page/*page number*/,
            self::ARTICLE_PER_PAGE/*limit per page*/
        );

        return $this->render('JgalenskiDemoBundle:Article:index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    public function newAction()
    {
        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity);
        
        $request = $this->get('request');
        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);
            if (true === $form->isValid()) {
                $em = $this->get('doctrine.orm.default_entity_manager');
                $em->persist($entity);
                $em->flush();

                $this->setFlashSuccess('Congratulation, your article has been saved.');
                return $this->redirect($this->generateUrl('JgalenskiDemoBundle_new'));
            } else {
                $this->setFlashError('Warning, your article can\'t be saved due to some errors.');
            }
        }

        return $this->render('JgalenskiDemoBundle:Article:new.html.twig', array(
            'form_view' => $form->createView(),
        ));
    }

    protected function setFlashSuccess($message)
    {
        $this->get('session')->setFlash('alert-success', $message);
    }

    protected function setFlashError($message)
    {
        $this->get('session')->setFlash('alert-error', $message);
    }
}
