<?php

namespace App\Repository;

use App\Http\Requests\RawMaterialRequest;
use App\Models\Events;
use App\Models\MaterialRequestLines;
use App\Models\MaterialRequests;
use App\Models\RawMaterial;
use App\Models\RawMaterialMoment;
use App\Models\RawMaterialPrice;
use App\Repository\Interface\RawMaterialInterace;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class RawMaterialRepository implements RawMaterialInterace
{
    // Raw Material Add
    public function add(RawMaterialRequest $request)
    {
        try {
            $raw_material = new RawMaterial();
            $raw_material->name = $request->name;
            $raw_material->unit_id = $request->unit_id;
            $raw_material->location_id = 1;
            $raw_material->qty = $request->qty;
            $raw_material->min_qty = $request->minqty;
            $raw_material->is_active = true;
            $raw_material->save();

            $raw_material_moment = new RawMaterialMoment();
            $raw_material_moment->raw_material_id = $raw_material->id;
            $raw_material_moment->qty = $request->qty;
            if ($request->status == 'in') {
                $raw_material_moment->from_hq_id = 1;
                $raw_material_moment->to_hq_id = 1;
            }
            $raw_material_moment->status = $request->status;
            $raw_material_moment->note = $request->status;
            $raw_material_moment->unit_id = $request->unit_id;
            $raw_material_moment->save();

            return $raw_material . $raw_material_moment;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Raw Material Remove
    public function remove()
    {
        return "remove";
    }

    // Raw Material Modify 
    public function modify(RawMaterialRequest $request)
    {
        try {
            $raw_material_check = RawMaterial::where('name', $request->name)
                ->where('location_id', $request->location_id)
                ->where('is_active', true)
                ->first();
            $raw_material_check->is_active = false;
            $raw_material_check->save();

            $raw_material = new RawMaterial();
            $raw_material->name = $request->name;
            $raw_material->unit_id = $request->unit_id;
            $raw_material->location_id = $request->location_id;
            $raw_material->qty = $request->qty + $raw_material_check->qty;
            $raw_material->min_qty = $request->minqty;
            $raw_material->is_active = true;
            $raw_material->save();

            return $raw_material;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Raw Material Price Add - working
    public function rawMaterialPriceAdd(Request $request)
    {
        try {
            $get_raw_material = DB::table('raw_materials')
                ->where('raw_materials.name', $request->raw_material_name)
                ->where('raw_materials.is_active', true)
                ->first();

            if ($get_raw_material) {

                $raw_material_pricing = new RawMaterialPrice();
                $raw_material_pricing->raw_material_id = $request->raw_material_id;
                $raw_material_pricing->unit_id = $get_raw_material->unit_id;
                $raw_material_pricing->pricing_date = now();

                // correct unit wise price
                if ($get_raw_material->unit_id == 1) {
                    $raw_material_pricing->price_kg = $request->price;
                } elseif ($get_raw_material->unit_id == 2) {
                    $raw_material_pricing->price_unit = $request->price;
                } elseif ($get_raw_material->unit_id == 3) {
                    $raw_material_pricing->price_litre = $request->price;
                } elseif ($get_raw_material->unit_id == 4) {
                    $raw_material_pricing->price_piece = $request->price;
                }

                $raw_material_pricing->save();

                return $raw_material_pricing;
            }

            return response()->json([
                'status' => false,
                'message' => 'Raw material not found'
            ]);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Show Raw Material List
    public function showRawMaterialList(Request $request)
    {
        try {

            $raw_material_list = RawMaterial::where('name', $request->material_name)
                ->where('location_id', $request->location_id)
                ->where('is_active', true)
                ->get();

            if ($raw_material_list->count() > 0) {
                return $raw_material_list;
            } else {
                return "not found data";
            }
        } catch (Exception $ex) {
            return "Raw Material Repository in showRawMaterialList function error";
        }
    }

    public function rawMaterialMoments(Request $request)
    {
        try {
            $raw_material_data = RawMaterial::where('name', $request->raw_material_name)
                ->where('unit_id', $request->unit_id)
                ->first();

            if ($raw_material_data->isNotEmpty() && $raw_material_data->qty >= $request->qty) {
                // Raw Material Moment
                $raw_material_moment = new RawMaterialMoment();
                $raw_material_moment->raw_material_id = $raw_material_data->id;
                $raw_material_moment->qty = $request->qty;
                if ($request->status == 'transfer' && $request->to_kitchen_id != 0) {

                    $raw_material_moment->from_hq_id = 1;
                    $raw_material_moment->to_kitchen_id = $request->to_kitchen_id;

                    $raw_material_data->qty = $raw_material_data->qty - $request->qty;
                    $raw_material_data->save();
                } elseif ($request->status == 'in') {

                    $raw_material_data->qty = $raw_material_data->qty + $request->qty;
                    $raw_material_data->save();
                } elseif ($request->status == 'wast') {

                    $raw_material_data->qty = $raw_material_data->qty - $request->qty;
                    $raw_material_data->save();
                }
                $raw_material_moment->status = $request->status;
                $raw_material_moment->note = $request->note;
                $raw_material_moment->unit_id = $request->unit_id;
                $raw_material_moment->save();

                return "Raw Material Moment done";
            } else {
                return "Your Requirement is to High";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function rawMaterialRequest(Request $request)
    {
        try {
            $request_date = Carbon::parse($request->request_date);

            $raw_material_request = new MaterialRequests();
            $raw_material_request->kitchen_id = $request->kitchen_id;
            $raw_material_request->request_date = now();
            $raw_material_request->status = "pending";
            $raw_material_request->item_count = count($request->raw_materials);
            $raw_material_request->created_by = $request->created_by;
            $raw_material_request->save();

            if (isset($raw_material_request)) {

                foreach ($request->raw_materials as $item) {

                    $material_request_lines = new MaterialRequestLines();
                    $material_request_lines->material_request_id = $raw_material_request->id;
                    $material_request_lines->raw_material_id = $item["raw_material_id"];
                    $material_request_lines->qty_requested = $item["qty_requested"];
                    $material_request_lines->save();
                }

                return $material_request_lines;
            } else {
                return "not found raw material";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
