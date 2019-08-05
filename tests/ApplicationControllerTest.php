<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationControllerTest extends WebTestCase
{
    public function testSome()
    {
        $part = static::createClient([],[
        'PHP_AUTH_USER' => 'ElinaAdminWari',
        'PHP_AUTH_PW' => 'marie199'
        
        ]);
        $crawler = $part->request('POST', '/api/ajoutdestrois',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "ninea":"guey1994",
            "adresse":"guediawaye",
            "raison_sociale":"SA",
            "photo":"image",
            "id_partenaire": 1,
            "nom":"gueye",
            "prenom":"mame amy",
            "username":"amy",
            "password":"amy1994",
            "roles":2
        }',
        '{
            "ninea":"ngom",
            "adresse":"kounoul",
            "raison_sociale":"SA",
            "photo":"image",
            "id_partenaire": 2,
            "nom":"ngom",
            "prenom":"abdoulaye",
            "username":"junior",
            "password":"laye1992",
            "roles":3
        }',
        '{
            "ninea":"ngom",
            "adresse":"hlm",
            "raison_sociale":"SA",
            "photo":"image",
            "id_partenaire": 3,
            "nom":"ngom",
            "prenom":"jolie",
            "username":"mariama",
            "password":"maria1995",
            "roles":4
        }',
        '{
            "ninea":"dieme",
            "adresse":"mbao",
            "raison_sociale":"SA",
            "photo":"image",
            "id_partenaire": 4,
            "nom":"dieme",
            "prenom":"moussa",
            "username":"moscar",
            "password":"mos1995",
            "roles":4
        }'
    );
        $rep=$part->getResponse();
        var_dump($rep);
        $this->assertSame(500,$part->getResponse()->getStatusCode());
        }
        }
