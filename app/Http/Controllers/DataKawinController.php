<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataKawin;
use Illuminate\Http\Request;
use App\Exports\DataKawinExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataKawinRequest;
use App\Http\Requests\UpdateDataKawinRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataKawinController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_kawin', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_kawin', only: ['store']),
            new Middleware('permission:edit_data_kawin', only: ['update']),
            new Middleware('permission:delete_data_kawin', only: ['delete']),
            new Middleware('permission:trash_data_kawin', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-kawins.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataKawin model and order by 'id' in descending order
        $dataKawin = DataKawin::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataKawin->onlyTrashed();

        return DataTables::of($dataKawin)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataKawin::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_kawin') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_kawin') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataKawinRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataKawin model using the data from the request
        $dataKawin = DataKawin::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataKawin
        ]);
    }

    public function update(UpdateDataKawinRequest $request, $id):JsonResponse
    {
        $dataKawin = DataKawin::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataKawin entry with the filtered data
        $dataKawin->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataKawin
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataKawin entry by its ID or fail if not found
        $dataKawin = DataKawin::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataKawin,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataKawin = DataKawin::findOrFail($request->id);
        $dataKawin->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataKawin
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataKawinExcel($request->excel_search), 'data-kawins-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataKawin = DataKawin::get();

        $pdf = Pdf::loadView('pages.data-kawins.print', compact('dataKawin'));
        return $pdf->download('data-kawins-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataKawin = DataKawin::get();
        return view('pages.data-kawins.print' , compact('dataKawin'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataKawin = DataKawin::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataKawin->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataKawin = DataKawin::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataKawin->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataKawin
        ]);
    }
}