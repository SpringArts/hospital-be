<?php

namespace App\Usecases\App\User;

use App\Interfaces\User\UserLogInterface;

class UserLogAction {
    private $userLogRepository;

    public function __construct(UserLogInterface $userLogRepository){
        $this->userLogRepository = $userLogRepository;
    }

    public function fetchAll(){
        $limit = request()->limit ?? 10;
        $page = request()->page ?? 1;
        return $this->userLogRepository->fetchAll($limit, $page);
    }

    public function store(array $data) {
        return $this->userLogRepository->store($data);
    }
}