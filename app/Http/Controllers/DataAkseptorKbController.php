<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataAkseptorKb;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\DataAkseptorKbExcel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\StoreDataAkseptorKbRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\UpdateDataAkseptorKbRequest;

class DataAkseptorKbController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_akseptor_kb', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_akseptor_kb', only: ['store']),
            new Middleware('permission:edit_data_akseptor_kb', only: ['update']),
            new Middleware('permission:delete_data_akseptor_kb', only: ['delete']),
            new Middleware('permission:trash_data_akseptor_kb', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-akseptor-kbs.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataAkseptorKb model and order by 'id' in descending order
        $dataAkseptorKb = DataAkseptorKb::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataAkseptorKb->onlyTrashed();

        return DataTables::of($dataAkseptorKb)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataAkseptorKb::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_akseptor_kb') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_akseptor_kb') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataAkseptorKbRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataAkseptorKb model using the data from the request
        $dataAkseptorKb = DataAkseptorKb::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataAkseptorKb
        ]);
    }

    public function update(UpdateDataAkseptorKbRequest $request, $id):JsonResponse
    {
        $dataAkseptorKb = DataAkseptorKb::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataAkseptorKb entry with the filtered data
        $dataAkseptorKb->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataAkseptorKb
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataAkseptorKb entry by its ID or fail if not found
        $dataAkseptorKb = DataAkseptorKb::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataAkseptorKb,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataAkseptorKb = DataAkseptorKb::findOrFail($request->id);
        $dataAkseptorKb->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataAkseptorKb
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataAkseptorKbExcel($request->excel_search), 'data-akseptor-kbs-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataAkseptorKb = DataAkseptorKb::get();

        $pdf = Pdf::loadView('pages.data-akseptor-kbs.print', compact('dataAkseptorKb'));
        return $pdf->download('data-akseptor-kbs-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataAkseptorKb = DataAkseptorKb::get();
        return view('pages.data-akseptor-kbs.print' , compact('dataAkseptorKb'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataAkseptorKb = DataAkseptorKb::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataAkseptorKb->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataAkseptorKb = DataAkseptorKb::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataAkseptorKb->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataAkseptorKb
        ]);
    }
}