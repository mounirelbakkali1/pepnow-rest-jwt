<?php

namespace App\Http\Controllers;

use App\Models\Plante;
use App\Http\Requests\StorePlanteRequest;
use App\Http\Requests\UpdatePlanteRequest;
use function response;

class PlanteController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'all plants',
            'data' => Plante::all()
        ], 200);
    }




    public function store(StorePlanteRequest $request)
    {
        $validated_plante = $request->validated();
        $plante = Plante::create($validated_plante);
        return response()->json([
            'status' => 'success',
            'message' => 'plante created',
            'data' => $plante
        ], 201);

    }


    public function show($plante)
    {
        $plante = Plante::find($plante);
        if ($plante) {
            return response()->json([
                'status' => 'success',
                'message' => 'plante found',
                'data' => $plante
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'plante not found',
                'data' => null
            ], 404);
        }
    }




    public function update(UpdatePlanteRequest $request, Plante $plante)
    {
        //
    }


    public function destroy(Plante $plante)
    {
        //
    }
}
