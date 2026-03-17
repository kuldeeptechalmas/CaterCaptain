<?php

namespace App\Repository\Interface;

use App\Http\Requests\RawMaterialRequest;
use Symfony\Component\HttpFoundation\Request;

interface RawMaterialInterace
{
    public function add(RawMaterialRequest $request);
    public function remove();
    public function modify(RawMaterialRequest $request);
    public function rawMaterialPriceAdd(Request $request);
    public function showRawMaterialList(Request $request);
    public function rawMaterialMoments(Request $request);

    // Raw Material Request Other Kitchen
    public function rawMaterialRequest(Request $request);
}
