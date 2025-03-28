<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CandidatureRequest;
use App\Http\Resources\CandidatureResource;
use App\Services\CandidatureService;

class CandidatureController extends Controller
{
    private $candidatureService;

    public function __construct(CandidatureService $candidatureService)
    {
        $this->candidatureService = $candidatureService;
    }

    public function store(CandidatureRequest $request)
    {
        $candidature = $this->candidatureService->createCandidature(
            array_merge($request->validated(), ['candidate_id' => auth()->id()])
        );

        return (new CandidatureResource($candidature))->response()->setStatusCode(201);
    }

    public function getUserCandidatures()
    {
        $candidatures = $this->candidatureService->getUserCandidatures(auth()->id());
        return CandidatureResource::collection($candidatures);
    }

    public function delete($id)
    {
        if ($this->candidatureService->deleteCandidature($id)) {
            return response()->json([], 204);
        }

        return response()->json(['message' => 'Candidature not found.'], 404);
    }

    public function index()
    {
        $candidatures = $this->candidatureService->getAllCandidatures();
        return CandidatureResource::collection($candidatures);
    }

    public function show($id)
    {
        $candidature = $this->candidatureService->getCandidatureById($id);

        if (!$candidature) {
            return response()->json(['message' => 'Candidature not found.'], 404);
        }

        return new CandidatureResource($candidature);
    }

    public function updateStatus(Request $request, int $id){
        $candidature = $this->candidatureService->updateCandidatureStatus($id, $request->status);
        if (!$candidature) {
            return response()->json(['message' => 'Something went wrong while updating status.'], 500);
        }

        return response()->json([
            'message' => 'Status updated successfully!'
        ],200);
    }
}
