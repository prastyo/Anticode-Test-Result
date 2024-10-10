<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use App\Exports\KeuanganExcel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreKeuanganRequest;
use App\Http\Requests\UpdateKeuanganRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class KeuanganController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_keuangan', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_keuangan', only: ['store']),
            new Middleware('permission:edit_keuangan', only: ['update']),
            new Middleware('permission:delete_keuangan', only: ['delete']),
            new Middleware('permission:trash_keuangan', only: ['purge', 'restore']),
        ];
    }

    public function index(){

        return view('pages.keuangans.index' );
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the Keuangan model and order by 'id' in descending order
        $keuangan = Keuangan::orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $keuangan->onlyTrashed();

        return DataTables::of($keuangan)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', Keuangan::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_keuangan') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_keuangan') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->tahun_anggaran.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->editColumn('jenis_keuangan',    function ($item){ return $item->jenis_keuangan->badge(); })
        ->rawColumns(['jenis_keuangan','keterangan','action'])->make(); // Generate the response for DataTables
    }

    public function store(StoreKeuanganRequest $request):JsonResponse
    {
        $data = $request->all();
                // Sanitize keterangan using HTML Purifier
        if (isset($data['keterangan'])) {
            $data['keterangan'] = Purifier::clean($data['keterangan']);
        }
        // Create a new entry in the Keuangan model using the data from the request
        $keuangan = Keuangan::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $keuangan
        ]);
    }

    public function update(UpdateKeuanganRequest $request, $id):JsonResponse
    {
        $keuangan = Keuangan::findOrFail($id);
                // Sanitize keterangan using HTML Purifier
        if (isset($data['keterangan'])) {
            $data['keterangan'] = Purifier::clean($data['keterangan']);
        }
        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the Keuangan entry with the filtered data
        $keuangan->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $keuangan
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the Keuangan entry by its ID or fail if not found
        $keuangan = Keuangan::with(
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);
        $keuangan->jenis_keuangan_badge          = $keuangan->jenis_keuangan->badge();
        $keuangan->tanggal_kuitansi_original     = Carbon::parse($keuangan->getAttributes()['tanggal_kuitansi'])->format('d-m-Y');
        return response()->json([
            "data" => $keuangan,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $keuangan = Keuangan::findOrFail($request->id);
        $keuangan->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $keuangan
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new KeuanganExcel($request->excel_search), 'keuangans-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $keuangan = Keuangan::get();

        $pdf = Pdf::loadView('pages.keuangans.print', compact('keuangan'));
        return $pdf->download('keuangans-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $keuangan = Keuangan::get();
        return view('pages.keuangans.print' , compact('keuangan'));
    }

    public function purge(Request $request):JsonResponse
    {
        $keuangan = Keuangan::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $keuangan->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $keuangan = Keuangan::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $keuangan->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $keuangan
        ]);
    }
}