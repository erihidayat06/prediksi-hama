<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("loading-overlay").style.display = "none";
    });
</script>

<div class="container">
    <div class="mt-5">
        <h2 class="mb-4 text-center">Perkiraan Penyebaran Hama dari
            {{ \Carbon\Carbon::now()->startOfWeek()->addDays(7)->format('d F Y') }}

        </h2>

        <!-- Input Pencarian -->
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari Kecamatan..." autocomplete="off">

        <!-- Tampilan Desktop: Tabel -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-striped mt-2  border-success-subtle" id="dataTable">
                <thead class="table-success text-center">
                    <tr>
                        <th rowspan="2">Kecamatan</th>
                        <th colspan="3">Suhu (°C)</th>
                        <th colspan="3">Kelambapan (%)</th>
                        <th colspan="3">Curah Hujan (mm/thn)</th>
                        <th colspan="3">Hama</th>
                    </tr>
                    <tr>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Optimum</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Optimum</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th>Optimum</th>
                        <th>Cabai</th>
                        <th>Padi</th>
                        <th>Bawang Merah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataCuaca as $rata_rata)
                        <tr>
                            <td>{{ $rata_rata['kecamatan'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['suhu']['min'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['suhu']['max'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['suhu']['optimum'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['kelembapan']['min'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['kelembapan']['max'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['kelembapan']['optimum'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['curah_hujan']['min'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['curah_hujan']['max'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['curah_hujan']['optimum'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['hama']['cabai'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['hama']['padi'] }}</td>
                            <td>{{ $rata_rata['rata_rata']['hama']['bawang-merah'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tampilan Mobile: Kartu -->
        <div class="d-block d-md-none">
            @foreach ($dataCuaca as $rata_rata)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-center">Kecamatan {{ $rata_rata['kecamatan'] }}</h5>
                        <p><strong>Suhu (°C):</strong> <br>Min: {{ $rata_rata['rata_rata']['suhu']['min'] }},
                            <br> Max: {{ $rata_rata['rata_rata']['suhu']['max'] }},
                            <br>Optimum: {{ $rata_rata['rata_rata']['suhu']['optimum'] }}
                        </p>
                        <p><strong>Kelambapan (%):</strong>
                            <br> Min: {{ $rata_rata['rata_rata']['kelembapan']['min'] }},
                            <br> Max: {{ $rata_rata['rata_rata']['kelembapan']['max'] }},
                            <br> Optimum: {{ $rata_rata['rata_rata']['kelembapan']['optimum'] }}
                        </p>
                        <p><strong>Curah Hujan (mm/thn):</strong> <br>Min:
                            {{ $rata_rata['rata_rata']['curah_hujan']['min'] }},
                            <br> Max: {{ $rata_rata['rata_rata']['curah_hujan']['max'] }},
                            <br> Optimum: {{ $rata_rata['rata_rata']['curah_hujan']['optimum'] }}
                        </p>
                        <p><strong>Hama:</strong> <br> Cabai: {{ $rata_rata['rata_rata']['hama']['cabai'] }},
                            <br> Padi: {{ $rata_rata['rata_rata']['hama']['padi'] }},
                            <br>Bawang Merah: {{ $rata_rata['rata_rata']['hama']['bawang-merah'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif
</div>

<!-- Script untuk Pencarian dengan jQuery -->
<script>
    $(document).ready(function() {
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();

            // Filter untuk tabel (desktop)
            $("#dataTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });

            // Filter untuk kartu (mobile)
            $(".card").filter(function() {
                $(this).toggle($(this).find('.card-title').text().toLowerCase().indexOf(value) >
                    -1);
            });
        });
    });
</script>
