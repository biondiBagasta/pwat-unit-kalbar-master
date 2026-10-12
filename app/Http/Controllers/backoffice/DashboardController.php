<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Finances;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('backoffice.dashboard.index');
    }

    public function getFinanceChart(Request $request) {
        $startDate = $request["start_date"] ? Carbon::parse($request["start_date"]) : Carbon::now()->startOfMonth();
        $endDate = $request["end_date"] ? Carbon::parse($request["end_date"]) : Carbon::now()->endOfDay();

        $financeData = Finances::join(
            'finance_categories',
            'finances.finance_category_id',
            '=',
            'finance_categories.id'
        )->whereBetween("finances.finance_date", [
            $startDate,
            $endDate
        ])->select(
            DB::raw("DATE(finances.finance_date) as date"),
            "finance_categories.type",
            DB::raw("SUM(finances.amount) as total")
        )->groupBy(
            DB::raw("DATE(finances.finance_date)"),
            "finance_categories.type"
        )->orderBy('date')->get();

        // Generate semua tanggal dari tanggal 1 sampai hari ini
        $dates = [];

        $generatedDate = $startDate->copy();

        while($generatedDate->lte($endDate)) {
            $dates[] = $generatedDate->format("Y-m-d");

            $generatedDate->addDay();
        }

        // Buat Series
        $income = [];
        $expense = [];

        foreach($dates as $date) {
            $incomeData = $financeData->where("date", $date)->where("type", 1)->first();

            $expenseData = $financeData->where("date", $date)->where("type", 0)->first(); // ini

            $income[] = $incomeData ? (float) $incomeData->total : 0;
            $expense[] = $expenseData ? (float) $expenseData->total : 0;
        }

        $chartFinanceData = [
            [
                "name" => "Pemasukan",
                "data" => $income
            ],
            [
                "name" => "Pengeluaran",
                "data" => $expense
            ]
        ];

        return response()->json([
            "categories" => $dates,
            "start_date" => $startDate,
            "end_date" => $endDate,
            "data" => $chartFinanceData
        ]);
    }
}
