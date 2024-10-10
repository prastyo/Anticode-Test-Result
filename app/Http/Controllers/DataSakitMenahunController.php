<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DataSakitMenahun;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataSakitMenahunExcel;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\StoreDataSakitMenahunRequest;
use App\Http\Requests\UpdateDataSakitMenahunRequest;

class DataSakitMenahunController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_data_sakit_menahun', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_data_sakit_menahun', only: ['store']),
            new Middleware('permission:edit_data_sakit_menahun', only: ['update']),
            new Middleware('permission:delete_data_sakit_menahun', only: ['delete']),
            new Middleware('permission:trash_data_sakit_menahun', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.data-sakit-menahuns.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the DataSakitMenahun model and order by 'id' in descending order
        $dataSakitMenahun = DataSakitMenahun::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $dataSakitMenahun->onlyTrashed();

        return DataTables::of($dataSakitMenahun)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', DataSakitMenahun::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_data_sakit_menahun') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_data_sakit_menahun') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })

        ->make(); // Generate the response for DataTables
    }

    public function store(StoreDataSakitMenahunRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the DataSakitMenahun model using the data from the request
        $dataSakitMenahun = DataSakitMenahun::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $dataSakitMenahun
        ]);
    }

    public function update(UpdateDataSakitMenahunRequest $request, $id):JsonResponse
    {
        $dataSakitMenahun = DataSakitMenahun::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the DataSakitMenahun entry with the filtered data
        $dataSakitMenahun->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $dataSakitMenahun
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the DataSakitMenahun entry by its ID or fail if not found
        $dataSakitMenahun = DataSakitMenahun::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);

        return response()->json([
            "data" => $dataSakitMenahun,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $dataSakitMenahun = DataSakitMenahun::findOrFail($request->id);
        $dataSakitMenahun->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $dataSakitMenahun
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new DataSakitMenahunExcel($request->excel_search), 'data-sakit-menahuns-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $dataSakitMenahun = DataSakitMenahun::get();

        $pdf = Pdf::loadView('pages.data-sakit-menahuns.print', compact('dataSakitMenahun'));
        return $pdf->download('data-sakit-menahuns-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $dataSakitMenahun = DataSakitMenahun::get();
        return view('pages.data-sakit-menahuns.print' , compact('dataSakitMenahun'));
    }

    public function purge(Request $request):JsonResponse
    {
        $dataSakitMenahun = DataSakitMenahun::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $dataSakitMenahun->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $dataSakitMenahun = DataSakitMenahun::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $dataSakitMenahun->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $dataSakitMenahun
        ]);
    }
}