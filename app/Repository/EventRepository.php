<?php

namespace App\Repository;

use App\Models\Dishes;
use App\Models\EventMenuItems;
use App\Models\Events;
use App\Models\EventServices;
use App\Models\RawMaterial;
use App\Models\WastageEntries;
use App\Repository\Interface\EventInterface;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class EventRepository implements EventInterface
{

    // Event Add Data
    public function eventAddData(Request $request)
    {
        try {

            $events = new Events();
            $events->name = $request->event_name;
            $events->event_type_id = $request->event_type;
            $events->schedule_type = $request->event_schedule;
            $events->start_date = now();
            $events->end_date = now();
            $events->start_datetime = now();
            $events->kitchen_id = $request->kitchen_id;
            $events->client_name = $request->client_name;
            $events->client_email = $request->client_email;
            $events->client_phone = $request->client_phone;
            $events->client_address = $request->client_address;
            $events->is_active = false;
            $events->save();

            return $events;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Event Service Add
    public function eventServiceAdd(Request $request)
    {
        try {
            $event_service = new EventServices();
            $event_service->event_id = $request->event_id;
            $event_service->service_type = $request->service_type;
            $event_service->guest_count = $request->guest_count;
            $event_service->start_datetime = now();
            $event_service->save();

            if ($event_service) {
                return $event_service;
            } else {
                return "not Add data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Event Service Remove
    public function eventServiceRemove($id)
    {
        try {
            $event_service_find = EventServices::find($id);
            if (isset($event_service_find)) {
                $event_service_find->delete();
                return "remove " . $id;
            } else {
                return "not remove " . $id;
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Event Raw Material
    public function eventRawMaterial(Request $request)
    {
        try {
            $raise_requirement = $request->event_qty;
            $raw_material_raise = RawMaterial::where("name", $request->raw_material_name)
                ->where('location_id', $request->kitchne_id)
                ->where('is_active', true)
                ->first();

            if (!empty($raw_material_raise)) {


                if ($raw_material_raise->qty >= $raise_requirement) {

                    $raw_material_raise->is_active = false;
                    $raw_material_raise->save();

                    $raw_material = new RawMaterial();
                    $raw_material->name = $raw_material_raise->name;
                    $raw_material->unit_id = $raw_material_raise->unit_id;
                    $raw_material->location_id = $raw_material_raise->location_id;
                    $raw_material->qty = $raise_requirement;
                    $raw_material->min_qty = $raw_material_raise->min_qty;
                    $raw_material->is_active = false;
                    $raw_material->save();

                    $raw_material2 = new RawMaterial();
                    $raw_material2->name = $raw_material_raise->name;
                    $raw_material2->unit_id = $raw_material_raise->unit_id;
                    $raw_material2->location_id = $raw_material_raise->location_id;
                    $raw_material2->qty = $raw_material_raise->qty - $raise_requirement;
                    $raw_material2->min_qty = $raw_material_raise->min_qty;
                    $raw_material2->is_active = true;
                    $raw_material2->save();


                    $Current_raw_material_raise = RawMaterial::where('name', 'Raise')
                        ->where('is_active', true)
                        ->first();
                    if (!empty($Current_raw_material_raise)) {
                        return  $Current_raw_material_raise;
                    } else {
                        return "not found current raw meterial raise";
                    }
                } else {
                    return "you requirement is so high";
                }
            } else {
                return "not found record";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    // Wasteage Raw Material
    public function wasteageRawMaterial(Request $request)
    {
        try {
            $raise_requirement = $request->qty;
            $raw_material_raise = RawMaterial::where("name", $request->material)
                ->where('location_id', $request->kitchen)
                ->where('is_active', true)
                ->first();


            if (!empty($raw_material_raise)) {

                if ($raw_material_raise->qty >= $raise_requirement) {

                    $raw_material_raise->is_active = false;
                    $raw_material_raise->save();

                    $raw_material = new RawMaterial();
                    $raw_material->name = $raw_material_raise->name;
                    $raw_material->unit_id = $raw_material_raise->unit_id;
                    $raw_material->location_id = $raw_material_raise->location_id;
                    $raw_material->qty = $raise_requirement;
                    $raw_material->min_qty = $raw_material_raise->min_qty;
                    $raw_material->is_active = false;
                    $raw_material->save();

                    $raw_material2 = new RawMaterial();
                    $raw_material2->name = $raw_material_raise->name;
                    $raw_material2->unit_id = $raw_material_raise->unit_id;
                    $raw_material2->location_id = $raw_material_raise->location_id;
                    $raw_material2->qty = $raw_material_raise->qty - $raise_requirement;
                    $raw_material2->min_qty = $raw_material_raise->min_qty;
                    $raw_material2->is_active = true;
                    $raw_material2->save();


                    $Current_raw_material_raise = RawMaterial::where('name', 'Raise')
                        ->where('is_active', true)
                        ->first();

                    $wastage_raw_material = new WastageEntries();
                    $wastage_raw_material->kitchen_id = $request->kitchen;
                    $wastage_raw_material->raw_material_id = $raw_material->id;
                    $wastage_raw_material->unit_id = $request->unit;
                    $wastage_raw_material->qty = $request->qty;
                    $wastage_raw_material->wastage_date = now();
                    $wastage_raw_material->reason = $request->reason;
                    $wastage_raw_material->note = $request->note;
                    $wastage_raw_material->created_by = 1;
                    $wastage_raw_material->save();

                    return $wastage_raw_material;
                } else {
                    return "your requirement is high";
                }
            } else {
                return "not found data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public function eventMenuItems(Request $request)
    {
        try {
            $dish_rate = Dishes::find($request->dish_id);

            if ($dish_rate) {
                $event_menu_item = new EventMenuItems();
                $event_menu_item->event_service_id = $request->event_service_id;
                $event_menu_item->dish_id = $request->dish_id;
                $event_menu_item->qty = $request->qty;
                $event_menu_item->rate = $dish_rate->rate;
                $event_menu_item->save();
                return $event_menu_item;
            } else {
                return "dish data is not found";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
