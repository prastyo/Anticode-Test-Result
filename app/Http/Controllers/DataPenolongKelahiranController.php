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
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DataPenolongKelahiran;
use App\Exports\DataPenolongKelahiranExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataPenolongKelahiranRequest;
use App\Http\Requests\UpdateDataPenolongKelahiranRequest;

class DataPenolongKelahiranController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_penolong_kelahiran', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_penolong_kelahiran', only: ['store']),
            new Middleware('permission:edit_data_penolong_kelahiran', only: ['update']),
            new Middleware('permission:delete_data_penolong_kelahiran', only: ['delete']),
            new Middleware('permission:trash_data_penolong_kelahiran', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-penolong-kelahirans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataPenolongKelahiran model and order by 'id' in descending order
        $dataPenolongKelahiran = DataPenolongKelahiran::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataPenolongKelahiran->onlyTrashed();

        return DataTables::of($dataPenolongKelahiran)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataPenolongKelahiran::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_penolong_kelahiran') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_penolong_kelahiran') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataPenolongKelahiranRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataPenolongKelahiran model using the data from the request
        $dataPenolongKelahiran = DataPenolongKelahiran::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataPenolongKelahiran
        ]);
    }

    public function update(UpdateDataPenolongKelahiranRequest $request, $id):JsonResponse
    {
        $dataPenolongKelahiran = DataPenolongKelahiran::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataPenolongKelahiran entry with the filtered data
        $dataPenolongKelahiran->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataPenolongKelahiran
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataPenolongKelahiran entry by its ID or fail if not found
        $dataPenolongKelahiran = DataPenolongKelahiran::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataPenolongKelahiran,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataPenolongKelahiran = DataPenolongKelahiran::findOrFail($request->id);
        $dataPenolongKelahiran->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataPenolongKelahiran
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataPenolongKelahiranExcel($request->excel_search), 'data-penolong-kelahirans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataPenolongKelahiran = DataPenolongKelahiran::get();

        $pdf = Pdf::loadView('pages.data-penolong-kelahirans.print', compact('dataPenolongKelahiran'));
        return $pdf->download('data-penolong-kelahirans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataPenolongKelahiran = DataPenolongKelahiran::get();
        return view('pages.data-penolong-kelahirans.print' , compact('dataPenolongKelahiran'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataPenolongKelahiran = DataPenolongKelahiran::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataPenolongKelahiran->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataPenolongKelahiran = DataPenolongKelahiran::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataPenolongKelahiran->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataPenolongKelahiran
        ]);
    }
}