<?php

namespace MyTranslationUIBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TranslateControllerTest extends WebTestCase
{
    /**
     * test that you can't access translator web ui as user
     */
    public function testIndexAsUser()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ));

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('jms_translation_index'));

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * test that you can access translator web ui as admin
     */
    public function testIndexAsAdmin()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('jms_translation_index'));

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
