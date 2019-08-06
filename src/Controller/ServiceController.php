<?php
namespace App\Controller;

function codage($test){
    $retour = 0;
    $taille= strlen($test);
    for($i=0; $i<$taille; $i++){
        if (ord($test[$i])==32){
            $retour=1;
        }
        else {
            $retour=0; break;
        }

    }
    if($retour==0){
        return bien;
    }
    if ($retour==1) {
        return mauvais;
    }

}

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
            $partenaire->setNinea->codage($values->ninea);
            $partenaire->setAdresse->codage($values->adresse);
            $partenaire->setRaisonSociale->codage($values->raison_sociale);
            $partenaire->setPhoto->codage($values->photo);


            $user = new User();
            $user->setNom->codage($values->nom);
            $user->setPrenom->codage($values->prenom);
            $user->setStatut->codage($values->statut);
            $user->setUsername->codage($values->username);
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

            $user->setPhoto->codage($values->photo);

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
            $compte->setNumerocompte->codage($numerocompte);
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
            $user->setNom->codage($values->nom);
            $user->setPrenom->codage($values->prenom);
            $user->setStatut->codage($values->statut);
            $user->setUsername->codage($values->username);
            $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
                
                if (strtolower($values->roles==strtolower(1))) {
                    $user->setRoles(['ROLE_SUPER']);
                }

                if (strtolower($values->roles==strtolower(4))) {
                    $user->setRoles(['ROLE_CAISSIER']);
                }
            $user->setPhoto->codage($values->photo);
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
            $user->setNom->codage($values->nom);
            $user->setPrenom->codage($values->prenom);
            $user->setStatut->codage($values->statut);
            $user->setUsername->codage($values->username);
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
                $user->setPhoto->codage($values->photo);
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
        
        if ($values->montant >= 75000){
    // $jour = date('d');
    // $mois = date('m');
    // $annee = date('Y');
    // $heure = date('H');
    // $minute = date('i');
    // $seconde= date('s');
    // $tata = date('am');
    // $numerocompte=$jour.$mois.$annee.$heure.$minute.$seconde.$tata;
    // $compte->setNumerocompte($numerocompte);
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

     /**
     * @Route("/depotargent", name="depotargent", methods={"POST"})
     */

     public function depotargent(Request $request, EntityManagerInterface $entityManager)
     {
    
        $sms='message';
        $status='status';

    $values = json_decode($request->getContent());
    // $partenaire = new Partenaire();
    // $partenaire->setNinea($values->ninea);
    // $partenaire->setAdresse($values->adresse);
    // $partenaire->setRaisonSociale($values->raison_sociale);
    // $partenaire->setPhoto($values->photo);


    $compte = new Compte();
    $jour = date('d');
    $mois = date('m');
    $annee = date('Y');
    $heure = date('H');
    $minute = date('i');
    $seconde= date('s');
    $tata = date('am');
    $numerocompte=$jour.$mois.$annee.$heure.$minute.$seconde.$tata;
    //$compte = $this->getDoctrine()->getRepository(Compte::class)->findOneBy(["numerocompte"=>$values->numerocompte]);
    //$compte->setSolde($compte->getSolde()+$values->montant);
    $compte->setNumerocompte->codage($numerocompte);
    $compte->setSolde(0);

    $partenaire= $this->getDoctrine()->getRepository(Partenaire::class)->find($values->partenaire);
    $compte->setPartenaire($partenaire);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compte);
            $entityManager->flush();

            $data = [
                $status => 201,
                $sms => 'Les propriétés de votre compte ont été bien ajouté'
            ];
            return new JsonResponse($data, 201);
        
        $data = [
            $status => 500,
            $sms => 'Renseignez les clés'
        ];
        return new JsonResponse($data, 500);
    
    }
    }
