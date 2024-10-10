<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataAgama;
use Illuminate\Http\Request;
use App\Exports\DataAgamaExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataAgamaRequest;
use App\Http\Requests\UpdateDataAgamaRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataAgamaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_agama', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_agama', only: ['store']),
            new Middleware('permission:edit_data_agama', only: ['update']),
            new Middleware('permission:delete_data_agama', only: ['delete']),
            new Middleware('permission:trash_data_agama', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-agamas.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataAgama model and order by 'id' in descending order
        $dataAgama = DataAgama::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataAgama->onlyTrashed();

        return DataTables::of($dataAgama)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataAgama::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_agama') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_agama') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataAgamaRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataAgama model using the data from the request
        $dataAgama = DataAgama::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataAgama
        ]);
    }

    public function update(UpdateDataAgamaRequest $request, $id):JsonResponse
    {
        $dataAgama = DataAgama::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataAgama entry with the filtered data
        $dataAgama->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataAgama
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataAgama entry by its ID or fail if not found
        $dataAgama = DataAgama::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataAgama,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataAgama = DataAgama::findOrFail($request->id);
        $dataAgama->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataAgama
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataAgamaExcel($request->excel_search), 'data-agamas-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataAgama = DataAgama::get();

        $pdf = Pdf::loadView('pages.data-agamas.print', compact('dataAgama'));
        return $pdf->download('data-agamas-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataAgama = DataAgama::get();
        return view('pages.data-agamas.print' , compact('dataAgama'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataAgama = DataAgama::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataAgama->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataAgama = DataAgama::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataAgama->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataAgama
        ]);
    }
}