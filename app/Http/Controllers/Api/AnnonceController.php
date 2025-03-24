<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AnnonceService;
use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;
use App\Http\Resources\AnnonceResource;

class AnnonceController extends Controller
{
    private $annonceService;

    public function __construct(AnnonceService $annonceService)
    {
        $this->annonceService = $annonceService;
    }

    public function index()
    {
        return AnnonceResource::collection($this->annonceService->getAll());
    }

    public function show($id)
    {
        return new AnnonceResource($this->annonceService->getById($id));
    }

    public function store(StoreAnnonceRequest $request)
    {
        $validated = $request->validated();
        return (new AnnonceResource($this->annonceService->create($validated)))->response()->setStatusCode(201);
    }

    public function update(UpdateAnnonceRequest $request, $id)
    {
        $validated = $request->validated();
        return new AnnonceResource($this->annonceService->update($id, $validated));
    }

    public function destroy($id)
    {
        $this->annonceService->delete($id);
        return response()->json([], 204);
    }
}
