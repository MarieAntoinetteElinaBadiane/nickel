<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\UserType;
use App\Form\DepotType;
use App\Form\CompteType;
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ServiceController extends AbstractController
{
/**
* @Route("/ajoutdestrois", name="ajoutdestrois", methods={"POST"})
*/
public function ajout(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
{
    
                $part= new Partenaire();
                $form = $this->createForm(PartenaireType::class, $part);
                $data=$request->request->all();
                $form->submit($data);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($part);
                $entityManager->flush();

    $utilisateur = new User();
    $form=$this->createForm(UserType::class , $utilisateur);
    $form->handleRequest($request);
    $data=$request->request->all();
    //$file= $request->files->all()['imageName'];
    $form->submit($data);

    $utilisateur->setRoles(["ROLE_CAISSIER"]);
    //$utilisateur->setUpdatedAt(new \DateTime());
    //$utilisateur->setImageFile($file);
    $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
    $form->get('password')->getData()
        )
        );
    $entityManager = $this->getDoctrine()->getManager();
    $utilisateur->setPartenaire($part);
    $entityManager->persist($utilisateur);
    $entityManager->flush();


        $compte = new Compte();
        $jour = date('d');
        $mois = date('m');
        $annee = date('Y');
        $heure = date('H');
        $minute = date('i');
        $seconde= date('s');
        $tata= date('ma');
        $numerocompte=$jour.$mois.$annee.$heure.$minute.$seconde.$tata;
        $compte->setNumerocompte($numerocompte);
        $form = $this->createForm(CompteType::class, $compte);
        $data=$request->request->all();
        $form->submit($data);


$entityManager = $this->getDoctrine()->getManager();
$compte->setPartenaire($part);
$entityManager->persist($compte);
$entityManager->flush();
return new Response('Le trois tables ont été ajouté',Response::HTTP_CREATED); 
}

/**
* @Route("/caissier", name="caissier", methods={"POST"})
*/
public function caissier(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
{

    $utilisateur = new User();
    $form=$this->createForm(UserType::class , $utilisateur);
    $form->handleRequest($request);
    $data=$request->request->all();
    //$file= $request->files->all()['imageName'];
          $form->submit($data);
    
     $utilisateur->setRoles(['ROLE_CAISSIER']);
    //$utilisateur->setImageFile($file);
    $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
    $form->get('password')->getData()
        )
        );
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($utilisateur);
    $entityManager->flush();
    return new Response('La personne a été ajouté',Response::HTTP_CREATED); 

    }

/**
* @Route("/admin", name="admin", methods={"POST"})
*/
public function admin(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
{

    $utilisateur = new User();
    $form=$this->createForm(UserType::class , $utilisateur);
    $form->handleRequest($request);
    $data=$request->request->all();

          $form->submit($data);

    $utilisateur->setRoles(["ROLE_SuperAdmin"]);

    $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
    $form->get('password')->getData()
        )
        );
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($utilisateur);
    $entityManager->flush();
    return new Response('La personne a été ajouté',Response::HTTP_CREATED); 

    }

/**
* @Route("/user", name="user", methods={"POST"})
*/
public function adduser(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
{
    
                $part= new Partenaire();
                $form = $this->createForm(PartenaireType::class, $part);
                $data=$request->request->all();
                $form->submit($data);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($part);
                $entityManager->flush();

    $utilisateur = new User();
    $form=$this->createForm(UserType::class , $utilisateur);
    $form->handleRequest($request);
    $data=$request->request->all();
    $form->submit($data);
    //     $utilisateur->setRoles(['ROLE_ADMIN']);

    $utilisateur->setRoles(["ROLE_USER"]);
    $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
    $form->get('password')->getData()
        )
        );
    $entityManager = $this->getDoctrine()->getManager();
    $utilisateur->setPartenaire($part);
    $entityManager->persist($utilisateur);
    $entityManager->flush();
    return new Response('Le partenaire a bien ajouté un user',Response::HTTP_CREATED); 
}


/**
* @Route("/adminuser", name="adminuser", methods={"POST"})
*/
public function addadmin(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
{
    
                $part= new Partenaire();
                $form = $this->createForm(PartenaireType::class, $part);
                $data=$request->request->all();
                $form->submit($data);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($part);
                $entityManager->flush();

    $utilisateur = new User();
    $form=$this->createForm(UserType::class , $utilisateur);
    $form->handleRequest($request);
    $data=$request->request->all();
    $form->submit($data);
     $utilisateur->setRoles(['ROLE_ADMIN']);
    $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
    $form->get('password')->getData()
        )
        );
    $entityManager = $this->getDoctrine()->getManager();
    $utilisateur->setPartenaire($part);
    $entityManager->persist($utilisateur);
    $entityManager->flush();
    return new Response('Le partenaire a bien ajouté admin du user',Response::HTTP_CREATED); 
}

/**
* @Route("/depot", name="depot", methods={"POST"})
*/
public function argent(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
{

    // $values = json_decode($request->getContent());
    $values = json_decode($request->getContent());
    if ($values->montant >= 75000){
            $depot = new Depot();
            $depot->setDate(new \DateTime);
            $form = $this->createForm(DepotType::class, $depot);
            $data=$request->request->all();
            $form->submit($data);

           $compte = new Compte();
        
             $compte = $this->getDoctrine()->getRepository(Compte::class)->
             findOneBy(["numerocompte"=>$values->numerocompte]);

        $compte->setSolde($compte->getSolde()+ $values->montant);
        $form = $this->createForm(CompteType::class, $compte);
        $data=$request->request->all();
        $form->submit($data);
    }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($depot);
        $entityManager->persist($compte);
     
        $entityManager->flush();
    return new Response('Le depot sur votre compte sest bien passé',Response::HTTP_CREATED); 
    }
}

