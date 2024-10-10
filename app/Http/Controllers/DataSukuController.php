<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\DataSuku;
use Illuminate\Http\Request;
use App\Exports\DataSukuExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreDataSukuRequest;
use App\Http\Requests\UpdateDataSukuRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DataSukuController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_suku', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_suku', only: ['store']),
            new Middleware('permission:edit_data_suku', only: ['update']),
            new Middleware('permission:delete_data_suku', only: ['delete']),
            new Middleware('permission:trash_data_suku', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-sukus.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataSuku model and order by 'id' in descending order
        $dataSuku = DataSuku::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataSuku->onlyTrashed();

        return DataTables::of($dataSuku)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataSuku::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_suku') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_suku') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataSukuRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataSuku model using the data from the request
        $dataSuku = DataSuku::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataSuku
        ]);
    }

    public function update(UpdateDataSukuRequest $request, $id):JsonResponse
    {
        $dataSuku = DataSuku::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataSuku entry with the filtered data
        $dataSuku->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataSuku
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataSuku entry by its ID or fail if not found
        $dataSuku = DataSuku::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataSuku,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataSuku = DataSuku::findOrFail($request->id);
        $dataSuku->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataSuku
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataSukuExcel($request->excel_search), 'data-sukus-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataSuku = DataSuku::get();

        $pdf = Pdf::loadView('pages.data-sukus.print', compact('dataSuku'));
        return $pdf->download('data-sukus-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataSuku = DataSuku::get();
        return view('pages.data-sukus.print' , compact('dataSuku'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataSuku = DataSuku::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataSuku->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataSuku = DataSuku::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataSuku->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataSuku
        ]);
    }
}