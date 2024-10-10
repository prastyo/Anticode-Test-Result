<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataBahasa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\DataBahasaExcel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataBahasaRequest;
use App\Http\Requests\UpdateDataBahasaRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataBahasaController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_bahasa', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_bahasa', only: ['store']),
            new Middleware('permission:edit_data_bahasa', only: ['update']),
            new Middleware('permission:delete_data_bahasa', only: ['delete']),
            new Middleware('permission:trash_data_bahasa', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-bahasas.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataBahasa model and order by 'id' in descending order
        $dataBahasa = DataBahasa::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataBahasa->onlyTrashed();

        return DataTables::of($dataBahasa)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataBahasa::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_bahasa') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_bahasa') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataBahasaRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataBahasa model using the data from the request
        $dataBahasa = DataBahasa::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataBahasa
        ]);
    }

    public function update(UpdateDataBahasaRequest $request, $id):JsonResponse
    {
        $dataBahasa = DataBahasa::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataBahasa entry with the filtered data
        $dataBahasa->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataBahasa
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataBahasa entry by its ID or fail if not found
        $dataBahasa = DataBahasa::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataBahasa,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataBahasa = DataBahasa::findOrFail($request->id);
        $dataBahasa->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataBahasa
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataBahasaExcel($request->excel_search), 'data-bahasas-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataBahasa = DataBahasa::get();

        $pdf = Pdf::loadView('pages.data-bahasas.print', compact('dataBahasa'));
        return $pdf->download('data-bahasas-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataBahasa = DataBahasa::get();
        return view('pages.data-bahasas.print' , compact('dataBahasa'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataBahasa = DataBahasa::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataBahasa->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataBahasa = DataBahasa::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataBahasa->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataBahasa
        ]);
    }
}