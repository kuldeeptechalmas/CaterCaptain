<?php

namespace App\Repository\Interface;

use Symfony\Component\HttpFoundation\Request;

interface EventInterface
{
    public function eventAddData(Request $request);
    public function eventServiceAdd(Request $request);
    public function eventServiceRemove($id);
    public function eventRawMaterial(Request $request);
    public function wasteageRawMaterial(Request $request);
    public function eventMenuItems(Request $request);
}
