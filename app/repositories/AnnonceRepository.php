<?php

namespace App\Repositories;

use APp\Models\Annonce;

class AnnonceRepository implements IAnnonceRepository
{
    public function all()
    {
        return Annonce::with('recruiter', 'candidatures')->get();
    }

    public function find($id)
    {
        return Annonce::with('recruiter', 'candidatures')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Annonce::create($data);
    }

    public function update($id, array $data)
    {
        $annonce = $this->find($id);
        $annonce->update($data);
        return $annonce;
    }

    public function delete($id)
    {
        $annonce = $this->find($id);
        return $annonce->delete();
    }
}