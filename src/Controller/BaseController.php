<?php


namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractFOSRestController
{
    /**
     * @param $data
     * @param int $statusCode
     * @return Response
     */
    protected function respond($data, $statusCode = Response::HTTP_OK)
    {
        return $this->handleView($this->view($data, $statusCode));
    }

}