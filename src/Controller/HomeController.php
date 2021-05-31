<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Secret;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @return Response
     * @Route("/add")
     */
    public function add(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $secret = new Secret();
        $secret->setAccessKey('1234567890123');
        $secret->setSecretData('data test');

        $entityManager->persist($secret);
        $entityManager->flush();

        return $this->render('home/index.html.twig');
    }

    /**
     * @return Response
     * @Route("/view")
     */
    public function view(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
