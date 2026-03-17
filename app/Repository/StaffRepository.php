<?php

namespace App\Repository;

use App\Models\Staff;
use App\Repository\Interface\StaffInterface;
use Exception;
use Illuminate\Http\Request;

class StaffRepository implements StaffInterface
{
    public function staffAdd(Request $request)
    {
        try {
            $staff = new Staff();
            $staff->name = $request->name;
            $staff->staff_role_id  = $request->role;
            $staff->phone  = $request->mobile;
            $staff->email = $request->email;
            $staff->address = $request->address;
            $staff->salary_type = $request->salary_type;
            $staff->rate = $request->salary_amount;
            $staff->is_active  = true;
            $staff->save();

            return $staff;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function staffModify(Request $request)
    {
        try {

            $check_staff = Staff::find($request->staff_id);
            if ($check_staff) {

                $check_staff->name = $request->name;
                $check_staff->staff_role_id  = $request->role;
                $check_staff->phone  = $request->mobile;
                $check_staff->email = $request->email;
                $check_staff->address = $request->address;
                $check_staff->salary_type = $request->salary_type;
                $check_staff->rate = $request->salary_amount;
                $check_staff->save();

                return $check_staff;
            } else {
                return "Not Exist Staff Member";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function staffRemove(int $id)
    {
        try {
            $check_staff = Staff::find($id);
            if ($check_staff) {
                $check_staff->delete();
                return $id;
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
