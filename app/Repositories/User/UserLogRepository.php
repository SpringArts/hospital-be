<?php

namespace App\Repositories\User;
use App\Interfaces\User\UserLogInterface;
use App\Models\UserLog;
use Illuminate\Queue\Failed\PrunableFailedJobProvider;

class UserLogRepository implements UserLogInterface {
    public function fetchAll(int $limit, int $page){
        return UserLog::paginate($limit , ['*'], 'page', $page)->withQueryString();
    }
    public function store(array $data){
        return UserLog::store($data);
    }
}