<?php

namespace App\Action\Web;

use App\Services\LocationService;
use App\Services\TransactionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TransactionAction extends BaseAction
{
    private TransactionService $transactionService;
    private LocationService $locationService;

    public function __construct()
    {
        parent::__construct();
        $this->transactionService = new TransactionService();
        $this->locationService = new LocationService();
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
        $params = $request->getQueryParams();
        $page = (int) (isset($params['page']) && intval( $params['page']) > 0) ? $params['page'] : 1;
        $offset = (int) !empty($params['offset']) ? $params['offset'] : 50;
        if (isset($params['location_id']) && !empty($params['location_id'])) {
            $data['page'] = $page;
            $data['offset'] = $offset;
            $data['location_id'] = $params['location_id'];
        }
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
        $transactions = isset($params['search']) ?
            $this->transactionService->searchByLocationIdAndDate($data) : $this->transactionService->paginate($page, $offset);
        $totalCount = $this->transactionService->count();
        $locations = $this->locationService->random(15);

        return $this->renderer->render(
            $response,
            'transactions.php',
            [
                'transactions' => $transactions['result'],
                'count' => $totalCount['result'],
                'page' => $page,
                'locations' => $locations['result']
            ]
        );
    }
}
