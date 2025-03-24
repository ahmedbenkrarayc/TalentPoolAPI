<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Candidature;

class Annonce extends Model
{
    protected $table = 'annonce';
    protected $fillable = [
        'title',
        'description',
        'company',
        'location',
        'salary_range',
        'status',
        'recruiter_id'
    ];

    public function recruiter(){
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function candidatures(){
        return $this->hasMany(Candidature::class, 'annonce_id');
    }
}
