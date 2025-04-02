@extends('home.layouts.main')

@section('content')
    @php
        $tanamanTerpilih = $tanaman->nm_tanaman; // Default 'cabai' jika tidak ada di URL
    @endphp
    <div class="container">

        <div class="row">
            <div class="col">
                @include('peta')
            </div>
            <div class="col-lg-4">
                <div class="card text-start">
                    <div class="card-body">
                        <h3 class="card-title">
                            Prediksi hama !
                        </h3>
                        @if ($tanamanTerpilih == 'cabai')
                            <ul class="p-0">
                                <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Thrips SPP
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Bemesia
                                    Tabacci
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Lalat Buah
                                </li>
                            </ul>
                        @elseif ($tanamanTerpilih == 'Padi')
                            <ul class="p-0">
                                <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Wereng Batang
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Penggerek
                                    batang padi
                                    Tabacci
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Padi Cokelat
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill kuning-text"></i> Walang
                                    sangit
                                </li>
                            </ul>
                        @else
                            <ul class="p-0">
                                <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Thrips
                                    tabacci
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Ulat Bawang
                                    Merah
                                    Tabacci
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Fusarium
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
