<?php

namespace App\Services;

use App\Repositories\Interfaces\IStatisticsRepository;

class StatisticsService
{
    private $statisticsRepository;

    public function __construct(IStatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function getTotalAnnonce()
    {
        return $this->statisticsRepository->totalAnnonce();
    }

    public function getTotalRecruiter()
    {
        return $this->statisticsRepository->totalRecruiter();
    }

    public function getTotalCandidate()
    {
        return $this->statisticsRepository->totalCandidate();
    }

    public function getTotalAnnonceByRecruiter(int $recruiter_id)
    {
        return $this->statisticsRepository->totalAnnonceByRecruiter($recruiter_id);
    }

    public function getTotalCandidaturesByRecruiter(int $recruiter_id)
    {
        return $this->statisticsRepository->totalCandidaturesByRecruiter($recruiter_id);
    }

    public function getTotalCandidaturesTodayByRecruiter(int $recruiter_id)
    {
        return $this->statisticsRepository->totalCandidaturesTodayByRecruiter($recruiter_id);
    }
}
