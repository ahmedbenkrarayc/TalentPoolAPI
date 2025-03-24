<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Annonce;
use App\Models\User;

class Candidature extends Model
{
    protected $table = 'candidature';
    protected $fillable = [
        'cv',
        'coverletter',
        'status',
        'annonce_id',
        'candidate_id'
    ];

    public function candidate(){
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function annonce(){
        return $this->belongsTo(Annonce::class, 'annonce_id');
    }
}
