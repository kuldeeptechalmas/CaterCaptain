<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repository\EventRepository;
use App\Repository\RawMaterialRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $Repo;

    public function __construct(EventRepository $Repo)
    {
        $this->Repo = $Repo;
    }

    // Add Event Data
    public function eventAddInfo(Request $request)
    {
        $data = $this->Repo->eventAddData($request);
        return $data;
    }

    // Event Service Data
    public function eventServiceInfo(Request $request)
    {
        $data = $this->Repo->eventServiceAdd($request);
        return $data;
    }

    // Event Service Remove
    public function eventServiceRemove($id)
    {
        $data = $this->Repo->eventServiceRemove($id);
        return $data;
    }

    // Event Raw Material
    public function eventRawMaterial(Request $request)
    {
        $data = $this->Repo->eventRawMaterial($request);
        return $data;
    }

    // Wastage Raw Material 
    public function wastageRawMaterial(Request $request)
    {
        $data = $this->Repo->wasteageRawMaterial($request);
        return $data;
    }

    // Event Manu Item
    public function eventMenuItems(Request $request)
    {
        $data = $this->Repo->eventMenuItems($request);
        return $data;
    }
}
