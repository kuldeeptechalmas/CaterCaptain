<?php

namespace App\Repository;

use App\Models\PettyCashIssues;
use App\Models\PettyCashSpends;
use App\Repository\Interface\PettyCashInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class PettyCashRepository implements PettyCashInterface
{

    public function pettyCashDashboard(Request $request)
    {
        try {
            $totalIssue = DB::table('petty_cash_issues')
                ->whereNull('deleted_at')
                ->sum('amount');

            $totalSpend = DB::table('petty_cash_spends')
                ->whereNull('deleted_at')
                ->sum('amount');

            $balance = $totalIssue - $totalSpend;

            return response()->json([
                'total_issue' => $totalIssue,
                'total_spend' => $totalSpend,
                'balance' => $balance
            ]);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function pettyCashAdd(Request $request)
    {
        try {
            $petty_cash_issue = new PettyCashIssues();
            $petty_cash_issue->captain_id = $request->captain_id;
            $petty_cash_issue->amount = $request->amount;
            $petty_cash_issue->issue_date = $request->date;
            $petty_cash_issue->created_by = $request->created_by;
            $petty_cash_issue->save();

            return $petty_cash_issue;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function pettyCashRemove(Request $request)
    {
        try {
            $issue = PettyCashIssues::find($request->cash_issue_id);
            if (isset($issue)) {
                $issue->delete();
                return "Delete Successfully";
            } else {
                return "not found petty cash";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function pettyCashShowlist(Request $request)
    {
        try {
            $petty_cash = PettyCashIssues::all();
            return $petty_cash;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function pettyCashSpend(Request $request)
    {
        try {
            $spends = new PettyCashSpends();
            $spends->captain_id = $request->captain_id;
            $spends->amount = $request->amount;
            $spends->note = $request->note;
            $spends->spend_date = now();
            $spends->bill_photo = $request->image_name;
            $spends->save();

            return $spends;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function pettyCashSpendList(Request $request)
    {
        try {

            $spend_list = PettyCashSpends::all();
            if (!empty($spend_list)) {
                return $spend_list;
            } else {
                return "petty Cash Spend List Not found Data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function pettyCashSpendRemove(Request $request)
    {
        try {
            $spend = PettyCashSpends::find($request->cash_spend_id);
            if (isset($spend)) {
                $spend->delete();
                return "Delete Successfully";
            } else {
                return "not found petty cash spend data";
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
