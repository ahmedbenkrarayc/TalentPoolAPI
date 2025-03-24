<?php

namespace App\Services;

use App\Repositories\ICandidatureRepository;
use Illuminate\Support\Facades\Storage;

class CandidatureService
{
    protected $candidatureRepository;

    public function __construct(ICandidatureRepository $candidatureRepository)
    {
        $this->candidatureRepository = $candidatureRepository;
    }

    public function createCandidature(array $data)
    {
        if (isset($data['cv'])) {
            $data['cv'] = $this->storeFile($data['cv'], 'candidatures/cvs');
        }

        if (isset($data['coverletter'])) {
            $data['coverletter'] = $this->storeFile($data['coverletter'], 'candidatures/coverletters');
        }

        return $this->candidatureRepository->create($data);
    }

    private function storeFile(UploadedFile $file, string $directory): string
    {
        $filename = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }

    public function getUserCandidatures(int $userId)
    {
        return $this->candidatureRepository->getByUser($userId);
    }

    public function deleteCandidature(int $id)
    {
        return $this->candidatureRepository->delete($id);
    }

    public function getAllCandidatures()
    {
        return $this->candidatureRepository->getAll();
    }

    public function getCandidatureById(int $id)
    {
        return $this->candidatureRepository->getById($id);
    }
}
