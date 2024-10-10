<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWarganegara;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataWarganegaraExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataWarganegaraRequest;
use App\Http\Requests\UpdateDataWarganegaraRequest;

class DataWarganegaraController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_warganegara', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_warganegara', only: ['store']),
            new Middleware('permission:edit_data_warganegara', only: ['update']),
            new Middleware('permission:delete_data_warganegara', only: ['delete']),
            new Middleware('permission:trash_data_warganegara', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-warganegaras.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataWarganegara model and order by 'id' in descending order
        $dataWarganegara = DataWarganegara::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataWarganegara->onlyTrashed();

        return DataTables::of($dataWarganegara)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataWarganegara::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_warganegara') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_warganegara') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataWarganegaraRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataWarganegara model using the data from the request
        $dataWarganegara = DataWarganegara::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataWarganegara
        ]);
    }

    public function update(UpdateDataWarganegaraRequest $request, $id):JsonResponse
    {
        $dataWarganegara = DataWarganegara::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataWarganegara entry with the filtered data
        $dataWarganegara->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataWarganegara
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataWarganegara entry by its ID or fail if not found
        $dataWarganegara = DataWarganegara::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataWarganegara,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataWarganegara = DataWarganegara::findOrFail($request->id);
        $dataWarganegara->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataWarganegara
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataWarganegaraExcel($request->excel_search), 'data-warganegaras-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataWarganegara = DataWarganegara::get();

        $pdf = Pdf::loadView('pages.data-warganegaras.print', compact('dataWarganegara'));
        return $pdf->download('data-warganegaras-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataWarganegara = DataWarganegara::get();
        return view('pages.data-warganegaras.print' , compact('dataWarganegara'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataWarganegara = DataWarganegara::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataWarganegara->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataWarganegara = DataWarganegara::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataWarganegara->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataWarganegara
        ]);
    }
}