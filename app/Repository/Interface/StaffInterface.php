<?php

namespace App\Repository\Interface;

use Illuminate\Http\Request;

interface StaffInterface
{
    public function staffAdd(Request $request);
    public function staffModify(Request $request);
    public function staffRemove(int $id);
}
