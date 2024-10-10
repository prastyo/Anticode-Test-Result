<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penduduk;
use App\Models\Keuangan;
use App\Models\Kelahiran;
use App\Models\Perangkat;
use App\Models\DataKawin;
use App\Models\DataAgama;
use Illuminate\Http\Request;
use App\Enums\JenisKelaminEnum;
use App\Enums\JenisKeuanganEnum;
use Illuminate\Support\Facades\DB;
use App\Models\DataJenisPersalinan;

class DashboardController extends Controller
{
    protected $select;
    protected $orderBy;
    protected $dateFilter;
    protected $filterByYear;
    protected $filterByMonth;

    public function setFilters(Request $request)
    {
        // Retrieve month and year filters from the request (e.g., '09' for month, '2024' for year)
        $this->filterByMonth    = $request->input('filter_by_month'); // 09
        $this->filterByYear     = $request->input('filter_by_year'); // 2024

        // Set the default filter to the year
        $this->dateFilter   = $this->filterByYear; // default year
        $this->select       = '%Y'; // default select format as year
        $this->orderBy      = '%Y'; // default order by year

        if ($this->filterByYear) {

            // If month filter is also provided
            if ($this->filterByMonth) {

                // Append month to the date filter (year-month format)
                $this->dateFilter .= '-'.$this->filterByMonth; // Year-bulan
                $this->select   = '%d %b'; // Day-month format for selection
                $this->orderBy  = '%Y-%m-%d'; // Order by year-month-day

            } else {
                // If only the year is provided, select month and order by year-month
                $this->select   = '%b'; // Month format for selection
                $this->orderBy  = '%Y-%m'; // Order by year-month
            }
        }
    }

    public function index()
    {
        // Count the total number of records for each entity
        $totalKelahiran = Kelahiran::count();
        $totalPenduduk = Penduduk::count();
        $totalPerangkat = Perangkat::count();
        $totalUsers = User::count();

        // Pass the total counts to the 'dashboard' view using compact()
        return view('pages.dashboard', compact('totalKelahiran', 'totalPenduduk', 'totalPerangkat', 'totalUsers'));
    }

    public function penduduk(Request $request)
    {
        $this->setFilters($request);

        $query = Penduduk::select(
                    DB::raw("(DATE_FORMAT(created_at, '".$this->select."')) AS name"), // Format date as 'name'
                    DB::raw("(DATE_FORMAT(created_at, '".$this->orderBy."')) AS order_by"), // Format date for ordering
                    DB::raw('COUNT(id) AS value')
                )
                ->where('created_at','LIKE',"{$this->dateFilter}%")
                ->groupBy('name', 'order_by')
                ->orderBy('order_by')
                ->get();

        return response()->json([
            'labels'    => $query->pluck('name'),
            'datasets'  => [[
                    'label' => 'penduduk',
                    'data'  => $query->pluck('value'),
            ]],
        ]);
    }

    public function jenisKelamin(Request $request)
    {
        $this->setFilters($request);

        $query = Penduduk::select('jenis_kelamin', DB::raw('count(id) as total'))
                ->where('created_at','LIKE',"{$this->dateFilter}%")
                ->groupBy('jenis_kelamin')
                ->get();

        // Map jenis_kelamin to its label using the Enum
        $labels = $query->pluck('jenis_kelamin')->map(function($jenisKelamin) {
            return JenisKelaminEnum::from($jenisKelamin->value)->label();
        });

        return response()->json([
            'labels'    => $labels,
            'datasets'  => [[
                    'label' => 'jenis_kelamin',
                    'data'  => $query->pluck('total'),
            ]],
        ]);
    }

    public function jenisPersalinan(Request $request)
    {
        $this->setFilters($request);

        $query = DataJenisPersalinan::select('id', 'nama')

                // Use withCount to count the related 'kelahiran' records for each 'DataJenisPersalinan'
                ->withCount(['kelahiran' => function ($query) {
                    $query->where('created_at', 'LIKE', "{$this->dateFilter}%");
                }])
                ->get();

        return response()->json([
            'labels'    => $query->pluck('nama'),
            'datasets'  => [[
                    'label' => 'kelahiran',
                    'data'  => $query->pluck('kelahiran_count'),
            ]],
        ]);
    }
    public function kawin(Request $request)
    {
        $this->setFilters($request);

        $query = DataKawin::select('id', 'nama')

                // Use withCount to count the related 'penduduk' records for each 'DataKawin'
                ->withCount(['penduduk' => function ($query) {
                    $query->where('created_at', 'LIKE', "{$this->dateFilter}%");
                }])
                ->get();

        return response()->json([
            'labels'    => $query->pluck('nama'),
            'datasets'  => [[
                    'label' => 'penduduk',
                    'data'  => $query->pluck('penduduk_count'),
            ]],
        ]);
    }
    public function agama(Request $request)
    {
        $this->setFilters($request);

        $query = DataAgama::select('id', 'nama')

                // Use withCount to count the related 'penduduk' records for each 'DataAgama'
                ->withCount(['penduduk' => function ($query) {
                    $query->where('created_at', 'LIKE', "{$this->dateFilter}%");
                }])
                ->get();

        return response()->json([
            'labels'    => $query->pluck('nama'),
            'datasets'  => [[
                    'label' => 'penduduk',
                    'data'  => $query->pluck('penduduk_count'),
            ]],
        ]);
    }

public function jenisKeuangan(Request $request)
{
    $this->setFilters($request);

    $query = Keuangan::select('jenis_keuangan', DB::raw('SUM(nilai_anggaran) as total'), DB::raw("(DATE_FORMAT(created_at, '".$this->orderBy."')) AS order_by"),)
            ->where('created_at','LIKE',"{$this->dateFilter}%")
            ->groupBy('jenis_keuangan', 'order_by')
            ->orderBy('order_by')
            ->get();

            $labels = [];
            $datasets = [];
            foreach (JenisKeuanganEnum::cases() as $jenisKeuangan) {
                $datasets[$jenisKeuangan->label()] = [];
            }

            foreach ($query as $item) {
                $label = $item->jenis_keuangan->label();

                // Retrieve the order_by value and add it to the labels array if it doesn't already exist
                $order_by = $item->order_by;
                if (!in_array($order_by, $labels)) {
                    $labels[] = $order_by;
                }

                // Add the total to the dataset
                $datasets[$label][] = $item->total;
            }

            // Fill missing data with 0 to ensure all arrays have the same length
            foreach ($datasets as $key => &$dataset) {
                $dataset = array_pad($dataset, count($labels), 0);
            }

            // Format the data for Chart.js
            $chartDatasets = [];
            foreach (JenisKeuanganEnum::cases() as $jenisKeuangan) {
                $label = $jenisKeuangan->label();
                $chartDatasets[] = [
                    'label' => $label,
                    'data'  => $datasets[$label],
                ];
            }

            return response()->json([
                'labels'    => $labels,
                'datasets' => $chartDatasets
            ]);
}
}