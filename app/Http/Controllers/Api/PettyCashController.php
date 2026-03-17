<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\PettyCashRepository;
use Illuminate\Http\Request;

class PettyCashController extends Controller
{
    protected $Repo;
    public function __construct(PettyCashRepository $Repo)
    {
        $this->Repo = $Repo;
    }
    public function pettyCashDashboard(Request $request)
    {
        $data = $this->Repo->pettyCashDashboard($request);
        return $data;
    }
    public function pettyCashAdd(Request $request)
    {
        $data = $this->Repo->pettyCashAdd($request);
        return $data;
    }
    public function pettyCashRemove(Request $request)
    {
        $data = $this->Repo->pettyCashRemove($request);
        return $data;
    }

    public function pettyCashShowList(Request $request)
    {
        $data = $this->Repo->pettyCashShowlist($request);
        return $data;
    }
    public function pettyCashSpend(Request $request)
    {
        return $this->Repo->pettyCashSpend($request);
    }
    public function pettyCashSpendRemove(Request $request)
    {
        return $this->Repo->pettyCashSpendRemove($request);
    }
    public function pettyCashSpendList(Request $request)
    {
        return $this->Repo->pettyCashSpendList($request);
    }
}
