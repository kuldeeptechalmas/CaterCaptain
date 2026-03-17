<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repository\StaffRepository;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected $Repo;

    public function __construct(StaffRepository $Repo)
    {
        $this->Repo = $Repo;
    }
    public function staffAdd(Request $request)
    {
        $result = $this->Repo->staffAdd($request);
        if ($result) {
            return [
                "result" => "Add Staff Successfully",
                "Data" => $result
            ];
        } else {
            return ["result" => "Not Add Staff !!!"];
        }
    }

    public function staffModify(Request $request)
    {
        $result = $this->Repo->staffModify($request);
        if ($result) {
            return [
                "result" => "Modify Staff Successfully",
                "Data" => $result
            ];
        } else {
            return ["result" => "Not Modify Staff !!!"];
        }
    }

    public function staffRemove(Request $request)
    {
        $result = $this->Repo->staffRemove($request->staff_id);
        if ($result) {
            return ["result" => "Remove Staff Successfully"];
        } else {
            return ["result" => "Not Modify Staff !!!"];
        }
    }
}
