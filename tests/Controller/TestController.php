<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestController extends WebTestCase
{
    public $serverInformation= ['ACCEPT'=>'application/json', 'CONTENT_TYPE'=>'application/json'];

    public function getResponseFromRequest(string $method, string $uri, string $testData='')
    {
        $client = static::createClient();
        $client->request($method, $uri, [], [], $this->serverInformation, $testData);
        return $client->getResponse();
    }
}