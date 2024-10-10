<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPekerjaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\DataPekerjaanExcel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\StoreDataPekerjaanRequest;
use App\Http\Requests\UpdateDataPekerjaanRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataPekerjaanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_pekerjaan', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_pekerjaan', only: ['store']),
            new Middleware('permission:edit_data_pekerjaan', only: ['update']),
            new Middleware('permission:delete_data_pekerjaan', only: ['delete']),
            new Middleware('permission:trash_data_pekerjaan', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-pekerjaans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataPekerjaan model and order by 'id' in descending order
        $dataPekerjaan = DataPekerjaan::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataPekerjaan->onlyTrashed();

        return DataTables::of($dataPekerjaan)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataPekerjaan::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_pekerjaan') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_pekerjaan') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataPekerjaanRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataPekerjaan model using the data from the request
        $dataPekerjaan = DataPekerjaan::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataPekerjaan
        ]);
    }

    public function update(UpdateDataPekerjaanRequest $request, $id):JsonResponse
    {
        $dataPekerjaan = DataPekerjaan::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataPekerjaan entry with the filtered data
        $dataPekerjaan->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataPekerjaan
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataPekerjaan entry by its ID or fail if not found
        $dataPekerjaan = DataPekerjaan::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataPekerjaan,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataPekerjaan = DataPekerjaan::findOrFail($request->id);
        $dataPekerjaan->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataPekerjaan
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataPekerjaanExcel($request->excel_search), 'data-pekerjaans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataPekerjaan = DataPekerjaan::get();

        $pdf = Pdf::loadView('pages.data-pekerjaans.print', compact('dataPekerjaan'));
        return $pdf->download('data-pekerjaans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataPekerjaan = DataPekerjaan::get();
        return view('pages.data-pekerjaans.print' , compact('dataPekerjaan'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataPekerjaan = DataPekerjaan::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataPekerjaan->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataPekerjaan = DataPekerjaan::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataPekerjaan->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataPekerjaan
        ]);
    }
}