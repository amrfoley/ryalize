<?php

namespace App\Services;

use App\Repositories\LocationRepository;

final class LocationService
{
    private LocationRepository $locationRepo;

    public function __construct()
    {
        $this->locationRepo = new LocationRepository();
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $result = $this->locationRepo->all();

        return ['result' => json_encode($result), 'status' => $this->locationRepo->getStatus()];
    }

    /**
     * @param int $limit
     * 
     * @return array
     */
    public function random(int $limit): array
    {
        $result = $this->locationRepo->random($limit);

        return ['result' => $result, 'status' => $this->locationRepo->getStatus()];
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function byId(int $id): array
    {
        $status = 422;
        $result = [];
        if(!empty($id)) {
            $result = $this->locationRepo->getById($id);
            $status = $this->locationRepo->getStatus();
        }

        return ['result' => json_encode($result), 'status' => $status];
    }

    /**
     * @param array $data
     * 
     * @return array
     */
    public function store(array &$data): array
    {
        $status = 422;
        $id = 0;
        if (
            isset($data['country'], $data['state'], $data['city']) &&
            !empty($data['country']) &&
            !empty($data['city']) &&
            !empty($data['state'])
        ) {
            $id = $this->locationRepo->store($data);
            $status = $this->locationRepo->getStatus();
        }

        return ['result' => $id, 'status' => $status];
    }

    /**
     * @param int $id
     * @param array $data
     * 
     * @return array
     */
    public function update(int $id, array &$data): array
    {
        $status = 422;
        $result = [];
        if (
            isset($data['country'], $data['state'], $data['city']) &&
            !empty($id) &&
            !empty($data['country']) &&
            !empty($data['city']) &&
            !empty($data['state'])
        ) {
            $result = $this->locationRepo->update($id, $data);
            $status = $this->locationRepo->getStatus();
        }

        return ['result' => json_encode($result), 'status' => $status];
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function destroy(int $id): array
    {
        $status = 422;
        $result = [];
        if(!empty($id)) {
            $result = $this->locationRepo->destroy($id);
            $status = $this->locationRepo->getStatus();
        }

        return ['result' => json_encode($result), 'status' => $status];
    }
}
