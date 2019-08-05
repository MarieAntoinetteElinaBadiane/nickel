<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use  Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthentificationController extends AbstractController
{
     /**
     * @Route("/authentification", name="authentification")
     */
    
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $sms='message';
        $status='status';

        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {

            $user = new User();
            $user->setNom(trim($values->nom));
            $user->setPrenom(trim($values->prenom));
            $user->setStatut(trim('actif'));
            $user->setUsername(trim($values->username));
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
                    $user->setRoles(['ROLE_SUPER']);
                    $user->setPhoto(trim($values->photo));
                $entityManager = $this->getDoctrine()->getManager();
                
                $entityManager->persist($user);
                 $entityManager->flush();

            $data = [
                $status => 201,
             $sms => 'Les propriétés du user ont été bien ajouté'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            $status => 500,
            $sms => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }

     /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
        }

