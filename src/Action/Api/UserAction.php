<?php

namespace App\Action\Api;

use App\Services\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserAction extends BaseAction
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sql = "SELECT * FROM users";
        $results = $this->userService->all();
        return $this->sendResponse($response, $results['result'], $results['status']);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = (int) $request->getAttribute('id') ?? 0;
        $results = $this->userService->byId($id);
        
        return $this->sendResponse($response, $results['result'], $results['status']);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        $results = $this->userService->store($data);
        $message = is_int($results['result'])? 'Added successfully' : $results['result'];
        
        return $this->sendResponse($response, $message, $results['status']);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $request->getAttribute('id') ?? 0;
        $data = $request->getParsedBody();
        $results = $this->userService->update($id, $data);
        
        return $this->sendResponse($response, $results['result'], $results['status']);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function destroy(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $id = $args["id"] ?? 0;
        $results = $this->userService->destroy($id);
        
        return $this->sendResponse($response, $results['result'], $results['status']);
    }
}
