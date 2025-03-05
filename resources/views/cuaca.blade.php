<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("loading-overlay").style.display = "none";
    });
</script>

<div class=" mt-5 ">
    <h2 class="mb-4 text-center">Perkiraan Penyebaran Hama dari {{ now()->subDays(14)->format('d F Y') }} s.d
        {{ now()->addDays(7)->format('d F Y') }}</h2>

    <!-- Input untuk Pencarian -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Cari Kecamatan..." autocomplete="off">

    <div class="mt-4 table-responsive">
        <table class="table table-bordered table-striped mt-2" id="dataTable">
            <thead class="table-dark text-center">
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
                @foreach ($dataCuaca as $data => $rata_rata)
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
                        <td>{{ $rata_rata['rata_rata']['hama']['Padi'] }}</td>
                        <td>{{ $rata_rata['rata_rata']['hama']['bawang merah'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            $("#dataTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>
