<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataJabatan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use App\Exports\DataJabatanExcel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataJabatanRequest;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\UpdateDataJabatanRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataJabatanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_jabatan', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_jabatan', only: ['store']),
            new Middleware('permission:edit_data_jabatan', only: ['update']),
            new Middleware('permission:delete_data_jabatan', only: ['delete']),
            new Middleware('permission:trash_data_jabatan', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-jabatans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataJabatan model and order by 'id' in descending order
        $dataJabatan = DataJabatan::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataJabatan->onlyTrashed();

        return DataTables::of($dataJabatan)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataJabatan::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_jabatan') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_jabatan') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataJabatanRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataJabatan model using the data from the request
        $dataJabatan = DataJabatan::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataJabatan
        ]);
    }

    public function update(UpdateDataJabatanRequest $request, $id):JsonResponse
    {
        $dataJabatan = DataJabatan::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataJabatan entry with the filtered data
        $dataJabatan->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataJabatan
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataJabatan entry by its ID or fail if not found
        $dataJabatan = DataJabatan::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataJabatan,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataJabatan = DataJabatan::findOrFail($request->id);
        $dataJabatan->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataJabatan
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataJabatanExcel($request->excel_search), 'data-jabatans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataJabatan = DataJabatan::get();

        $pdf = Pdf::loadView('pages.data-jabatans.print', compact('dataJabatan'));
        return $pdf->download('data-jabatans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataJabatan = DataJabatan::get();
        return view('pages.data-jabatans.print' , compact('dataJabatan'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataJabatan = DataJabatan::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataJabatan->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataJabatan = DataJabatan::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataJabatan->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataJabatan
        ]);
    }
}