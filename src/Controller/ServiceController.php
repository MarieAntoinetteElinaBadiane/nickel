<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Partenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use  Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 */
class AController extends AbstractController
{
    /**
     * @Route("/ajoutsuper", name="ajoutsuper", methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $sms='message';
        $status='status';

        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
    

            $partenaire = new Partenaire();
            $partenaire->setNinea($values->ninea);
            $partenaire->setAdresse($values->adresse);
            $partenaire->setRaisonSociale($values->raison_sociale);
            $partenaire->setPhoto($values->photo);


            $user = new User();
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setStatut($values->statut);
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
                if ($values->roles==1) {
                    $user->setRoles(['SUPER_ADMIN']);
                }
                if ($values->roles==2) {
                    $user->setRoles(['ADMIN']);
                }
                if ($values->roles==3) {
                    $user->setRoles(['USER']);
                }

                if ($values->roles==4) {
                    $user->setRoles(['CAISSIER']);
                }
            $user->setPhoto($values->photo);
            $user->setPart($partenaire);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
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
    * @Route("/user", name="user", methods={"POST"})
    */
    public function user(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    
    {
        $sms='message';
        $status='status';

        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            
            $user = new User();
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setStatut($values->statut);
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
                if ($values->roles==1) {
                    $user->setRoles(['SUPER_ADMIN']);
                }
                if ($values->roles==2) {
                    $user->setRoles(['ADMIN']);
                }
                if ($values->roles==3) {
                    $user->setRoles(['USER']);
                }

                if ($values->roles==4) {
                    $user->setRoles(['CAISSIER']);
                }
            $user->setPhoto($values->photo);
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
    * @Route("/adduser", name="adduser", methods={"POST"})
    */
    public function adduser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    
    {
        $sms='message';
        $status='status';

        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            
            $user = new User();
            $user->setNom($values->nom);
            $user->setPrenom($values->prenom);
            $user->setStatut($values->statut);
            $user->setUsername($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
                if ($values->roles==1) {
                    $user->setRoles(['SUPER_ADMIN']);
                }
                if ($values->roles==2) {
                    $user->setRoles(['ADMIN']);
                }
                if ($values->roles==3) {
                    $user->setRoles(['USER']);
                }
                if ($values->roles==4) {
                    $user->setRoles(['CAISSIER']);
                }
                $user->setPhoto($values->photo);
                $partenaire= $this->getDoctrine()->getRepository(Partenaire::class)->find($values->part);
                $user->setPart($partenaire);
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
    }









