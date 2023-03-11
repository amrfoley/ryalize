<?php

namespace App\Action\Api;

use Psr\Http\Message\ResponseInterface;

abstract class BaseAction
{
    /**
     * @param ResponseInterface $response
     * @param string $data
     * @param int $status
     * 
     * @return ResponseInterface
     */
    protected function sendResponse(ResponseInterface &$response, string &$data, int $status = 200): ResponseInterface
    {
        $response->getBody()->write($data);

        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus($status);
    }
}
