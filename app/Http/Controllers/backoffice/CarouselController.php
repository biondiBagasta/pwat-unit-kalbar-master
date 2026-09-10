<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselRequest;
use App\Models\Carousels;

class CarouselController extends Controller
{

    public function index() {
        $data = Carousels::orderBy("show_order", "asc")->get();

        return view("backoffice.carousel.index", [
            "data" => $data
        ]);
    }

    public function create(CarouselRequest $request) {
        try {
            $model = new Carousels;

            $model->show_order = $request["show_order"];

            if($request["image"]) {
                $filename = time().'_'.$request["image"]->getClientOriginalName();
                $request["image"]->storeAs("carousels", $filename, 'public');
                $model->image = $filename;

                $model->save();

                session()->flash("create", "Data Carousel Berhasil Ditambahkan.");

                return ApiResponse::successResponse("");
            } else {
                return ApiResponse::errorResponse("Gambar Carousel harus dipilih.");
            }

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Carousel : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Carousels::find($id);

        return response()->json($data);
    }

    public function update(CarouselRequest $request, $id) {
        try {
            $model = Carousels::find($id);

            $model->show_order = $request["show_order"];

            if($request["image"]) {
                $path = "app/public/carousels/". $model->image;

                if(file_exists(storage_path($path))) {
                    unlink(storage_path($path));
                }

                $filename = time().'_'.$request["image"]->getClientOriginalName();
                $request["image"]->storeAs("carousels", $filename, 'public');
                $model->image = $filename;
            }

            $model->save();

            session()->flash("update", "Data Carousel Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Carousel : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = Carousels::find($id);

            $path = "app/public/carousels/". $model->image;

            if(file_exists(storage_path($path))) {
                unlink(storage_path($path));
            }

            $model->delete();

            session()->flash("delete", "Data Carousel Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Carousel : {$e->getMessage()}");
        }
    }
}
