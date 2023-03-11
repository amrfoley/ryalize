<?php

namespace App\Services;

use App\Repositories\UserRepository;

final class UserService
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function all()
    {
        $result = $this->userRepo->all();

        return ['result' => json_encode($result), 'status' => $this->userRepo->getStatus()];
    }

    public function byId(int $id): array
    {
        $status = 422;
        $result = [];
        if(!empty($id)) {
            $result = $this->userRepo->getById($id);
            $status = $this->userRepo->getStatus();
        }

        return ['result' => json_encode($result), 'status' => $status];
    }

    public function store(array &$data): array
    {
        $status = 422;
        $id = 0;
        if (
            isset($data['name'], $data['email'], $data['phone']) &&
            !empty($data['name']) &&
            !empty($data['phone']) &&
            !empty($data['email'])
        ) {
            $id = $this->userRepo->store($data);
            $status = $this->userRepo->getStatus();
        }

        return ['result' => $id, 'status' => $status];
    }

    public function update(int $id, array &$data): array
    {
        $status = 422;
        $result = [];
        if (
            isset($data['name'], $data['email'], $data['phone']) &&
            !empty($id) &&
            !empty($data['name']) &&
            !empty($data['phone']) &&
            !empty($data['email'])
        ) {
            $result = $this->userRepo->update($id, $data);
            $status = $this->userRepo->getStatus();
        }

        return ['result' => json_encode($result), 'status' => $status];
    }

    public function destroy(int $id): array
    {
        $status = 422;
        $result = [];
        if(!empty($id)) {
            $result = $this->userRepo->destroy($id);
            $status = $this->userRepo->getStatus();
        }

        return ['result' => json_encode($result), 'status' => $status];
    }
}
