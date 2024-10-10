<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataKursu;
use Illuminate\Http\Request;
use App\Exports\DataKursuExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataKursuRequest;
use App\Http\Requests\UpdateDataKursuRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataKursuController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_kursus', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_kursus', only: ['store']),
            new Middleware('permission:edit_data_kursus', only: ['update']),
            new Middleware('permission:delete_data_kursus', only: ['delete']),
            new Middleware('permission:trash_data_kursus', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-kursuses.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataKursu model and order by 'id' in descending order
        $dataKursus = DataKursu::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataKursus->onlyTrashed();

        return DataTables::of($dataKursus)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataKursu::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_kursus') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_kursus') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataKursuRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataKursu model using the data from the request
        $dataKursus = DataKursu::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataKursus
        ]);
    }

    public function update(UpdateDataKursuRequest $request, $id):JsonResponse
    {
        $dataKursus = DataKursu::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataKursu entry with the filtered data
        $dataKursus->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataKursus
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataKursu entry by its ID or fail if not found
        $dataKursus = DataKursu::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataKursus,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataKursus = DataKursu::findOrFail($request->id);
        $dataKursus->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataKursus
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataKursuExcel($request->excel_search), 'data-kursuses-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataKursus = DataKursu::get();

        $pdf = Pdf::loadView('pages.data-kursuses.print', compact('dataKursus'));
        return $pdf->download('data-kursuses-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataKursus = DataKursu::get();
        return view('pages.data-kursuses.print' , compact('dataKursus'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataKursus = DataKursu::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataKursus->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataKursus = DataKursu::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataKursus->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataKursus
        ]);
    }
}