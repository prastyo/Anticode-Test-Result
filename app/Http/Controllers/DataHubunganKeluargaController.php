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
use App\Models\DataHubunganKeluarga;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataHubunganKeluargaExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataHubunganKeluargaRequest;
use App\Http\Requests\UpdateDataHubunganKeluargaRequest;

class DataHubunganKeluargaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_hubungan_keluarga', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_hubungan_keluarga', only: ['store']),
            new Middleware('permission:edit_data_hubungan_keluarga', only: ['update']),
            new Middleware('permission:delete_data_hubungan_keluarga', only: ['delete']),
            new Middleware('permission:trash_data_hubungan_keluarga', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-hubungan-keluargas.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataHubunganKeluarga model and order by 'id' in descending order
        $dataHubunganKeluarga = DataHubunganKeluarga::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataHubunganKeluarga->onlyTrashed();

        return DataTables::of($dataHubunganKeluarga)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataHubunganKeluarga::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_hubungan_keluarga') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_hubungan_keluarga') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataHubunganKeluargaRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataHubunganKeluarga model using the data from the request
        $dataHubunganKeluarga = DataHubunganKeluarga::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataHubunganKeluarga
        ]);
    }

    public function update(UpdateDataHubunganKeluargaRequest $request, $id):JsonResponse
    {
        $dataHubunganKeluarga = DataHubunganKeluarga::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataHubunganKeluarga entry with the filtered data
        $dataHubunganKeluarga->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataHubunganKeluarga
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataHubunganKeluarga entry by its ID or fail if not found
        $dataHubunganKeluarga = DataHubunganKeluarga::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataHubunganKeluarga,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataHubunganKeluarga = DataHubunganKeluarga::findOrFail($request->id);
        $dataHubunganKeluarga->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataHubunganKeluarga
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataHubunganKeluargaExcel($request->excel_search), 'data-hubungan-keluargas-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataHubunganKeluarga = DataHubunganKeluarga::get();

        $pdf = Pdf::loadView('pages.data-hubungan-keluargas.print', compact('dataHubunganKeluarga'));
        return $pdf->download('data-hubungan-keluargas-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataHubunganKeluarga = DataHubunganKeluarga::get();
        return view('pages.data-hubungan-keluargas.print' , compact('dataHubunganKeluarga'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataHubunganKeluarga = DataHubunganKeluarga::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataHubunganKeluarga->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataHubunganKeluarga = DataHubunganKeluarga::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataHubunganKeluarga->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataHubunganKeluarga
        ]);
    }
}