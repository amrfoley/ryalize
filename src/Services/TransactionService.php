<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

final class TransactionService
{
    private TransactionRepository $transactionRepo;

    public function __construct()
    {
        $this->transactionRepo = new TransactionRepository();
    }

    /**
     * @param int $page
     * @param int $offset
     * 
     * @return array
     */
    public function paginate(int $page = 1, int $offset = 50): array
    {
        $result = $this->transactionRepo->paginate($page, $offset);
        $status = $this->transactionRepo->getStatus();

        return ['result' => $result, 'status' => $status];
    }

    /**
     * @return array
     */
    public function count(): array
    {
        $result = $this->transactionRepo->count();
        $status = $this->transactionRepo->getStatus();

        return ['result' => $result, 'status' => $status];
    }

    /**
     * @param mixed $data
     * 
     * @return array
     */
    public function searchByLocationIdAndDate(&$data): array
    {
        $status = 422;
        $result = [];
        if (isset($data['location_id']) && !empty($data['location_id'])) {
            $result = $this->transactionRepo->searchByLocationIdAndDate($data);
            $status = $this->transactionRepo->getStatus();
        }

        return ['result' => $result, 'status' => $status];
    }

    /**
     * @param array $data
     * 
     * @return array
     */
    public function storeMany(array &$data): array
    {
        $status = 422;
        $result = false;
        if (!empty($data)) {
            $result = $this->transactionRepo->storeMany($data);
            $status = $this->transactionRepo->getStatus();
        }

        return ['result' => $result, 'status' => $status];
    }
}
