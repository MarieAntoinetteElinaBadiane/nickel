<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Partenaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Depot;
use App\Entity\Compte;


/**
 * @Route("/api")
 */
class ServiceController extends AbstractController
{
    /**
     * @Route("/ajoutdestrois", name="ajoutdestrois", methods={"POST"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $sms='messe';
        $status='statut';

        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
    

            $partenaire = new Partenaire();
            $partenaire->setNinea(trim($values->ninea));
            $partenaire->setAdresse(trim($values->adresse));
            $partenaire->setRaisonSociale(trim($values->raison_sociale));
            $partenaire->setPhoto(trim($values->photo));


            $user = new User();
            $user->setNom(trim($values->nom));
            $user->setPrenom(trim($values->prenom));
            $user->setStatut(trim('actif'));
            $user->setUsername(trim($values->username));
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
            if (strtolower($values->roles==strtolower(2))){
            $user->setRoles(['ROLE_ADMIN']);
           }
            if (strtolower($values->roles==strtolower(3))){
                $user->setRoles(['ROLE_USER']);
            }
            if (strtolower($values->roles==strtolower(4))){
                $user->setRoles(['ROLE_CAISSIER']);
            }

            $user->setPhoto(trim($values->photo));

            $user->setPartenaire($partenaire);

            $compte = new Compte();
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $heure = date('H');
            $minute = date('i');
            $seconde= date('s');
            $tata= date('ma');
            $numerocompte=$jour.$mois.$annee.$heure.$minute.$seconde.$tata;
            $compte->setNumerocompte(trim($numerocompte));
            $compte->setSolde(0);
           
            $compte->setPartenaire($partenaire);
        
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($compte);
                    $entityManager->persist($partenaire);
                    $entityManager->persist($user);
                    $entityManager->flush();

            $data = [
                $status => 201,
                $sms => 'Les propriétés  ont été bien ajouté'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            $status => 500,
            $sms => 'Renseignez les clés username et password'
        ];
        return new JsonResponse($data, 500);
    }

   /**
    * @Route("/systeme", name="systeme", methods={"POST"})
    */
    public function user(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    
    {
        $sms='messae';
        $status='statu';

        $values = json_decode($request->getContent());
        if(isset($values->username,$values->password)) {
            
            $user = new User();
            $user->setNom(trim($values->nom));
            $user->setPrenom(trim($values->prenom));
            $user->setStatut(trim('actif'));
            $user->setUsername(trim($values->username));
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
                
                if (strtolower($values->roles==strtolower(1))) {
                    $user->setRoles(['ROLE_SUPER']);
                }

                if (strtolower($values->roles==strtolower(4))) {
                    $user->setRoles(['ROLE_CAISSIER']);
                }
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
    * @Route("/partenaireuser", name="partenaireuser", methods={"POST"})
    */
    public function adduser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    
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
                if (strtolower($values->roles==strtolower(1))){
                    $user->setRoles(['ROLE_SUPER']);
                }
                if (strtolower($values->roles==strtolower(2))) {
                    $user->setRoles(['ROLE_ADMIN']);
                }
                if (strtolower($values->roles==strtolower(3))) {
                    $user->setRoles(['ROLE_USER']);
                }
                if (strtolower($values->roles==strtolower(4))) {
                    $user->setRoles(['ROLE_CAISSIER']);
                }
                $user->setPhoto(trim($values->photo));
                $Idpartenaire=$this->getUser()->getPartenaire();
                $partenaire= $this->getDoctrine()->getRepository(Partenaire::class)->find($Idpartenaire);
                $user->setPartenaire($partenaire);
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
     * @Route("/ajoutargent", name="ajoutargent", methods={"POST"})
     */
    public function argent(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $sms='message';
        $status='status';

        $values = json_decode($request->getContent());
        $compte = new Compte();
        
        if ($values->montant>=75000){
        $compte = $this->getDoctrine()->getRepository(Compte::class)->findOneBy(["numerocompte"=>$values->numerocompte]);
        $compte->setSolde($compte->getSolde()+$values->montant);
    $depot = new Depot();
    $depot->setDate(new \DateTime);
    $depot->setMontant(($values->montant));
    
    $user= $this->getDoctrine()->getRepository(User::class)->find($values->user);
    $depot->setUser($user);


    $compte= $this->getDoctrine()->getRepository(Compte::class)->find($values->compte);
    $depot->setCompte($compte);

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compte);
            $entityManager->persist($depot);
            $entityManager->flush();

            $data = [
                $status => 201,
                $sms => 'Les propriétés du depot ont été bien ajouté'
            ];
            return new JsonResponse($data, 201);
        }
        $data = [
            $status => 500,
            $sms => 'Renseignez les clés'
        ];
        return new JsonResponse($data, 500);
    }
    }
