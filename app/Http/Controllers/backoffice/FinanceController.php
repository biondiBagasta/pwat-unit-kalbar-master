<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceRequest;
use App\Models\Balances;
use App\Models\FinanceCategories;
use App\Models\Finances;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request) {

        $pageTake = 20;

        $currentPage = (int) ($request->query("page") ?? 1);

        $finance_category_id = (int) ($request->query("finance-category-id"));

        $start_date = $request->query("start-date") ?? Carbon::now();
        $end_date = $request->query("end-date") ?? Carbon::now();

        $count = Finances::where("finance_date", ">=", $start_date)
        ->where("finance_date", "<=", $end_date)
        ->count();

        $totalPage =  round(($count / $pageTake) + 0.4);

        $data = Finances::with("finance_category")
        ->where("finance_date", ">=", $start_date)
        ->where("finance_date", "<=", $end_date)
        ->get();

        // Bagian Data User Roles
        $finance_categories_data = FinanceCategories::orderBy("name", "asc")->get();

        // Balance Data
        $balance = Balances::find(1);

        return view("backoffice.finance.index",
        [
            "data" => $data,
            "finance_categories_data" => $finance_categories_data,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "start_date" => $start_date,
            "end_date" =>  $end_date,
            "balance" => $balance
        ]);
    }

    public function create(FinanceRequest $request) {
        // Lakukan dengan DB Transaction
        DB::beginTransaction();
        try {
            $model = new Finances;

            $finance_category_data = FinanceCategories::find($request["finance_category_id"]);

            $balance = Balances::find(1);

            $amount = $request["amount"];

            // Check Jika tidak Sengaja Menyebabkan Minus
            if($finance_category_data->type == 0 && $amount > $balance->total) {
                return ApiResponse::errorResponse("Pengeluaran tidak boleh lebih besar dari Current Balance.");
            } else {
                // Logic jika pengeluaran atau pemasukan
                if($finance_category_data->type == 1) {
                    $new_balance = $balance->total + $amount;
                } else {
                    $new_balance = $balance->total - $amount;
                }

                // Save Data Finance
                $model->amount = $amount;
                $model->current_balance = $new_balance;
                $model->finance_date = $request["finance_date"];
                $model->notes = $request["notes"];
                $model->finance_category_id = $request["finance_category_id"];

                $model->save();

                // Update Data Balance
                $balance->total = $new_balance;
                $balance->save();

                // Commit Transaction
                DB::commit();

                session()->flash("create", "Data Finance Berhasil Ditambahkan.");

                return ApiResponse::successResponse("");
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            return ApiResponse::errorResponse("Gagal Membuat Data Finance : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Finances::find($id);

        return response()->json($data);
    }

    public function update(FinanceRequest $request, $id) {

        // Lakukan dengan DB Transaction
        DB::beginTransaction();
        try {
            $model = Finances::find($id);

            $finance_category_data = FinanceCategories::find($request["finance_category_id"]);

            $balance = Balances::find(1);

            $amount = $request["amount"];

            // Check Type Apakah Pengeluaran atau Pemasukan
            if($finance_category_data->type == 1) {
                $previous_balance = $balance->total - $model->amount;
            } else {
                $previous_balance = $balance->total + $model->amount;
            }

            // Check Jika tidak Sengaja Menyebabkan Minus
            if($finance_category_data->type == 0 && $amount > $previous_balance) {
                return ApiResponse::errorResponse("Pengeluaran tidak boleh lebih besar dari Current Balance.");
            } else {
                // Logic jika pengeluaran atau pemasukan
                if($finance_category_data->type == 1) {
                    $new_balance = $previous_balance + $amount;
                } else {
                    $new_balance = $previous_balance - $amount;
                }

                // Update Data Finance
                $model->amount = $amount;
                $model->current_balance = $new_balance;
                $model->finance_date = $request["finance_date"];
                $model->notes = $request["notes"];
                $model->finance_category_id = $request["finance_category_id"];

                $model->save();

                // Update Data Balance
                $balance->total = $new_balance;
                $balance->save();

                // Commit Transaction
                DB::commit();

                session()->flash("create", "Data Finance Berhasil Ditambahkan.");

                return ApiResponse::successResponse("");
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            return ApiResponse::errorResponse("Gagal Membuat Data Finance : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        DB::beginTransaction();
        try {
            $model = Finances::find($id);
            $balance = Balances::find(1);
            $finance_category_data = FinanceCategories::find($model->finance_category_id);

            // Kembalikan Balance
            if($finance_category_data->type == 1) {
                // Jika Tipenya Pemasukan
                $balance->total = $balance->total - $model->amount;

                $balance->save();
            } else {
                // Jika Tipenya Pengeluaran
                $balance->total = $balance->total + $model->amount;

                $balance->save();
            }

            // Delete Data Finance
            $model->delete();

            DB::commit();

            session()->flash("delete", "Data Finance Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            DB::rollBack();
            return ApiResponse::errorResponse("Gagal Menghapus Data Finance : {$e->getMessage()}");
        }
    }
}
