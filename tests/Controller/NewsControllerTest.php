<?php


namespace App\Tests\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsControllerTest extends TestController
{
    public function testShowNews()
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/news');
        $responseContent = $response->getContent();
        $responseDecode = json_decode($responseContent);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($responseDecode);
        $this->assertJson($responseContent);
    }

}