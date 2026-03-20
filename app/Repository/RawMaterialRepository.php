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
            $raw_material_check = RawMaterial::where('name', $request->name)
                ->where('location_id', 0)
                ->where('is_active', true)
                ->first();

            if (isset($raw_material_check)) {

                return "Raw material already exists";
            } else {

                $raw_material = new RawMaterial();
                $raw_material->name = $request->name;
                $raw_material->unit_id = $request->unit_id;
                $raw_material->hq_id = 1;
                $raw_material->location_id = 0;
                $raw_material->qty = $request->qty;
                $raw_material->min_qty = $request->minqty;
                $raw_material->is_active = true;
                $raw_material->save();

                if (isset($raw_material)) {


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

                    return $raw_material_moment;
                } else {
                    return "Not Add Raw material";
                }
            }
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

            if ($raw_material_data->qty >= $request->qty) {

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
            $raw_material_request->created_by = $request->user()->id;
            $raw_material_request->save();

            if (isset($raw_material_request)) {

                foreach ($request->raw_materials as $item) {

                    $material_request_lines = new MaterialRequestLines();
                    $material_request_lines->material_request_id = $raw_material_request->id;
                    $material_request_lines->raw_material_id = $item["raw_material_id"];
                    $material_request_lines->qty_requested = $item["qty_requested"];
                    $material_request_lines->save();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Raw material request submitted successfully',
                    'data' => $raw_material_request
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to submit raw material request'
                ], 400);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function rawMaterialRequestDecision(Request $request)
    {
        try {

            $material_request = MaterialRequests::find($request->material_requests_id);

            if ($request->decision == 'approve') {

                $material_request->status = 'approved';
                $material_request->save();

                $request_status = 'approved';
            } elseif ($request->decision == 'dispatch') {

                $material_request_lines = $request->material_request_lines;

                foreach ($material_request_lines as $material_request_line) {

                    // Material Reqeust Line Data
                    $material_request_line_data = MaterialRequestLines::find($material_request_line["id"]);
                    $material_request_line_data->qty_approved = $material_request_line["qty_approved"];

                    // Raw Material Data
                    $raw_material_data = RawMaterial::where('id', $material_request_line_data->raw_material_id)->select('unit_id', 'qty')->first();

                    if ($raw_material_data->qty > $material_request_line["qty_approved"]) {


                        $price_unit_name = '';
                        if ($raw_material_data->unit_id == 1) {
                            $price_unit_name = "price_kg";
                        } elseif ($raw_material_data->unit_id == 2) {
                            $price_unit_name = "price_unit";
                        } elseif ($raw_material_data->unit_id == 3) {
                            $price_unit_name = "price_litre";
                        } elseif ($raw_material_data->unit_id == 4) {
                            $price_unit_name = "price_piece";
                        }

                        // Price Unit Name
                        $raw_material_data_price = RawMaterialPrice::where('raw_material_id', $material_request_line_data->raw_material_id)
                            ->select($price_unit_name)
                            ->first();


                        $material_request_line_data->rate = $raw_material_data_price->$price_unit_name;
                        $material_request_line_data->amount = $raw_material_data_price->$price_unit_name * $material_request_line_data->qty_approved;
                        $material_request_line_data->save();


                        if (isset($material_request_line_data)) {
                            $raw_material_datas = RawMaterial::find($material_request_line_data->raw_material_id);

                            $raw_material_moment = new RawMaterialMoment();
                            $raw_material_moment->raw_material_id = $raw_material_datas->id;
                            $raw_material_moment->qty = $material_request_line["qty_approved"];

                            $raw_material_moment->from_hq_id = 1;
                            $raw_material_moment->to_kitchen_id = $material_request->kitchen_id;

                            $raw_material_datas->qty = $raw_material_datas->qty - $material_request_line["qty_approved"];
                            $raw_material_datas->save();

                            $raw_material_moment->status = 'transfer';
                            $raw_material_moment->note = 'transfer';
                            $raw_material_moment->unit_id = $raw_material_datas->unit_id;
                            $raw_material_moment->save();

                            // New Kitchen Raw Material Data
                            $raw_material_kitchen_data = new RawMaterial();
                            $raw_material_kitchen_data->name = $raw_material_datas->name;
                            $raw_material_kitchen_data->unit_id = $raw_material_datas->unit_id;
                            $raw_material_kitchen_data->hq_id = 0;
                            $raw_material_kitchen_data->location_id = $material_request->kitchen_id;
                            $raw_material_kitchen_data->qty = $material_request_line["qty_approved"];
                            $raw_material_kitchen_data->min_qty = $raw_material_datas->min_qty;
                            $raw_material_kitchen_data->is_active = true;
                            $raw_material_kitchen_data->save();

                            if (isset($raw_material_kitchen_data)) {

                                // Raw Material Moment for Kitchen
                                $raw_material_moment = new RawMaterialMoment();
                                $raw_material_moment->raw_material_id = $raw_material_kitchen_data->id;
                                $raw_material_moment->qty = $material_request_line["qty_approved"];

                                $raw_material_moment->from_hq_id = 0;
                                $raw_material_moment->to_hq_id = $material_request->kitchen_id;

                                $raw_material_moment->status = 'in';
                                $raw_material_moment->note = 'in';
                                $raw_material_moment->unit_id = $raw_material_datas->unit_id;
                                $raw_material_moment->save();

                                // Raw Material Price for Kitchen
                                $get_raw_material = RawMaterial::find($raw_material_kitchen_data->id);

                                if ($get_raw_material) {

                                    $raw_material_pricing = new RawMaterialPrice();
                                    $raw_material_pricing->raw_material_id = $raw_material_kitchen_data->id;
                                    $raw_material_pricing->unit_id = $get_raw_material->unit_id;
                                    $raw_material_pricing->pricing_date = now();

                                    // Correct Unit Wise Price
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
                                } else {
                                    return "Not found raw material data ";
                                }
                            } else {
                                return "Not found raw material kitchen data ";
                            }
                        } else {
                            return "Not found raw material line data ";
                        }
                    } else {
                        return "Not enough stock for raw material ID: " . $material_request_line_data->raw_material_id;
                    }
                }

                $material_request->status = 'dispatched';
                $material_request->save();

                $request_status = 'dispatched';
            } elseif ($request->decision == 'reviewed') {

                $material_request->status = 'reviewed';
                $material_request->save();

                $request_status = 'reviewed';
            } elseif ($request->decision == 'reject') {

                $request_status = 'rejected';
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid decision value'
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Material request decision recorded successfully',
                'request_status' => $request_status
            ]);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function RawMaterialStock(Request $request)
    {
        try {
            $raw_material_stock = RawMaterial::where('location_id', $request->location_id)
                ->where('is_active', true)
                ->get();

            // ->where('name', $request->raw_material_name)
            // ->leftJoin('raw_material_moment', 'raw_materials.id', '=', 'raw_material_moment.raw_material_id')

            return $raw_material_stock;
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
