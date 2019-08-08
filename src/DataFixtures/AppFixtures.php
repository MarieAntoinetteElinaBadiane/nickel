<?php
namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class AppFixtures extends Fixture
{

public function __construct(UserPasswordEncoderInterface $passwordEncoder )
{
$this->passwordEncoder = $passwordEncoder;
}
public function load(ObjectManager $manager)
{
    
    $user = new User();
    $user->setUsername('ElinaAdminWari');
    $user->setNom('badiane');
    $user->setPrenom('elina');
    $user->setStatut('actif');
    $user->setRoles(['ROLE_SuperUtilisateur']);
    $passwordEncoder= $this->passwordEncoder->encodePassword($user, 'marie199');
    $user->setPassword($passwordEncoder);
    $user->setPhoto('image');
    $manager->persist($user);

    $manager->flush();
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
            if ($user->getStatut()=="bloqué"){
            return $this->json([
            'message' => 'ACCÉS REFUSÉ'
            ]);
        }
        }
    }
        