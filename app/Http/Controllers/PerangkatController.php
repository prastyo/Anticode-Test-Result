<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penduduk;
use App\Models\Perangkat;
use App\Models\DataJabatan;
use Illuminate\Http\Request;
use App\Exports\PerangkatExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StorePerangkatRequest;
use App\Http\Requests\UpdatePerangkatRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PerangkatController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_perangkat', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_perangkat', only: ['store']),
            new Middleware('permission:edit_perangkat', only: ['update']),
            new Middleware('permission:delete_perangkat', only: ['delete']),
            new Middleware('permission:trash_perangkat', only: ['purge', 'restore']),
        ];
    }

    public function index(){
        $penduduk       = Penduduk::get();
        $dataJabatan    = DataJabatan::get();

        return view('pages.perangkats.index' , compact('penduduk', 'dataJabatan'));
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the Perangkat model and order by 'id' in descending order
        $perangkat = Perangkat::with(
                            'penduduk:id,nama,nik',
                            'jabatan:id,nama'
                        )->orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $perangkat->onlyTrashed();

        return DataTables::of($perangkat)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', Perangkat::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_perangkat') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_perangkat') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->penduduk_id.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->editColumn('status_pejabat',    function ($item){ return $item->status_pejabat->badge(); })
        ->rawColumns(['status_pejabat','action'])->make(); // Generate the response for DataTables
    }

    public function store(StorePerangkatRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the Perangkat model using the data from the request
        $perangkat = Perangkat::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $perangkat
        ]);
    }

    public function update(UpdatePerangkatRequest $request, $id):JsonResponse
    {
        $perangkat = Perangkat::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the Perangkat entry with the filtered data
        $perangkat->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $perangkat
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the Perangkat entry by its ID or fail if not found
        $perangkat = Perangkat::with(
                            'penduduk:id,nama,nik',
                            'jabatan:id,nama',
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);
        $perangkat->status_pejabat_badge                         = $perangkat->status_pejabat->badge();
        $perangkat->tanggal_keputusan_pengangkatan_original      = Carbon::parse($perangkat->getAttributes()['tanggal_keputusan_pengangkatan'])->format('d-m-Y');
        $perangkat->tanggal_keputusan_pemberhentian_original     = Carbon::parse($perangkat->getAttributes()['tanggal_keputusan_pemberhentian'])->format('d-m-Y');
        return response()->json([
            "data" => $perangkat,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $perangkat = Perangkat::findOrFail($request->id);
        $perangkat->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $perangkat
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new PerangkatExcel($request->excel_search), 'perangkats-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $perangkat = Perangkat::with(
                            'penduduk:id,nama,nik',
                            'jabatan:id,nama'
                        )->get();

        $pdf = Pdf::loadView('pages.perangkats.print', compact('perangkat'));
        return $pdf->download('perangkats-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $perangkat = Perangkat::with(
                            'penduduk:id,nama,nik',
                            'jabatan:id,nama'
                        )->get();
        return view('pages.perangkats.print' , compact('perangkat'));
    }

    public function purge(Request $request):JsonResponse
    {
        $perangkat = Perangkat::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $perangkat->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $perangkat = Perangkat::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $perangkat->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $perangkat
        ]);
    }
}