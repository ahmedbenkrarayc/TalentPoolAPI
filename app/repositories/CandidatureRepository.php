<?php

namespace App\Repositories;

use App\Models\Candidature;
use App\Repositories\Interfaces\ICandidatureRepository;
use Illuminate\Support\Facades\Storage;

class CandidatureRepository implements ICandidatureRepository
{
    public function create(array $data)
    {
        return Candidature::create($data);
    }

    public function getByUser(int $userId)
    {
        return Candidature::with('candidate', 'annonce')->where('candidate_id', $userId)->get();
    }

    public function delete(int $id)
    {
        $candidature = Candidature::find($id);
        if (!$candidature) {
            return false;
        }

        Storage::delete([$candidature->cv, $candidature->coverletter]);

        return $candidature->delete();
    }

    public function getAll()
    {
        return Candidature::with('candidate', 'annonce')->get();
    }

    public function getById(int $id)
    {
        return Candidature::with('candidate', 'annonce')->find($id);
    }

    public function updateStatus(int $id, string $status){
        $candidature = Candidature::findOrFail($id);
        $candidature->status = $status;
        $candidature->save();
        return $candidature;
    }
}
