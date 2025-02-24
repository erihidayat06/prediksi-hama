@extends('layoute.main')

@section('content')
    <h2 class="mb-3">Daftar Hama/Penyakit pada Tanaman</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark text-center">
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Crop</th>
                    <th rowspan="2">Nama Hama/Penyakit</th>
                    <th colspan="3">Suhu (°C)</th>
                    <th colspan="3">Kelembapan (%)</th>
                    <th colspan="3">Curah Hujan (mm/thn)</th>
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="3">1</td>
                    <td rowspan="3">Cabai</td>
                    <td>Thrips SPP</td>
                    <td>10-15</td>
                    <td>35</td>
                    <td>20-30</td>
                    <td>40</td>
                    <td>80</td>
                    <td>50-70</td>
                    <td>600</td>
                    <td>1200</td>
                    <td>800-1000</td>
                </tr>
                <tr>
                    <td>Bemesia Tabacci</td>
                    <td>15</td>
                    <td>35</td>
                    <td>25-30</td>
                    <td>50</td>
                    <td>90</td>
                    <td>60-80</td>
                    <td>500</td>
                    <td>1500</td>
                    <td>800-2000</td>
                </tr>
                <tr>
                    <td>Lalat Buah</td>
                    <td>12</td>
                    <td>35</td>
                    <td>20-28</td>
                    <td>60</td>
                    <td>90</td>
                    <td>70-80</td>
                    <td>600</td>
                    <td>2000</td>
                    <td>1000-1500</td>
                </tr>
                <tr>
                    <td rowspan="4">2</td>
                    <td rowspan="4">Padi</td>
                    <td>Wereng Batang</td>
                    <td>15</td>
                    <td>35</td>
                    <td>25-30</td>
                    <td>60</td>
                    <td>90</td>
                    <td>60-90</td>
                    <td>500</td>
                    <td>2500</td>
                    <td>1200-2000</td>
                </tr>
                <tr>
                    <td>Padi Cokelat</td>
                    <td>18-20</td>
                    <td>35-38</td>
                    <td>26-30</td>
                    <td>60</td>
                    <td>90</td>
                    <td>70-85</td>
                    <td>1000</td>
                    <td>3000</td>
                    <td>1500-2500</td>
                </tr>
                <tr>
                    <td>Penggerek batang padi</td>
                    <td>15</td>
                    <td>35-38</td>
                    <td>25-30</td>
                    <td>60</td>
                    <td>95</td>
                    <td>70-90</td>
                    <td>800</td>
                    <td>2000</td>
                    <td>1200-1800</td>
                </tr>
                <tr>
                    <td>Walang sangit</td>
                    <td>18</td>
                    <td>35</td>
                    <td>28-32</td>
                    <td>50</td>
                    <td>90</td>
                    <td>60-80</td>
                    <td>600</td>
                    <td>2500</td>
                    <td>1000-2000</td>
                </tr>
                <tr>
                    <td rowspan="3">3</td>
                    <td rowspan="3">Bawang Merah</td>
                    <td>Thrips tabacci</td>
                    <td>10</td>
                    <td>35</td>
                    <td>25-30</td>
                    <td>40</td>
                    <td>90</td>
                    <td>60-80</td>
                    <td>500</td>
                    <td>1500</td>
                    <td>1200-1500</td>
                </tr>
                <tr>
                    <td>Ulat Bawang Merah</td>
                    <td>13</td>
                    <td>32</td>
                    <td>20-28</td>
                    <td>50</td>
                    <td>90</td>
                    <td>60-80</td>
                    <td>600</td>
                    <td>1800</td>
                    <td>1000-1800</td>
                </tr>
                <tr>
                    <td>Fusarium</td>
                    <td>10</td>
                    <td>35</td>
                    <td>25-30</td>
                    <td>60</td>
                    <td>95</td>
                    <td>80-90</td>
                    <td>800</td>
                    <td>2000</td>
                    <td>1200-1800</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
