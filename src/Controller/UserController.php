<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationType;


class UserController extends AbstractController
{
    /**
     * @Route("/registration", name="user_registration")
     */
    public function index(Request $request): Response
    {
        $user = new User();
        
        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //return new Response("Compte créé avec succes");
            return $this->render('user/registration.html.twig', [
                'form' => $form->createView()
            ]);
        }
        
        
    }
}
