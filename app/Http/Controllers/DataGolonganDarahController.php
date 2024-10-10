<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use App\Models\DataGolonganDarah;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataGolonganDarahExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataGolonganDarahRequest;
use App\Http\Requests\UpdateDataGolonganDarahRequest;

class DataGolonganDarahController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_golongan_darah', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_golongan_darah', only: ['store']),
            new Middleware('permission:edit_data_golongan_darah', only: ['update']),
            new Middleware('permission:delete_data_golongan_darah', only: ['delete']),
            new Middleware('permission:trash_data_golongan_darah', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-golongan-darahs.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataGolonganDarah model and order by 'id' in descending order
        $dataGolonganDarah = DataGolonganDarah::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataGolonganDarah->onlyTrashed();

        return DataTables::of($dataGolonganDarah)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataGolonganDarah::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_golongan_darah') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_golongan_darah') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataGolonganDarahRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataGolonganDarah model using the data from the request
        $dataGolonganDarah = DataGolonganDarah::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataGolonganDarah
        ]);
    }

    public function update(UpdateDataGolonganDarahRequest $request, $id):JsonResponse
    {
        $dataGolonganDarah = DataGolonganDarah::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataGolonganDarah entry with the filtered data
        $dataGolonganDarah->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataGolonganDarah
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataGolonganDarah entry by its ID or fail if not found
        $dataGolonganDarah = DataGolonganDarah::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataGolonganDarah,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataGolonganDarah = DataGolonganDarah::findOrFail($request->id);
        $dataGolonganDarah->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataGolonganDarah
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataGolonganDarahExcel($request->excel_search), 'data-golongan-darahs-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataGolonganDarah = DataGolonganDarah::get();

        $pdf = Pdf::loadView('pages.data-golongan-darahs.print', compact('dataGolonganDarah'));
        return $pdf->download('data-golongan-darahs-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataGolonganDarah = DataGolonganDarah::get();
        return view('pages.data-golongan-darahs.print' , compact('dataGolonganDarah'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataGolonganDarah = DataGolonganDarah::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataGolonganDarah->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataGolonganDarah = DataGolonganDarah::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataGolonganDarah->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataGolonganDarah
        ]);
    }
}