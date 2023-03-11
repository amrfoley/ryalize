<?php

namespace App\Action\Api;

use App\Services\TransactionService;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TransactionAction extends BaseAction
{
    private TransactionService $transactionService;

    public function __construct()
    {
        $this->transactionService = new TransactionService();
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * 
     * @return ResponseInterface
     */
    public function search(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $params = $request->getQueryParams();
        $data['location_id'] = $params['location_id'] ?? null;
        if (isset($params['year'])) {
            $year = (int) $params['year'];
            if ($year > 2010 && $year < intval(date('Y'))) {
                $data['year'] = $params['year'];
            }
        }
        if (isset($params['month'])) {
            $month = (int) $params['month'];
            if ($month > 0 && $month < 13) {
                $data['month'] = $params['month'];
            }
        }
        if (isset($params['day'])) {
            $day = (int) $params['day'];
            if ($day > 0 && $day < 32) {
                $data['day'] = $params['day'];
            }
        }
        $results = $this->transactionService->searchByLocationIdAndDate($data);

        return $this->sendResponse($response, $results['result'], $results['status']);
    }
}
