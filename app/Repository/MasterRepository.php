<?php

namespace App\Repository;

use App\Models\Categories;
use App\Models\Dishes;
use App\Models\EventTypes;
use App\Models\Units;
use App\Repository\Interface\MasterInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class MasterRepository implements MasterInterface
{
    // Dished
    public function dishesAdd(Request $request)
    {
        try {

            $dish = new Dishes();
            $dish->dish = $request->dish;
            $dish->category_id  = $request->category_id;
            $dish->rate = $request->rate;
            $dish->is_active = true;
            $dish->save();

            return $request;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function dishesRemove(Request $request)
    {
        try {
            $dish = Dishes::find($request->dish_id);

            if (isset($dish)) {

                $dish->delete();

                return "Remove Successfully";
            } else {
                return "not found dish data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function dishesModify(Request $request)
    {
        try {
            $dish = Dishes::find($request->dish_id);

            if (isset($dish)) {

                $dish->dish = $request->dish;
                $dish->category_id  = $request->category_id;
                $dish->rate = $request->rate;
                $dish->save();

                return "Modify Successfully";
            } else {
                return "Dish is not found";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    // Categories
    public function categoriesAdd(Request $request)
    {
        try {
            $categories = new Categories();
            $categories->name = $request->categories_name;
            $categories->is_active = true;
            $categories->save();

            if (isset($categories)) {
                return "Categories Add Successfuly";
            } else {
                return "not Save categories data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function categoriesRemove(Request $request)
    {
        try {
            $categories  = Categories::find($request->categories_id);

            if (isset($categories)) {
                $categories->delete();
                return "categories Remove";
            } else {
                return "not found categories";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function categoriesModify(Request $request)
    {
        try {
            $categories  = Categories::find($request->categories_id);

            if ($categories) {
                $categories->name = $request->categories_name;
                $categories->save();

                return "categories Modify";
            } else {
                return "categories not found";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    // Unit
    public function unitAdd(Request $request)
    {
        try {

            $unit = new Units();
            $unit->name = $request->name;
            $unit->symbol = $request->symbol;
            $unit->is_active = true;
            $unit->save();

            if (isset($unit)) {
                return "Unit Add";
            } else {
                return "not Add unit";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function unitRemove(Request $request)
    {
        try {
            $unit = Units::find($request->unit_id);
            if (isset($unit)) {
                $unit->delete();
                return "remove Successfully";
            } else {
                return "not found unit";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function unitModify(Request $request)
    {
        try {
            $unit = Units::find($request->unit_id);
            if (isset($unit)) {
                $unit->name = $reqeust->name;
                $unit->symbol = $reqeust->symbol;
                $unit->save();

                return "modify";
            } else {
                return "not found units";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }


    // Event type
    public function eventTypeAdd(Request $request)
    {
        try {
            $event_type = new EventTypes();
            $event_type->name = $request->event_name;
            $event_type->is_active = true;
            $event_type->save();

            if (isset($event_type)) {
                return "event type save successfully";
            } else {
                return "not save event type";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function eventTypeRemove(Request $request)
    {
        try {
            $event_type = EventTypes::find($request->event_type_id);

            if (isset($event_type)) {

                $event_type->delete();

                return "Remove Successfully";
            } else {
                return "not Remove Event Type Data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function eventTypeModify(Request $request)
    {
        try {
            $event_type = EventTypes::find($request->event_type_id);

            if (isset($event_type)) {
                $event_type->name = $request->event_type_name;
                $event_type->save();

                return "Modify Successfully";
            } else {
                return "not found event type data";
            }
            return $request;
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
