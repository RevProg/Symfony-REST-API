<?php

namespace tests\AppBundle\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class PhotoControllerTest extends WebTestCase
{
    protected $client;
    protected $em;

    public function setUp()
    {
        $classes = array(
            'AppBundle\DataFixtures\ORM\LoadPhotosData',
            'AppBundle\DataFixtures\ORM\LoadTagsData',
        );
        $this->loadFixtures($classes);

        $this->client = static::createClient();
    }

    public function testPhotosList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/photos');
        $response = $client->getResponse();
        $this->assertEquals(1, count($response->getContent()));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPhotosCount()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/photos/count');
        $response = $client->getResponse();
        $this->assertEquals(1, $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testMissingPhoto()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/photos/2');
        $response = $client->getResponse();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testPhotoCreation()
    {
        $client = static::createClient();

        $client->request('POST', '/photos', [
            'photo' => [
                'title' => 'Second',
            ],
            'tags' => 'First',
        ]);

        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $client->request('GET', '/photos/count');
        $response = $client->getResponse();
        $this->assertEquals(2, $response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPhotoDelete()
    {
        $client = static::createClient();

        $client->request('DELETE', '/photos/1');

        $response = $client->getResponse();

        $this->assertEquals(204, $response->getStatusCode());

        $client->request('GET', '/photos/count');
        $response = $client->getResponse();
        $this->assertEquals(0, $response->getContent());
        $this->assertEquals(200, $response->getStatusCode());
    }

}
