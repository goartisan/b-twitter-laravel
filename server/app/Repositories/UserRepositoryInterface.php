<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function findById($id);

    public function findByUsername($username);

    public function findProfile($where = [], $authId = 0);

    public function getInRandomOrder($limit = 10, $authId = 0);

    public function search($queryString);

    public function create($data);

    public function update($id, $data);
}
