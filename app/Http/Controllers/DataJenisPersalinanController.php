<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\DataJenisPersalinan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataJenisPersalinanExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataJenisPersalinanRequest;
use App\Http\Requests\UpdateDataJenisPersalinanRequest;

class DataJenisPersalinanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_jenis_persalinan', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_jenis_persalinan', only: ['store']),
            new Middleware('permission:edit_data_jenis_persalinan', only: ['update']),
            new Middleware('permission:delete_data_jenis_persalinan', only: ['delete']),
            new Middleware('permission:trash_data_jenis_persalinan', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-jenis-persalinans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataJenisPersalinan model and order by 'id' in descending order
        $dataJenisPersalinan = DataJenisPersalinan::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataJenisPersalinan->onlyTrashed();

        return DataTables::of($dataJenisPersalinan)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataJenisPersalinan::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_jenis_persalinan') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_jenis_persalinan') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataJenisPersalinanRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataJenisPersalinan model using the data from the request
        $dataJenisPersalinan = DataJenisPersalinan::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataJenisPersalinan
        ]);
    }

    public function update(UpdateDataJenisPersalinanRequest $request, $id):JsonResponse
    {
        $dataJenisPersalinan = DataJenisPersalinan::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataJenisPersalinan entry with the filtered data
        $dataJenisPersalinan->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataJenisPersalinan
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataJenisPersalinan entry by its ID or fail if not found
        $dataJenisPersalinan = DataJenisPersalinan::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataJenisPersalinan,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataJenisPersalinan = DataJenisPersalinan::findOrFail($request->id);
        $dataJenisPersalinan->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataJenisPersalinan
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataJenisPersalinanExcel($request->excel_search), 'data-jenis-persalinans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataJenisPersalinan = DataJenisPersalinan::get();

        $pdf = Pdf::loadView('pages.data-jenis-persalinans.print', compact('dataJenisPersalinan'));
        return $pdf->download('data-jenis-persalinans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataJenisPersalinan = DataJenisPersalinan::get();
        return view('pages.data-jenis-persalinans.print' , compact('dataJenisPersalinan'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataJenisPersalinan = DataJenisPersalinan::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataJenisPersalinan->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataJenisPersalinan = DataJenisPersalinan::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataJenisPersalinan->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataJenisPersalinan
        ]);
    }
}