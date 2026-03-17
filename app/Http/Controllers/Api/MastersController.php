<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repository\MasterRepository;
use Illuminate\Http\Request;

class MastersController extends Controller
{
    protected $Repo;

    public function __construct(MasterRepository $Repo)
    {
        $this->Repo = $Repo;
    }

    //Dished - Add
    public function dishesAdd(Request $request)
    {
        return $this->Repo->dishesAdd($request);
    }

    public function dishesRemove(Request $request)
    {
        return $this->Repo->dishesRemove($request);
    }
    public function dishesModify(Request $request)
    {
        return $this->Repo->dishesModify($request);
    }


    //Categories - Add
    public function categoriesAdd(Request $request)
    {
        return $this->Repo->categoriesAdd($request);
    }

    public function categoriesRemove(Request $request)
    {
        return $this->Repo->categoriesRemove($request);
    }
    public function categoriesModify(Request $request)
    {
        return $this->Repo->categoriesModify($request);
    }


    //Categories - Add
    public function unitAdd(Request $request)
    {
        return $this->Repo->unitAdd($request);
    }

    public function unitRemove(Request $request)
    {
        return $this->Repo->unitRemove($request);
    }
    public function unitModify(Request $request)
    {
        return $this->Repo->unitModify($request);
    }


    //Event Type - Add
    public function eventTypeAdd(Request $request)
    {
        return $this->Repo->eventTypeAdd($request);
    }

    public function eventTypeRemove(Request $request)
    {
        return $this->Repo->eventTypeRemove($request);
    }
    public function eventTypeModify(Request $request)
    {
        return $this->Repo->eventTypeModify($request);
    }
}
