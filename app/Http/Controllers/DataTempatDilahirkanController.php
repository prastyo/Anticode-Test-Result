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
use App\Models\DataTempatDilahirkan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataTempatDilahirkanExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataTempatDilahirkanRequest;
use App\Http\Requests\UpdateDataTempatDilahirkanRequest;

class DataTempatDilahirkanController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_tempat_dilahirkan', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_tempat_dilahirkan', only: ['store']),
            new Middleware('permission:edit_data_tempat_dilahirkan', only: ['update']),
            new Middleware('permission:delete_data_tempat_dilahirkan', only: ['delete']),
            new Middleware('permission:trash_data_tempat_dilahirkan', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-tempat-dilahirkans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataTempatDilahirkan model and order by 'id' in descending order
        $dataTempatDilahirkan = DataTempatDilahirkan::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataTempatDilahirkan->onlyTrashed();

        return DataTables::of($dataTempatDilahirkan)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataTempatDilahirkan::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_tempat_dilahirkan') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_tempat_dilahirkan') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataTempatDilahirkanRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataTempatDilahirkan model using the data from the request
        $dataTempatDilahirkan = DataTempatDilahirkan::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataTempatDilahirkan
        ]);
    }

    public function update(UpdateDataTempatDilahirkanRequest $request, $id):JsonResponse
    {
        $dataTempatDilahirkan = DataTempatDilahirkan::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataTempatDilahirkan entry with the filtered data
        $dataTempatDilahirkan->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataTempatDilahirkan
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataTempatDilahirkan entry by its ID or fail if not found
        $dataTempatDilahirkan = DataTempatDilahirkan::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataTempatDilahirkan,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataTempatDilahirkan = DataTempatDilahirkan::findOrFail($request->id);
        $dataTempatDilahirkan->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataTempatDilahirkan
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataTempatDilahirkanExcel($request->excel_search), 'data-tempat-dilahirkans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataTempatDilahirkan = DataTempatDilahirkan::get();

        $pdf = Pdf::loadView('pages.data-tempat-dilahirkans.print', compact('dataTempatDilahirkan'));
        return $pdf->download('data-tempat-dilahirkans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataTempatDilahirkan = DataTempatDilahirkan::get();
        return view('pages.data-tempat-dilahirkans.print' , compact('dataTempatDilahirkan'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataTempatDilahirkan = DataTempatDilahirkan::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataTempatDilahirkan->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataTempatDilahirkan = DataTempatDilahirkan::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataTempatDilahirkan->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataTempatDilahirkan
        ]);
    }
}