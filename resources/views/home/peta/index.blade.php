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
                                <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Thrips
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Kutu kebul
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Lalat Buah
                                </li>
                            </ul>
                        @elseif ($tanamanTerpilih == 'padi')
                            <ul class="p-0">
                                <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Wereng
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Penggerek
                                    batang padi

                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Walang
                                    sangit
                                </li>
                            </ul>
                        @else
                            <ul class="p-0">
                                <li class="list-group-item"><i class="bi bi-square-fill merah-text"></i> Thrips
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill hijau-text"></i> Ulat Bawang
                                    Merah
                                </li>
                                <li class="list-group-item"><i class="bi bi-square-fill oren-text"></i> Moler
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
