<?php

namespace App\Repository\Interface;

use Symfony\Component\HttpFoundation\Request;

interface MasterInterface
{
    // Dished
    public function dishesAdd(Request $request);
    public function dishesRemove(Request $request);
    public function dishesModify(Request $request);

    // Categories
    public function categoriesAdd(Request $request);
    public function categoriesRemove(Request $request);
    public function categoriesModify(Request $request);

    // Unit
    public function unitAdd(Request $request);
    public function unitRemove(Request $request);
    public function unitModify(Request $request);

    // Event type
    public function eventTypeAdd(Request $request);
    public function eventTypeRemove(Request $request);
    public function eventTypeModify(Request $request);
}
