<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataPendidikan;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Exports\DataPendidikanExcel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\StoreDataPendidikanRequest;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\UpdateDataPendidikanRequest;

class DataPendidikanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_pendidikan', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_pendidikan', only: ['store']),
            new Middleware('permission:edit_data_pendidikan', only: ['update']),
            new Middleware('permission:delete_data_pendidikan', only: ['delete']),
            new Middleware('permission:trash_data_pendidikan', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-pendidikans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataPendidikan model and order by 'id' in descending order
        $dataPendidikan = DataPendidikan::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataPendidikan->onlyTrashed();

        return DataTables::of($dataPendidikan)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataPendidikan::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_pendidikan') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_pendidikan') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataPendidikanRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataPendidikan model using the data from the request
        $dataPendidikan = DataPendidikan::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataPendidikan
        ]);
    }

    public function update(UpdateDataPendidikanRequest $request, $id):JsonResponse
    {
        $dataPendidikan = DataPendidikan::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataPendidikan entry with the filtered data
        $dataPendidikan->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataPendidikan
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataPendidikan entry by its ID or fail if not found
        $dataPendidikan = DataPendidikan::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataPendidikan,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataPendidikan = DataPendidikan::findOrFail($request->id);
        $dataPendidikan->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataPendidikan
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataPendidikanExcel($request->excel_search), 'data-pendidikans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataPendidikan = DataPendidikan::get();

        $pdf = Pdf::loadView('pages.data-pendidikans.print', compact('dataPendidikan'));
        return $pdf->download('data-pendidikans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataPendidikan = DataPendidikan::get();
        return view('pages.data-pendidikans.print' , compact('dataPendidikan'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataPendidikan = DataPendidikan::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataPendidikan->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataPendidikan = DataPendidikan::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataPendidikan->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataPendidikan
        ]);
    }
}