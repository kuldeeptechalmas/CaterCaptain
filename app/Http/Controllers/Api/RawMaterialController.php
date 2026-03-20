<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RawMaterialRequest;
use App\Models\RawMaterial;
use App\Repository\RawMaterialRepository;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    protected $Repo;

    public function __construct(RawMaterialRepository $Repo)
    {
        $this->Repo = $Repo;
    }

    // Raw Material Add
    public function rawMaterialAdd(RawMaterialRequest $request)
    {
        $raw_material_check = RawMaterial::where('name', $request->name)
            ->where('location_id', $request->location_id)
            ->where('is_active', true)
            ->first();

        $data = $this->Repo->add($request);
        if (!empty($data)) {

            return response()->json([
                "status" => true,
                "message" => "Add Raw material Successfull",
                "rawmaterial" => $data
            ]);
        } else {

            return response()->json([
                "status" => false,
                "message" => "Not Add Raw material",
            ]);
        }
    }

    // Raw Materila Price Add - working
    public function rawMaterialPriceAdd(Request $request)
    {
        $data = $this->Repo->rawMaterialPriceAdd($request);
        return $data;
    }

    // Raw Material Moments
    public function rawMaterialMoments(Request $request)
    {
        $data = $this->Repo->rawMaterialMoments($request);
        return $data;
    }

    // Show Raw Material List 
    public function showRawMaterialList(Request $request)
    {
        $data = $this->Repo->showRawMaterialList($request);
        return $data;
    }

    // Raw Material Request
    public function rawMaterialRequest(Request $request)
    {
        $result = $this->Repo->rawMaterialRequest($request);
        return $result;
    }

    // Raw Material Request Decision
    public function rawMaterialRequestDecision(Request $request)
    {
        $result = $this->Repo->rawMaterialRequestDecision($request);
        return $result;
    }

    public function RawMaterialStock(Request $request)
    {
        $result = $this->Repo->RawMaterialStock($request);
        return $result;
    }
}
