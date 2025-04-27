@extends('home.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Grafik Harga Komoditi -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Harga Komoditi</h5>
                        <div id="areaChart"></div>

                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const series = {
                                    "monthDataSeries1": {
                                        "prices": JSON.parse(@json($harga)),
                                        "dates": JSON.parse(@json($tanggal))
                                    }
                                };

                                new ApexCharts(document.querySelector("#areaChart"), {
                                    series: [{
                                        name: "Harga Komoditi",
                                        data: series.monthDataSeries1.prices
                                    }],
                                    chart: {
                                        type: 'area',
                                        height: 350,
                                        zoom: {
                                            enabled: false
                                        }
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        curve: 'smooth'
                                    },
                                    subtitle: {
                                        text: 'Pergerakan Harga',
                                        align: 'left'
                                    },
                                    labels: series.monthDataSeries1.dates,
                                    xaxis: {
                                        type: 'datetime'
                                    },
                                    yaxis: {
                                        opposite: false
                                    },
                                    legend: {
                                        horizontalAlign: 'left'
                                    }
                                }).render();
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- Tabel Harga Komoditi -->
            <div class="col-lg-6 mb-4 table-container">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Data Harga Komoditi</h5>
                        <div class="table-responsive flex-grow-1" style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead class="table-success">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($komoditis as $komoditi)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($komoditi->tanggal)->format('d M Y') }}</td>
                                            <td>Rp {{ number_format($komoditi->harga_provinsi, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <p>Sumber data: Kementrian perdagangan (Kemendag)</p>
    </div>

    <!-- Tambahkan CSS -->
    <style>
        @media (max-width: 768px) {
            .table-container {
                margin-bottom: 200px !important;
            }
        }
    </style>
@endsection
