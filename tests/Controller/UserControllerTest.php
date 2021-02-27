<?php


namespace App\Tests\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends TestController
{
    public function testShowUsers()
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/admin/users');
        $responseContent = $response->getContent();
        $responseDecode = json_decode($responseContent);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertNotEmpty($responseDecode);
        $this->assertJson($responseContent);
    }

    public function testEmailSent()
    {
        $client = static ::createClient();
        $client->request('GET', 'api/admin/user/2/ban');

        $sentMail = $this->getMailerMessage(0);
        $this->assertEmailCount(1);
        $this->assertEmailHeaderSame($sentMail, 'to', 'mikemikelson@test.ru');
        $this->assertEmailHtmlBodyContains($sentMail, 'Some HTML');
        //$this->assertEmailAttachmentCount($sentMail, 1);
    }

}