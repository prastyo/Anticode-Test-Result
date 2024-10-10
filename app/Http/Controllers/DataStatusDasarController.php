<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataStatusDasar;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataStatusDasarExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataStatusDasarRequest;
use App\Http\Requests\UpdateDataStatusDasarRequest;

class DataStatusDasarController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_status_dasar', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_status_dasar', only: ['store']),
            new Middleware('permission:edit_data_status_dasar', only: ['update']),
            new Middleware('permission:delete_data_status_dasar', only: ['delete']),
            new Middleware('permission:trash_data_status_dasar', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-status-dasars.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataStatusDasar model and order by 'id' in descending order
        $dataStatusDasar = DataStatusDasar::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataStatusDasar->onlyTrashed();

        return DataTables::of($dataStatusDasar)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataStatusDasar::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_status_dasar') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_status_dasar') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataStatusDasarRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataStatusDasar model using the data from the request
        $dataStatusDasar = DataStatusDasar::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataStatusDasar
        ]);
    }

    public function update(UpdateDataStatusDasarRequest $request, $id):JsonResponse
    {
        $dataStatusDasar = DataStatusDasar::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataStatusDasar entry with the filtered data
        $dataStatusDasar->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataStatusDasar
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataStatusDasar entry by its ID or fail if not found
        $dataStatusDasar = DataStatusDasar::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataStatusDasar,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataStatusDasar = DataStatusDasar::findOrFail($request->id);
        $dataStatusDasar->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataStatusDasar
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataStatusDasarExcel($request->excel_search), 'data-status-dasars-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataStatusDasar = DataStatusDasar::get();

        $pdf = Pdf::loadView('pages.data-status-dasars.print', compact('dataStatusDasar'));
        return $pdf->download('data-status-dasars-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataStatusDasar = DataStatusDasar::get();
        return view('pages.data-status-dasars.print' , compact('dataStatusDasar'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataStatusDasar = DataStatusDasar::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataStatusDasar->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataStatusDasar = DataStatusDasar::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataStatusDasar->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataStatusDasar
        ]);
    }
}