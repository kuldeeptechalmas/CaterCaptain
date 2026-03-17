<?php

namespace  App\Repository\Interface;

use Symfony\Component\HttpFoundation\Request;

interface PettyCashInterface
{
    public function pettyCashAdd(Request $request);
    public function pettyCashRemove(Request $request);
    public function pettyCashShowlist(Request $request);
    public function pettyCashSpend(Request $request);
    public function pettyCashSpendRemove(Request $request);
    public function pettyCashSpendList(Request $request);
}
