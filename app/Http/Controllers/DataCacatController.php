<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataCacat;
use Illuminate\Http\Request;
use App\Exports\DataCacatExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataCacatRequest;
use App\Http\Requests\UpdateDataCacatRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataCacatController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_cacat', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_cacat', only: ['store']),
            new Middleware('permission:edit_data_cacat', only: ['update']),
            new Middleware('permission:delete_data_cacat', only: ['delete']),
            new Middleware('permission:trash_data_cacat', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-cacats.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataCacat model and order by 'id' in descending order
        $dataCacat = DataCacat::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataCacat->onlyTrashed();

        return DataTables::of($dataCacat)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataCacat::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_cacat') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_cacat') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataCacatRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataCacat model using the data from the request
        $dataCacat = DataCacat::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataCacat
        ]);
    }

    public function update(UpdateDataCacatRequest $request, $id):JsonResponse
    {
        $dataCacat = DataCacat::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataCacat entry with the filtered data
        $dataCacat->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataCacat
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataCacat entry by its ID or fail if not found
        $dataCacat = DataCacat::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataCacat,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataCacat = DataCacat::findOrFail($request->id);
        $dataCacat->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataCacat
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataCacatExcel($request->excel_search), 'data-cacats-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataCacat = DataCacat::get();

        $pdf = Pdf::loadView('pages.data-cacats.print', compact('dataCacat'));
        return $pdf->download('data-cacats-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataCacat = DataCacat::get();
        return view('pages.data-cacats.print' , compact('dataCacat'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataCacat = DataCacat::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataCacat->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataCacat = DataCacat::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataCacat->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataCacat
        ]);
    }
}