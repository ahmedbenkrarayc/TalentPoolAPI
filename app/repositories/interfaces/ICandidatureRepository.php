<?php

namespace App\Repositories\Interfaces;

use App\Models\Candidature;

interface ICandidatureRepository
{
    public function create(array $data);
    public function getByUser(int $userId);
    public function delete(int $id);
    public function getAll();
    public function getById(int $id);
}
