<?php

namespace App\Repositories\Interfaces;

use App\Models\Candidature;

interface IStatisticsRepository{
    public function totalAnnonce();
    public function totalRecruiter();
    public function totalCandidate();
    public function totalAnnonceByRecruiter(int $recruiter_id);
    public function totalCandidaturesByRecruiter(int $recruiter_id);
    public function totalCandidaturesTodayByRecruiter(int $recruiter_id);
}