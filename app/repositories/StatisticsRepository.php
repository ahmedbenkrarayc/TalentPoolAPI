<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IStatisticsRepository;
use App\Models\Annonce;
use App\Models\Candidature;
use App\Models\User;
use Carbon\Carbon;

class StatisticsRepository implements IStatisticsRepository
{
    public function totalAnnonce()
    {
        return Annonce::count();
    }

    public function totalRecruiter()
    {
        return User::where('role', 'recruiter')->count();
    }

    public function totalCandidate()
    {
        return User::where('role', 'candidate')->count();
    }

    public function totalAnnonceByRecruiter(int $recruiter_id)
    {
        return Annonce::where('recruiter_id', $recruiter_id)->count();
    }

    public function totalCandidaturesByRecruiter(int $recruiter_id)
    {
        return Candidature::whereIn('annonce_id', function ($query) use ($recruiter_id) {
            $query->select('id')
                ->from('annonce')
                ->where('recruiter_id', $recruiter_id);
        })->count();
    }

    public function totalCandidaturesTodayByRecruiter(int $recruiter_id)
    {
        $today = Carbon::today();

        return Candidature::whereIn('annonce_id', function ($query) use ($recruiter_id) {
            $query->select('id')
                ->from('annonce')
                ->where('recruiter_id', $recruiter_id);
        })
        ->whereDate('created_at', $today)
        ->count();
    }
}
