<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Penduduk;
use App\Models\DataSuku;
use App\Models\DataAgama;
use App\Models\DataKawin;
use App\Models\DataCacat;
use App\Models\DataKursu;
use App\Models\DataBahasa;
use Illuminate\Http\Request;
use App\Models\DataAsuransi;
use App\Models\DataPekerjaan;
use App\Exports\PendudukExcel;
use App\Models\DataPendidikan;
use App\Models\DataAkseptorKb;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DataWarganegara;
use App\Models\DataStatusDasar;
use Yajra\DataTables\DataTables;
use App\Models\DataSakitMenahun;
use Illuminate\Http\JsonResponse;
use App\Models\DataGolonganDarah;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DataHubunganKeluarga;
use App\Http\Requests\StorePendudukRequest;
use App\Http\Requests\UpdatePendudukRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PendudukController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_penduduk', only: ['index', 'show', 'excel', 'pdf']),
            new Middleware('permission:create_penduduk', only: ['store']),
            new Middleware('permission:edit_penduduk', only: ['update']),
            new Middleware('permission:delete_penduduk', only: ['delete']),
            new Middleware('permission:trash_penduduk', only: ['purge', 'restore']),
        ];
    }

    public function index(){
        $dataSuku                = DataSuku::get();
        $dataAgama               = DataAgama::get();
        $dataKawin               = DataKawin::get();
        $dataCacat               = DataCacat::get();
        $dataKursu               = DataKursu::get();
        $dataBahasa              = DataBahasa::get();
        $dataAsuransi            = DataAsuransi::get();
        $dataPekerjaan           = DataPekerjaan::get();
        $dataPendidikan          = DataPendidikan::get();
        $dataAkseptorKb          = DataAkseptorKb::get();
        $dataWarganegara         = DataWarganegara::get();
        $dataStatusDasar         = DataStatusDasar::get();
        $dataSakitMenahun        = DataSakitMenahun::get();
        $dataGolonganDarah       = DataGolonganDarah::get();
        $dataHubunganKeluarga    = DataHubunganKeluarga::get();

        return view('pages.penduduks.index' , compact('dataAgama', 'dataHubunganKeluarga', 'dataPendidikan', 'dataKawin', 'dataAkseptorKb', 'dataPekerjaan', 'dataSakitMenahun', 'dataCacat', 'dataGolonganDarah', 'dataWarganegara', 'dataAsuransi', 'dataStatusDasar', 'dataSuku', 'dataKursu', 'dataBahasa'));
    }

    public function datatables(Request $request):JsonResponse
    {
        // Query the Penduduk model and order by 'id' in descending order
        $penduduk = Penduduk::with(
                            'agama:id,nama',
                            'hubungan_keluarga:id,nama',
                            'pendidikan:id,nama',
                            'kawin:id,nama',
                            'akseptor_kb:id,nama',
                            'pekerjaan:id,nama',
                            'sakit_menahun:id,nama',
                            'cacat:id,nama',
                            'golongan_darah:id,nama',
                            'warganegara:id,nama',
                            'asuransi:id,nama',
                            'status_dasar:id,nama',
                            'suku:id,nama',
                            'kursus:id,nama',
                            'bahasa:id,nama'
                        )->orderBy('id','desc');
        if ($request->has('trash') and $request->trash == 1) $penduduk->onlyTrashed();

        return DataTables::of($penduduk)

        ->addIndexColumn() // Add an index column for numbering rows
        ->with('trashedCount', Penduduk::onlyTrashed()->count())

        ->addColumn('action', function ($item) use ($request){
            $button  = '<div class="btn-group">';

            // Button view detail
            $button .= '<button class="btn btn-sm btn-info mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_detail" title="Detail"><i class="fas fa-search"></i></button>';

            if (Auth::user()->can('edit_penduduk') and $request->has('trash') and $request->trash == 0) { // button edit
                $button .= '<button class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-id="'.$item->id.'" data-target="#modal_edit" title="Edit"><i class="fas fa-pen"></i></button>';
            }

            if (Auth::user()->can('delete_penduduk') and $request->has('trash') and $request->trash == 0) { // Move to trash
                $button .= '<button class="btn btn-sm btn-danger" data-toggle="modal" data-id="'.$item->id.'" data-delete_info ="'.$item->nama.'" data-target="#modal_delete" title="Delete"><i class="fas fa-trash-alt"></i></button>';
            }
            $button .= '</div>';
            return $button;
        })
        ->editColumn('jenis_kelamin',            function ($item){ return $item->jenis_kelamin->badge(); })
        ->editColumn('akte_kelahiran',           function ($item){ return $item->akte_kelahiran->badge(); })
        ->editColumn('status_penduduk',          function ($item){ return $item->status_penduduk->badge(); })
        ->editColumn('identitas_elektronik',     function ($item){ return $item->identitas_elektronik->badge(); })
        ->editColumn('kelainan_fisik_mental',    function ($item){ return $item->kelainan_fisik_mental->badge(); })
        ->rawColumns(['jenis_kelamin','identitas_elektronik','akte_kelahiran','kelainan_fisik_mental','status_penduduk','action'])->make(); // Generate the response for DataTables
    }

    public function store(StorePendudukRequest $request):JsonResponse
    {
        $data = $request->all();

        // Create a new entry in the Penduduk model using the data from the request
        $penduduk = Penduduk::create($data);

        return response()->json([
            'message'   => __('site.insert_success'),
            'data'      => $penduduk
        ]);
    }

    public function update(UpdatePendudukRequest $request, $id):JsonResponse
    {
        $penduduk = Penduduk::findOrFail($id);

        $data = $request->all();
        // Filter the request data to remove any null or empty values
        $filter = array_filter($data);

        // Update the Penduduk entry with the filtered data
        $penduduk->update($filter);

        return response()->json([
            'message'   => __('site.update_success'),
            'data'      => $penduduk
        ]);
    }

    public function show($id):JsonResponse
    {
        // Find the Penduduk entry by its ID or fail if not found
        $penduduk = Penduduk::with(
                            'agama:id,nama',
                            'hubungan_keluarga:id,nama',
                            'pendidikan:id,nama',
                            'kawin:id,nama',
                            'akseptor_kb:id,nama',
                            'pekerjaan:id,nama',
                            'sakit_menahun:id,nama',
                            'cacat:id,nama',
                            'golongan_darah:id,nama',
                            'warganegara:id,nama',
                            'asuransi:id,nama',
                            'status_dasar:id,nama',
                            'suku:id,nama',
                            'kursus:id,nama',
                            'bahasa:id,nama',
                            'created_by:id,name',
                            'updated_by:id,name',
                            'deleted_by:id,name'
                        )->withTrashed()->findOrFail($id);
        $penduduk->jenis_kelamin_badge             = $penduduk->jenis_kelamin->badge();
        $penduduk->akte_kelahiran_badge            = $penduduk->akte_kelahiran->badge();
        $penduduk->status_penduduk_badge           = $penduduk->status_penduduk->badge();
        $penduduk->identitas_elektronik_badge      = $penduduk->identitas_elektronik->badge();
        $penduduk->kelainan_fisik_mental_badge     = $penduduk->kelainan_fisik_mental->badge();
        $penduduk->tanggal_lahir_original          = Carbon::parse($penduduk->getAttributes()['tanggal_lahir'])->format('d-m-Y');
        return response()->json([
            "data" => $penduduk,
        ]);
    }

    public function delete(Request $request):JsonResponse
    {
        $penduduk = Penduduk::findOrFail($request->id);
        $penduduk->delete();

        return response()->json([
            'message'   => __('site.delete_success'),
            'data'      => $penduduk
        ]);
    }

    public function excel(Request $request)
    {
        return Excel::download(new PendudukExcel($request->excel_search), 'penduduks-'.date('d-m-Y').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function pdf()
    {
        $penduduk = Penduduk::with(
                            'agama:id,nama',
                            'hubungan_keluarga:id,nama',
                            'pendidikan:id,nama',
                            'kawin:id,nama',
                            'akseptor_kb:id,nama',
                            'pekerjaan:id,nama',
                            'sakit_menahun:id,nama',
                            'cacat:id,nama',
                            'golongan_darah:id,nama',
                            'warganegara:id,nama',
                            'asuransi:id,nama',
                            'status_dasar:id,nama',
                            'suku:id,nama',
                            'kursus:id,nama',
                            'bahasa:id,nama'
                        )->get();

        $pdf = Pdf::loadView('pages.penduduks.print', compact('penduduk'));
        return $pdf->download('penduduks-'.date('d-m-Y').'.pdf');
    }

    public function print(Request $request)
    {
        $penduduk = Penduduk::with(
                            'agama:id,nama',
                            'hubungan_keluarga:id,nama',
                            'pendidikan:id,nama',
                            'kawin:id,nama',
                            'akseptor_kb:id,nama',
                            'pekerjaan:id,nama',
                            'sakit_menahun:id,nama',
                            'cacat:id,nama',
                            'golongan_darah:id,nama',
                            'warganegara:id,nama',
                            'asuransi:id,nama',
                            'status_dasar:id,nama',
                            'suku:id,nama',
                            'kursus:id,nama',
                            'bahasa:id,nama'
                        )->get();
        return view('pages.penduduks.print' , compact('penduduk'));
    }

    public function purge(Request $request):JsonResponse
    {
        $penduduk = Penduduk::withTrashed()->findOrFail($request->id);
        // Permanently delete an item from the database. This action cannot be undone
        $penduduk->forceDelete();

        return response()->json([
            'message'   => __('site.force_delete_success')
        ]);
    }

    public function restore(Request $request):JsonResponse
    {
        $penduduk = Penduduk::withTrashed()->findOrFail($request->id);
        // Restore an item that was previously deleted
        $penduduk->restore();

        return response()->json([
            'message'   => __('site.restore_success'),
            'data'      => $penduduk
        ]);
    }
}