<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\EventCategories;
use App\Models\EventGalleries;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request) {

        $pageTake = 20;

        $term = $request->query("term") ?? "";

        $currentPage = (int) ($request->query("page") ?? 1);

        $count = Events::where(
            function ($q) use($term) {
                $q->where("name", "like", "%{$term}%")
                ->orWhereHas("event_category", function ($p0) use($term) {
                    $p0->where("name", "like", "%{$term}%");
                });
            }
        )->count();

        $totalPage = ceil(($count / $pageTake) + 0.4);

        $data = Events::with("event_category", "event_galleries")->where(
            function ($q) use($term) {
                $q->where("name", "like", "%{$term}%")
                ->orWhereHas("event_category", function ($p0) use($term) {
                    $p0->where("name", "like", "%{$term}%");
                });
            }
        )->take($pageTake)
        ->skip(($currentPage - 1) * $pageTake)->get();

        // Bagian Event Category
        $event_categories_data = EventCategories::orderBy("name", "asc")->get();

        return view("backoffice.event.index",
        [
            "data" => $data,
            "event_categories_data" => $event_categories_data,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "term" => $term
        ]);
    }

    public function create(EventRequest $request) {
        try {
            $model = new Events;

            $model->name = $request["name"];
            $model->content = $request["content"];
            $model->event_category_id = $request["event_category_id"];
            $model->start_date = $request["start_date"];
            $model->end_date = $request["end_date"];
            $model->save();

            session()->flash("create", "Data Event {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Event : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Events::with("event_galleries.member")->find($id);

        return response()->json($data);
    }

    public function update(EventRequest $request, $id) {

        try {
            $model = Events::find($id);

            $model->name = $request["name"];
            $model->content = $request["content"];
            $model->event_category_id = $request["event_category_id"];
            $model->start_date = $request["start_date"];
            $model->end_date = $request["end_date"];

            $model->save();

            session()->flash("update", "Data Event {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Event : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = Events::find($id);

            if($model->event_galleries()->exists()) {
                $galleries = EventGalleries::where("event_id", "=", $model->id)->get();

                for($i = 0; $i < count($galleries); $i++) {
                    $path = "app/public/event-galleries/". $galleries[$i]->photo;

                    if(file_exists(storage_path($path))) {
                        unlink(storage_path($path));
                    }
                }

                $galleries->each(function ($gallery) {
                    $path = "app/public/event-galleries/". $gallery->photo;

                    if(file_exists(storage_path($path))) {
                        unlink(storage_path($path));
                    }

                    $gallery->delete();
                });
            }

            $model->delete();


            session()->flash("delete", "Data Event {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Event : {$e->getMessage()}");
        }
    }

    public function uploadGalleriesEventImage(Request $request) {
        $event_id = $request["event_id"];

        $image_files = $request["image_files"];

        foreach($image_files as $if) {
            $model = new EventGalleries;

            $filename = time().'_'.$if->getClientOriginalName();
            $if->storeAs("event_galleries", $filename, 'public');
            $model->photo = $filename;
            $model->event_id = $event_id;
            $model->uploaded_by = Auth::user()->member->id;
            $model->save();
        }

        session()->flash("create", "Data Galleries Event Berhasil Ditambahkan.");

        return ApiResponse::successResponse("Data Event Gallery Berhasil Ditambahkan.");
    }

    public function deleteGallery($id) {
        try {
            $model = EventGalleries::find($id);

            $path = "app/public/event_galleries/". $model->photo;

            if(file_exists(storage_path($path))) {
                unlink(storage_path($path));
            }

            $model->delete();

            session()->flash("delete", "Data Gallery Event Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Gallery Event : {$e->getMessage()}");
        }
    }
}
