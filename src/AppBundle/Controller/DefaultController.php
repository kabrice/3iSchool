<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Rubrique;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {




        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/rubriques", name="rubriques_list")
     * @Method({"GET"})
     */
    public function getRubriquesAction(Request $request)
    {
        return new JsonResponse([
            new Rubrique(1,  "A", "z/a.jpg", "importance a", "présentation a"),
            new Rubrique(2,  "B", "z/b.jpg", "importance b", "présentation b"),
            new Rubrique(3, "C", "z/c.jpg", "importance c", "présentation c"),
        ]);
    }
}
