<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penduduk;
use App\Models\Kelahiran;
use Illuminate\Http\Request;
use App\Exports\KelahiranExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Models\DataJenisPersalinan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DataTempatDilahirkan;
use App\Models\DataPenolongKelahiran;
use App\Http\Requests\StoreKelahiranRequest;
use App\Http\Requests\UpdateKelahiranRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class KelahiranController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_kelahiran', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_kelahiran', only: ['store']),
            new Middleware('permission:edit_kelahiran', only: ['update']),
            new Middleware('permission:delete_kelahiran', only: ['delete']),
            new Middleware('permission:trash_kelahiran', only: ['purge', 'restore']),
        ];
    }

    public function index(){
        $penduduk                 = Penduduk::get();
        $dataJenisPersalinan      = DataJenisPersalinan::get();
        $dataTempatDilahirkan     = DataTempatDilahirkan::get();
        $dataPenolongKelahiran    = DataPenolongKelahiran::get();

        return view('pages.kelahirans.index' , compact('penduduk', 'dataJenisPersalinan', 'dataTempatDilahirkan', 'dataPenolongKelahiran'));
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the Kelahiran model and order by 'id' in descending order
        $kelahiran = Kelahiran::with(
                            'ayah:id,nama,nik',
                            'ibu:id,nama,nik',
                            'jenis_persalinan:id,nama',
                            'tempat_dilahirkan:id,nama',
                            'penolong_kelahiran:id,nama'
                        )->orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $kelahiran->onlyTrashed();

        return DataTables::of($kelahiran)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', Kelahiran::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_kelahiran') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_kelahiran') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama_anak.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->editColumn('jenis_kelamin',    function ($item){ return $item->jenis_kelamin->badge(); })
        ->rawColumns(['jenis_kelamin','action'])->make(); // Generate the response for DataTables
    }

    public function store(StoreKelahiranRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the Kelahiran model using the data from the request
        $kelahiran = Kelahiran::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $kelahiran
        ]);
    }

    public function update(UpdateKelahiranRequest $request, $id):JsonResponse
    {
        $kelahiran = Kelahiran::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the Kelahiran entry with the filtered data
        $kelahiran->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $kelahiran
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the Kelahiran entry by its ID or fail if not found
        $kelahiran = Kelahiran::with(
                            'ayah:id,nama,nik',
                            'ibu:id,nama,nik',
                            'jenis_persalinan:id,nama',
                            'tempat_dilahirkan:id,nama',
                            'penolong_kelahiran:id,nama',
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);
        $kelahiran->jenis_kelamin_badge        = $kelahiran->jenis_kelamin->badge();
        $kelahiran->tanggal_lahir_original     = Carbon::parse($kelahiran->getAttributes()['tanggal_lahir'])->format('d-m-Y');
        return response()->json([
            "data" => $kelahiran,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $kelahiran = Kelahiran::findOrFail($request->id);
        $kelahiran->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $kelahiran
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new KelahiranExcel($request->excel_search), 'kelahirans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $kelahiran = Kelahiran::with(
                            'ayah:id,nama,nik',
                            'ibu:id,nama,nik',
                            'jenis_persalinan:id,nama',
                            'tempat_dilahirkan:id,nama',
                            'penolong_kelahiran:id,nama'
                        )->get();

        $pdf = Pdf::loadView('pages.kelahirans.print', compact('kelahiran'));
        return $pdf->download('kelahirans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $kelahiran = Kelahiran::with(
                            'ayah:id,nama,nik',
                            'ibu:id,nama,nik',
                            'jenis_persalinan:id,nama',
                            'tempat_dilahirkan:id,nama',
                            'penolong_kelahiran:id,nama'
                        )->get();
        return view('pages.kelahirans.print' , compact('kelahiran'));
    }

    public function purge(Request $request):JsonResponse
    {
        $kelahiran = Kelahiran::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $kelahiran->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $kelahiran = Kelahiran::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $kelahiran->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $kelahiran
        ]);
    }
}