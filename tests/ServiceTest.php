<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{public function testajoutOk()
    {
        $ajout = static::createClient([],[
            'PHP_AUTH_USER' => 'ElinaAdminWari',
            'PHP_AUTH_PW'   => 'marie199'

        ]);
        
        $crawler = $ajout->request('POST', '/api/ajoutargent',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{"numerocompte":"0408201921540308pm","compte":4,"user":6,"montant":75000}');
        $rep=$ajout->getResponse();
        var_dump($rep);
        $this->assertSame(201,$ajout->getResponse()->getStatusCode());
    }
}
