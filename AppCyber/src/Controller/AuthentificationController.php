<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\InscriptionUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthentificationController extends AbstractController
{
    
    /**
     * @Route("/inscriptionUser", name="inscriptionUser")
     */
    public function inscriptionUser(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $users = new Users();

        $form= $this->createForm(InscriptionUserFormType::class, $users);
        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $hash = $encoder->encodePassword($users, $users->getPassword());
                $users->setPassword($hash);
                $manager->persist($users);
                $manager->flush();
            }

        return $this->render('authentification/inscriptionUser.html.twig', [
            'controller_name' => 'AuthentificationController',
            'formUserInscription' =>$form->createView()
        ]);
    }
    /**
     * @Route("/authentification", name="authentification")
     */
    public function authentification()
    {
        return $this->render('authentification/authentification.html.twig', [
            'controller_name' => 'AuthentificationController',
        ]);
    }
     /**
     * @Route("/acceuil", name="acceuil")
     */
    public function acceuil()
    {
        return $this->render('authentification/acceuil.html.twig', [
            'controller_name' => 'AuthentificationController',
        ]);
    }
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(){
        
    }
}
