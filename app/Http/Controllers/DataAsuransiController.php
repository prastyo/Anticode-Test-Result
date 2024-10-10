<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataAsuransi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\DataAsuransiExcel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\StoreDataAsuransiRequest;
use App\Http\Requests\UpdateDataAsuransiRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataAsuransiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_asuransi', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_asuransi', only: ['store']),
            new Middleware('permission:edit_data_asuransi', only: ['update']),
            new Middleware('permission:delete_data_asuransi', only: ['delete']),
            new Middleware('permission:trash_data_asuransi', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-asuransis.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataAsuransi model and order by 'id' in descending order
        $dataAsuransi = DataAsuransi::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataAsuransi->onlyTrashed();

        return DataTables::of($dataAsuransi)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataAsuransi::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_asuransi') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_asuransi') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataAsuransiRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataAsuransi model using the data from the request
        $dataAsuransi = DataAsuransi::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataAsuransi
        ]);
    }

    public function update(UpdateDataAsuransiRequest $request, $id):JsonResponse
    {
        $dataAsuransi = DataAsuransi::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataAsuransi entry with the filtered data
        $dataAsuransi->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataAsuransi
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataAsuransi entry by its ID or fail if not found
        $dataAsuransi = DataAsuransi::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataAsuransi,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataAsuransi = DataAsuransi::findOrFail($request->id);
        $dataAsuransi->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataAsuransi
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataAsuransiExcel($request->excel_search), 'data-asuransis-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataAsuransi = DataAsuransi::get();

        $pdf = Pdf::loadView('pages.data-asuransis.print', compact('dataAsuransi'));
        return $pdf->download('data-asuransis-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataAsuransi = DataAsuransi::get();
        return view('pages.data-asuransis.print' , compact('dataAsuransi'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataAsuransi = DataAsuransi::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataAsuransi->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataAsuransi = DataAsuransi::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataAsuransi->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataAsuransi
        ]);
    }
}