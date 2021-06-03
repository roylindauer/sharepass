<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Secret;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Repository\SecretRepository;

class HomeController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="secret_index")
     */
    public function index(Request $request): Response
    {
        $secret = new Secret();

        $form = $this->createFormBuilder($secret)
            ->add('secret_data', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Encrypt'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $secret = $form->getData();
            $secret->setAccessKey(uniqid());

            $entityManager->persist($secret);
            $entityManager->flush();

            return $this->redirectToRoute('secret_success', ['key' => $secret->getAccessKey()]);
        }

        return $this->render('home/index.html.twig', [
            'form' => ($form) ? $form->createView() : false
        ]);

    }

    /**
     * @return Response
     * @Route("/success/{key}", name="secret_success")
     */
    public function success($key, Request $request)
    {
        return $this->render('home/success.html.twig', [
            'link' => getenv('DOMAIN') . 'view/' . $key
        ]);
    }

    /**
     * @return Response
     * @Route("/view/{key}", name="secret_view")
     */
    public function view($key, SecretRepository $secretRepository): Response
    {
        $secret = $secretRepository->findOneBy(['access_key' => $key]);

        if (!$secret) {
            throw $this->createNotFoundException(
                'Secret Payload Does Not Exist: ' . $key
            );
        }

        return $this->render('home/view.html.twig', [
            'secret' => $secret->getSecretData()
        ]);
    }
}
