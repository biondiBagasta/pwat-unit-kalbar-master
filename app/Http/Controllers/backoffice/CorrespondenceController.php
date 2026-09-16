<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CorrespondenceRequest;
use App\Models\CorrespondenceAttachments;
use App\Models\CorrespondenceCategories;
use App\Models\Correspondences;
use App\Models\Members;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CorrespondenceController extends Controller
{
    private static $monthRoman = [
        1  => 'I',
        2  => 'II',
        3  => 'III',
        4  => 'IV',
        5  => 'V',
        6  => 'VI',
        7  => 'VII',
        8  => 'VIII',
        9  => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    public function index(Request $request) {

        $pageTake = 20;

        $term = $request->query("term") ?? "";

        $currentPage = (int) ($request->query("page") ?? 1);

        $count = Correspondences::where(
        function ($q) use($term) {
            $q->whereHas("correspondence_category", function($q2) use($term) {
                $q2->where("name", "like", "%{$term}%");
            })->orWhereHas("recepient_data", function ($q2) use($term) {
                $q2->where("full_name", "like", "%{$term}%");
            });
        })->count();

        $totalPage = ceil(($count / $pageTake) + 0.4);

        $data = Correspondences::with("correspondence_category",
        "sender_data", "recepient_data")->where(
        function ($q) use($term) {
            $q->whereHas("correspondence_category", function($q2) use($term) {
                $q2->where("name", "like", "%{$term}%");
            })->orWhereHas("recepient_data", function ($q2) use($term) {
                $q2->where("full_name", "like", "%{$term}%");
            });
        })->take($pageTake)
        ->skip(($currentPage - 1) * $pageTake)->get();

        $correspondence_categories_data = CorrespondenceCategories::orderBy("name", "asc")->get();

        $members_data = Members::orderBy("full_name", "asc")->get();


        return view("backoffice.correspondence.index",
        [
            "data" => $data,
            "correspondence_categories_data" => $correspondence_categories_data,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "term" => $term,
            "members_data" => $members_data
        ]);
    }

    public function create(CorrespondenceRequest $request) {
        // Lakukan dengan DB Transaction
        DB::beginTransaction();
        try {
            $model = new Correspondences;

            $model->subject = $request["subject"];
            $model->content = $request["content"];
            $model->recepient = $request["recepient"];
            $model->letter_date = $request["letter_date"];
            $model->sender = Auth::user()->member->id;

            $model->correspondence_category_id = $request["correspondence_category_id"];

            // Buat Nomor Surat Logic
            $count_data_today = Correspondences::whereDate('created_at', now())->count();
            $month = self::$monthRoman[now()->month];
            $year = now()->year;

            $correspondence_category_data =
            CorrespondenceCategories::find($request["correspondence_category_id"]);

            $number = str_pad($count_data_today + 1, 3, '0', STR_PAD_LEFT);

            $letterNumber = "{$number}/{$correspondence_category_data->code}/{$month}/{$year}";

            $model->letter_number = $letterNumber;

            // Simpan Signature Logic
            $signatureFilename = time().'_'.$request["signature"]->getClientOriginalName();
            $request["signature"]->storeAs("signatures", $signatureFilename, 'public');
            $model->signature = $signatureFilename;

            $model->save();

            // Logic Simpan Berkas atau Attachments
            if($request["attachments"]) {
                $attachments = $request["attachments"];
                // Lakukan Perulangan untuk Menyimpan Attachements
                foreach($attachments as $at) {
                    $model_attachments = new CorrespondenceAttachments;

                    $model_attachments->name = $at["name"];

                    $attachmentFilename = time().'_'.$at["file"]->getClientOriginalName();
                    $at["file"]->storeAs("attachments", $attachmentFilename, 'public');
                    $model_attachments->file_name = $attachmentFilename;

                    $model_attachments->correspondence_id = $model->id;

                    $model_attachments->save();
                }
            }

            DB::commit();

            session()->flash("create", "Surat berhasil dikirim.");


            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            DB::rollBack();
            return ApiResponse::errorResponse("Gagal Membuat Data Post : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Correspondences::with("correspondence_category",
        "sender_data", "recepient_data", "correspondence_attachments")->find($id);

        return response()->json($data);
    }

    public function update(CorrespondenceRequest $request, $id) {
        // Lakukan dengan DB Transaction
        DB::beginTransaction();
        try {
            $model = Correspondences::find($id);

            $model->subject = $request["subject"];
            $model->content = $request["content"];
            $model->recepient = $request["recepient"];
            $model->letter_date = $request["letter_date"];
            $model->sender = Auth::user()->member->id;

            $model->correspondence_category_id = $request["correspondence_category_id"];

            // Jika Update Signature
            if($request["signature"]) {

                // Hapus Signature Lama
                $path = "app/public/signatures/". $model->signature;

                if(file_exists(storage_path($path))) {
                    unlink(storage_path($path));
                }

                // Buat Signature Baru
                $signatureFilename = time().'_'.$request["signature"]->getClientOriginalName();
                $request["signature"]->storeAs("signatures", $signatureFilename, 'public');
                $model->signature = $signatureFilename;
            }


            $model->save();

            // Logic Update Attachement Simpan Berkas atau Attachments
            if($request["attachments"]) {
                $current_attachments = CorrespondenceAttachments::where("correspondence_id", "=", $id)->get();

                // Hapus File Attachment Lama
                $current_attachments->each(function ($ca) {
                    $path = "app/public/attachments/". $ca->file_name;

                    if(file_exists(storage_path($path))) {
                        unlink(storage_path($path));
                    }

                    $ca->delete();
                });

                // Buat File Attachment Baru
                $attachements = $request["attachments"];
                // Lakukan Perulangan untuk Menyimpan Attachements
                foreach($attachements as $at) {
                    $model_attachements = new CorrespondenceAttachments;

                    $model_attachements->name = $at["name"];

                    $attachmentFilename = time().'_'.$at["file"]->getClientOriginalName();
                    $at["file"]->storeAs("attachments", $attachmentFilename, 'public');
                    $model_attachements->file_name = $attachmentFilename;

                    $model_attachements->correspondence_id = $model->id;

                    $model_attachements->save();
                }
            }

            DB::commit();

            session()->flash("update", "Surat berhasil diupdate.");


            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            DB::rollBack();
            return ApiResponse::errorResponse("Gagal Membuat Surat : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = Correspondences::with("correspondence_attachments")->find($id);

            if($model->correspondence_attachments->exists()) {
                $attachments = CorrespondenceAttachments::where("correspondence_id", "=", $model->id)->get();

                $attachments->each(function ($at) {
                    $path = "app/public/attachments/". $at->file_name;

                    if(file_exists(storage_path($path))) {
                        unlink(storage_path($path));
                    }

                    $at->delete();
                });
            }

            $signature_path = "app/public/signatures/". $model->cover_image;

            if(file_exists(storage_path($signature_path))) {
                unlink(storage_path($signature_path));
            }

            $model->delete();

            session()->flash("delete", "Data Surat Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Post : {$e->getMessage()}");
        }
    }

    // public function updateReadStatus($id) {

    //     try {
    //         $model = Correspondences::find($id);
    //         $model->readed = 1;

    //         $model->save();

    //         session()->flash("update", "Status Publish Postingan Berhasil Diupdate.");

    //         return ApiResponse::successResponse("");
    //     } catch(\Throwable $e) {
    //         return ApiResponse::errorResponse("Gagal Mengupdate Status Publish Postingan : {$e->getMessage()}");
    //     }
    // }
}
