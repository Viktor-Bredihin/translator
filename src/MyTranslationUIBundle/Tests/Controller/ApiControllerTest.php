<?php

namespace MyTranslationUIBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    /**
     * try to create translation message as user
     */
    public function testCreateMessageAsUser()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ));

        $url = $client->getContainer()->get('router')->generate('jms_translation_create_message', array(
            'config' => 'app',
            'domain' => 'default',
            'locale' => 'de'
        ));

        $crawler = $client->request('POST', $url, array(
            'key'     => 'apicontroller.test.message',
            'message' => 'translation'
        ));

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * create translation message as admin
     */
    public function testCreateMessageAsAdmin()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $url = $client->getContainer()->get('router')->generate('jms_translation_create_message', array(
            'config' => 'app',
            'domain' => 'default',
            'locale' => 'de'
        ));

        $crawler = $client->request('POST', $url, array(
            'key'     => 'apicontroller.test.message',
            'message' => 'translation'
        ));

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('jms_translation_index'));

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("apicontroller.test.message")')->count()
        );
    }

    /**
     * try to create translation message with the same key twice
     */
    public function testCreateMessageDupl()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $url = $client->getContainer()->get('router')->generate('jms_translation_create_message', array(
            'config' => 'app',
            'domain' => 'default',
            'locale' => 'de'
        ));

        $crawler = $client->request('POST', $url, array(
            'key'     => 'apicontroller.test.message',
            'message' => 'translation'
        ));

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('jms_translation_index'));

        $this->assertEquals(
            1,
            $crawler->filter('html:contains("apicontroller.test.message")')->count()
        );
    }

    /**
     * try to delete translation message as user
     */
    public function testDeleteMessageAsUser()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ));

        $url = $client->getContainer()->get('router')->generate('jms_translation_delete_message', array(
            'config' => 'app',
            'domain' => 'default',
            'locale' => 'de'
        ));

        $crawler = $client->request('DELETE', $url . '?id=' . urlencode('apicontroller.test.message'));
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }

    /**
     * delete translation messge
     */
    public function testDeleteMessageAsAdmin()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ));

        $url = $client->getContainer()->get('router')->generate('jms_translation_delete_message', array(
            'config' => 'app',
            'domain' => 'default',
            'locale' => 'de'
        ));

        $crawler = $client->request('DELETE', $url . '?id=' . urlencode('apicontroller.test.message'));

        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('jms_translation_index'));

        $this->assertEquals(
            0,
            $crawler->filter('html:contains("apicontroller.test.message")')->count()
        );
    }
}
