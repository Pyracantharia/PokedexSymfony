<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder): Response {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
    
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /**
             * Définition du mdp hashé
             */
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            /** ENREGISTREMENT OK */
            $entityManager->persist($user);
            $entityManager->flush();

            /*
            GuardAuthenticatorHandler $guardHandle;
            AppSecurityAuthenticator $authenticator
                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // Référence au firewall du security.yaml
                );
            */
        }


        return $this->render('auth/register.html.twig', [
            'form' => $form->createView()
        ]);

    }

}