<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\StatisticsService;

class StatisticsController extends Controller
{
    private $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function adminStatistics()
    {
        $totalAnnonces = $this->statisticsService->getTotalAnnonce();
        $totalRecruiters = $this->statisticsService->getTotalRecruiter();
        $totalCandidates = $this->statisticsService->getTotalCandidate();

        return response()->json([
            'total_annonces' => $totalAnnonces,
            'total_recruiters' => $totalRecruiters,
            'total_candidates' => $totalCandidates,
        ]);
    }

    public function recruiterStatistics(int $recruiter_id)
    {
        $totalAnnoncesByRecruiter = $this->statisticsService->getTotalAnnonceByRecruiter($recruiter_id);
        $totalCandidaturesByRecruiter = $this->statisticsService->getTotalCandidaturesByRecruiter($recruiter_id);
        $totalCandidaturesTodayByRecruiter = $this->statisticsService->getTotalCandidaturesTodayByRecruiter($recruiter_id);

        return response()->json([
            'total_annonces_by_recruiter' => $totalAnnoncesByRecruiter,
            'total_candidatures_by_recruiter' => $totalCandidaturesByRecruiter,
            'total_candidatures_today_by_recruiter' => $totalCandidaturesTodayByRecruiter,
        ]);
    }
}
