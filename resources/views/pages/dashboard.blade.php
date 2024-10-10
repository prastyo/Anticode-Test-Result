<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:08
 */
?>
@extends('layouts.app', ['title' => __('site.dashboard') ])

@section('content')
    @push('styles')

    @endpush
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">

                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Kelahiran</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalKelahiran }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Penduduk</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPenduduk }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Perangkat</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalPerangkat }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Users</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jenis Kelamin</h4>
                            <div class="d-flex ml-auto">
                                <select name="filter_by_month" id="filter_by_month" class="form-control mr-1" data-chart="jenisKelamin" data-url="jenis-kelamin">
                                    <option value="">{{ __('site.filter_by_month') }}</option>
                                    <option value='01'>{{ __('site.january') }}</option>
                                    <option value='02'>{{ __('site.february') }}</option>
                                    <option value='03'>{{ __('site.march') }}</option>
                                    <option value='04'>{{ __('site.april') }}</option>
                                    <option value='05'>{{ __('site.may') }}</option>
                                    <option value='06'>{{ __('site.june') }}</option>
                                    <option value='07'>{{ __('site.july') }}</option>
                                    <option value='08'>{{ __('site.august') }}</option>
                                    <option value='09'>{{ __('site.september') }}</option>
                                    <option value='10'>{{ __('site.october') }}</option>
                                    <option value='11'>{{ __('site.november') }}</option>
                                    <option value='12'>{{ __('site.december') }}</option>
                                </select>
                                <select name="filter_by_year" id="filter_by_year" class="form-control" data-chart="jenisKelamin" data-url="jenis-kelamin">
                                    <option value="">{{ __('site.filter_by_year') }}</option>
                                    {{-- Loop to generate options for the last 5 years, starting from the current year --}}
                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}" {{ ( date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                        </div>
                        <div class="card-body">
                            <canvas id="jenisKelamin"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jenis Persalinan</h4>
                            <div class="d-flex ml-auto">
                                <select name="filter_by_month" id="filter_by_month" class="form-control mr-1" data-chart="jenisPersalinan" data-url="jenis-persalinan">
                                    <option value="">{{ __('site.filter_by_month') }}</option>
                                    <option value='01'>{{ __('site.january') }}</option>
                                    <option value='02'>{{ __('site.february') }}</option>
                                    <option value='03'>{{ __('site.march') }}</option>
                                    <option value='04'>{{ __('site.april') }}</option>
                                    <option value='05'>{{ __('site.may') }}</option>
                                    <option value='06'>{{ __('site.june') }}</option>
                                    <option value='07'>{{ __('site.july') }}</option>
                                    <option value='08'>{{ __('site.august') }}</option>
                                    <option value='09'>{{ __('site.september') }}</option>
                                    <option value='10'>{{ __('site.october') }}</option>
                                    <option value='11'>{{ __('site.november') }}</option>
                                    <option value='12'>{{ __('site.december') }}</option>
                                </select>
                                <select name="filter_by_year" id="filter_by_year" class="form-control" data-chart="jenisPersalinan" data-url="jenis-persalinan">
                                    <option value="">{{ __('site.filter_by_year') }}</option>
                                    {{-- Loop to generate options for the last 5 years, starting from the current year --}}
                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}" {{ ( date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                        </div>
                        <div class="card-body">
                            <canvas id="jenisPersalinan"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Kawin</h4>
                            <div class="d-flex ml-auto">
                                <select name="filter_by_month" id="filter_by_month" class="form-control mr-1" data-chart="kawin" data-url="kawin">
                                    <option value="">{{ __('site.filter_by_month') }}</option>
                                    <option value='01'>{{ __('site.january') }}</option>
                                    <option value='02'>{{ __('site.february') }}</option>
                                    <option value='03'>{{ __('site.march') }}</option>
                                    <option value='04'>{{ __('site.april') }}</option>
                                    <option value='05'>{{ __('site.may') }}</option>
                                    <option value='06'>{{ __('site.june') }}</option>
                                    <option value='07'>{{ __('site.july') }}</option>
                                    <option value='08'>{{ __('site.august') }}</option>
                                    <option value='09'>{{ __('site.september') }}</option>
                                    <option value='10'>{{ __('site.october') }}</option>
                                    <option value='11'>{{ __('site.november') }}</option>
                                    <option value='12'>{{ __('site.december') }}</option>
                                </select>
                                <select name="filter_by_year" id="filter_by_year" class="form-control" data-chart="kawin" data-url="kawin">
                                    <option value="">{{ __('site.filter_by_year') }}</option>
                                    {{-- Loop to generate options for the last 5 years, starting from the current year --}}
                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}" {{ ( date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                        </div>
                        <div class="card-body">
                            <canvas id="kawin"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Agama</h4>
                            <div class="d-flex ml-auto">
                                <select name="filter_by_month" id="filter_by_month" class="form-control mr-1" data-chart="agama" data-url="agama">
                                    <option value="">{{ __('site.filter_by_month') }}</option>
                                    <option value='01'>{{ __('site.january') }}</option>
                                    <option value='02'>{{ __('site.february') }}</option>
                                    <option value='03'>{{ __('site.march') }}</option>
                                    <option value='04'>{{ __('site.april') }}</option>
                                    <option value='05'>{{ __('site.may') }}</option>
                                    <option value='06'>{{ __('site.june') }}</option>
                                    <option value='07'>{{ __('site.july') }}</option>
                                    <option value='08'>{{ __('site.august') }}</option>
                                    <option value='09'>{{ __('site.september') }}</option>
                                    <option value='10'>{{ __('site.october') }}</option>
                                    <option value='11'>{{ __('site.november') }}</option>
                                    <option value='12'>{{ __('site.december') }}</option>
                                </select>
                                <select name="filter_by_year" id="filter_by_year" class="form-control" data-chart="agama" data-url="agama">
                                    <option value="">{{ __('site.filter_by_year') }}</option>
                                    {{-- Loop to generate options for the last 5 years, starting from the current year --}}
                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}" {{ ( date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                        </div>
                        <div class="card-body">
                            <canvas id="agama"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Penduduk</h4>
                            <div class="d-flex ml-auto">
                                <select name="filter_by_month" id="filter_by_month" class="form-control mr-1" data-chart="penduduk" data-url="penduduk">
                                    <option value="">{{ __('site.filter_by_month') }}</option>
                                    <option value='01'>{{ __('site.january') }}</option>
                                    <option value='02'>{{ __('site.february') }}</option>
                                    <option value='03'>{{ __('site.march') }}</option>
                                    <option value='04'>{{ __('site.april') }}</option>
                                    <option value='05'>{{ __('site.may') }}</option>
                                    <option value='06'>{{ __('site.june') }}</option>
                                    <option value='07'>{{ __('site.july') }}</option>
                                    <option value='08'>{{ __('site.august') }}</option>
                                    <option value='09'>{{ __('site.september') }}</option>
                                    <option value='10'>{{ __('site.october') }}</option>
                                    <option value='11'>{{ __('site.november') }}</option>
                                    <option value='12'>{{ __('site.december') }}</option>
                                </select>
                                <select name="filter_by_year" id="filter_by_year" class="form-control" data-chart="penduduk" data-url="penduduk">
                                    <option value="">{{ __('site.filter_by_year') }}</option>
                                    {{-- Loop to generate options for the last 5 years, starting from the current year --}}
                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}" {{ ( date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                        </div>
                        <div class="card-body">
                            <canvas id="penduduk"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jenis Keuangan</h4>
                            <div class="d-flex ml-auto">
                                <select name="filter_by_month" id="filter_by_month" class="form-control mr-1" data-chart="jenisKeuangan" data-url="jenis-keuangan">
                                    <option value="">{{ __('site.filter_by_month') }}</option>
                                    <option value='01'>{{ __('site.january') }}</option>
                                    <option value='02'>{{ __('site.february') }}</option>
                                    <option value='03'>{{ __('site.march') }}</option>
                                    <option value='04'>{{ __('site.april') }}</option>
                                    <option value='05'>{{ __('site.may') }}</option>
                                    <option value='06'>{{ __('site.june') }}</option>
                                    <option value='07'>{{ __('site.july') }}</option>
                                    <option value='08'>{{ __('site.august') }}</option>
                                    <option value='09'>{{ __('site.september') }}</option>
                                    <option value='10'>{{ __('site.october') }}</option>
                                    <option value='11'>{{ __('site.november') }}</option>
                                    <option value='12'>{{ __('site.december') }}</option>
                                </select>
                                <select name="filter_by_year" id="filter_by_year" class="form-control" data-chart="jenisKeuangan" data-url="jenis-keuangan">
                                    <option value="">{{ __('site.filter_by_year') }}</option>
                                    {{-- Loop to generate options for the last 5 years, starting from the current year --}}
                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}" {{ ( date('Y') == $i) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>
                        </div>
                        <div class="card-body">
                            <canvas id="jenisKeuangan"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
"use strict";

// Jenis Kelamin
var ctx0 = document.getElementById('jenisKelamin').getContext('2d');
var jenisKelamin = new Chart(ctx0, {
    type: 'doughnut',
    data: { // data object here
        labels: [],
        datasets: [{
            label: 'Jenis Kelamin',
            backgroundColor: [],
            data: []
        }]
    },
});

// Jenis Persalinan
var ctx1 = document.getElementById('jenisPersalinan').getContext('2d');
var jenisPersalinan = new Chart(ctx1, {
    type: 'pie',
    data: { // data object here
        labels: [],
        datasets: [{
            label: 'Jenis Persalinan',
            backgroundColor: [],
            data: []
        }]
    },
});

// Kawin
var ctx2 = document.getElementById('kawin').getContext('2d');
var kawin = new Chart(ctx2, {
    type: 'bar',
    data: { // data object here
        labels: [],
        datasets: [{
            label: 'Kawin',
            backgroundColor: [],
            data: []
        }]
    },
});

// Agama
var ctx3 = document.getElementById('agama').getContext('2d');
var agama = new Chart(ctx3, {
    type: 'horizontalBar',
    data: { // data object here
        labels: [],
        datasets: [{
            label: 'Agama',
            backgroundColor: [],
            data: []
        }]
    },
});

// Penduduk
var ctx4 = document.getElementById('penduduk').getContext('2d');
var penduduk = new Chart(ctx4, {
    type: 'line',
    data: { // data object here
        labels: [],
        datasets: [{
            label: 'Penduduk',
            backgroundColor: [],
            data: []
        }]
    },
});

// Jenis Keuangan
var ctx5 = document.getElementById('jenisKeuangan').getContext('2d');
var jenisKeuangan = new Chart(ctx5, {
    type: 'line',
    data: { // data object here
        labels: [],
        datasets: [{
            label: 'Jenis Keuangan',
            backgroundColor: [],
            data: []
        }]
    },
});

// Function to update the chart
function updateChart(chartName, response) {
    // Get the reference to the chart from the window object using the chart name
    const chart = window[chartName];
    // If the chart does not exist, stop the function execution
    if (!chart) return;
    // Update the chart's labels with new labels from the response
    chart.data.labels = response.labels;
    // Check if there is only one dataset in the response
    const isSingleDataset = response.datasets.length === 1;
    // Check if the chart type is not 'pie' or 'doughnut'
    const isNotPieOrDoughnut = !['pie', 'doughnut'].includes(chart.config.type);
    // If there is only one dataset
    if (isSingleDataset) {
        // Update the first dataset's data with the new data from the response
        chart.data.datasets[0].data = response.datasets[0].data;
        // If the chart is not 'pie' or 'doughnut', hide the legend
        if (isNotPieOrDoughnut) {
            chart.options.legend.display = false;
        }
        // If the chart type is 'line', set the background, border colors, and border width
        if (chart.config.type === 'line') {
            Object.assign(chart.data.datasets[0], {
                backgroundColor: getColorPalette(1, 0.2), // Background color with 0.2 transparency
                borderColor: getColorPalette(1), // Border color of the line
                borderWidth: 4 // Thickness of the line border
            });
        } else {
            // For non-line charts, set the background color based on the length of the data
            chart.data.datasets[0].backgroundColor = getColorPalette(response.datasets[0].data.length);
        }
    } else {
        // If there are multiple datasets, map through each dataset and set visual properties
        chart.data.datasets = response.datasets.map((dataset, i) => ({
            ...dataset, // Copy all existing properties from the dataset
            backgroundColor: getColorPalette(response.datasets.length, 0.2)[i], // Set background color with transparency
            borderColor: getColorPalette(response.datasets.length)[i], // Set border color
            borderWidth: 4
        }));
    }
    // If the chart is not 'pie' or 'doughnut', set the grid lines for the x and y axes
    if (isNotPieOrDoughnut) {
        chart.options.scales = {
            xAxes: [{ gridLines: { display: false } }], // Disable grid lines for the x-axis
            yAxes: [{ gridLines: { color: '#f5f5f5' } }] // Set the y-axis grid line color to light gray
        };
    }
    // Update the chart with the new data and settings
    chart.update();
}

// Function to load chart data
function loadChartData(chartElement) {
    const chart = $(chartElement).data('chart');
    const url = $(chartElement).data('url');
    // Get the selected value of the 'filter_by_month' input
    const filterByMonth = $(`#filter_by_month[data-chart="${chart}"]`).val();
    // Get the selected value of the 'filter_by_year' input
    const filterByYear = $(`#filter_by_year[data-chart="${chart}"]`).val();

    $.getJSON('{{ route('dashboard') }}/'+url, { chart, filter_by_month: filterByMonth, filter_by_year: filterByYear })
    // Make an AJAX request (GET) to the specified URL, sending the chart name, month, and year as parameters
        .done(function(response) {
            updateChart(chart, response);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error fetching data:", textStatus, errorThrown);
        });
}

// Event listener for input changes
$(".section-body :input").change(function() {
    loadChartData(this);
});

// Load all charts on page load
$(document).ready(function() {
    // When the document is fully loaded and ready
    var seen = {};
    // Create an empty object 'seen' to track which charts have already been loaded
    $(".section-body :input[data-chart]").each(function() {
        // Select all input elements within '.section-body' that have a 'data-chart' attribute
        // and iterate over each of them
        var txt = $(this).data('chart');
        // Get the value of the 'data-chart' attribute for the current input element
        if (!seen[txt]) {
            // If the chart has not been loaded yet (not present in the 'seen' object)
            loadChartData(this);
            // Call the function to load chart data for the current input element
            seen[txt] = true;
            // Mark this chart as loaded by setting its value to 'true' in the 'seen' object
        }
    });
});

</script>
    @endpush
@endsection
