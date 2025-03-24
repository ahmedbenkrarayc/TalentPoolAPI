<?php

namespace App\Services;

use App\Repositories\AnnonceRepositoryInterface;

class AnnonceService
{
    private $annonceRepository;

    public function __construct(IAnnonceRepository $annonceRepository)
    {
        $this->annonceRepository = $annonceRepository;
    }

    public function getAll()
    {
        return $this->annonceRepository->all();
    }

    public function getById($id)
    {
        return $this->annonceRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->annonceRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->annonceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->annonceRepository->delete($id);
    }
}