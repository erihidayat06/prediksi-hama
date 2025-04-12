@extends('home.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Desktop: Tabel -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-sm datatable border border-success-subtle">
                    <thead class="table-success">
                        <tr>
                            <th>Hama</th>
                            <th>Insektisida Resisten</th>
                            <th>Insektisida Cross Resisten</th>
                            <th>Saran Insektisida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($panduans as $panduan)
                            <tr>
                                <td>{{ $panduan->bio->nm_hama }}</td>
                                <td>{{ $panduan->insektisida->nm_insektisida ?? '-' }}</td>
                                <td>
                                    @foreach ($panduan->insektisida->cross_resistens_names ?? [] as $index => $name)
                                        <a href="#" class="btn btn-link text-decoration-none p-0" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail-{{ $panduan->id }}-{{ $index }}">
                                            {{ $name }}
                                        </a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($panduan->insektisida->saran_insektisida_names ?? [] as $index => $name)
                                        <a href="#" class="btn btn-link text-decoration-none p-0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail-{{ $panduan->id }}-saran-{{ $index }}">
                                            {{ $name }}
                                        </a>
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile: Kartu -->
            <div class="row d-block d-lg-none">
                @foreach ($panduans as $panduan)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="row g-0">
                                <div class="col-4">
                                    <img src="{{ asset($panduan->bio->gambar) }}" class="img-fluid rounded-start"
                                        alt="Gambar Hama" />
                                </div>
                                <div class="col-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $panduan->bio->nm_hama }}</h5>
                                        <p class="card-text"><strong>Insektisida Resisten:</strong>
                                            {{ $panduan->insektisida->nm_insektisida ?? '-' }}</p>
                                        <p class="card-text">
                                            <strong>Insektisida Cross Resisten:</strong><br>
                                            @foreach ($panduan->insektisida->cross_resistens_names ?? [] as $index => $name)
                                                <a href="#" class="btn btn-link p-0" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail-{{ $panduan->id }}-{{ $index }}">
                                                    {{ $name }}
                                                </a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>
                                        <p class="card-text">
                                            <strong>Saran Insektisida:</strong>
                                            <br>
                                            @foreach ($panduan->insektisida->saran_insektisida_names ?? [] as $index => $name)
                                                <a href="#" class="btn btn-link p-0" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail-{{ $panduan->id }}-saran-{{ $index }}">
                                                    {{ $name }}
                                                </a>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal Looping untuk Cross Resisten -->
        @foreach ($panduans as $panduan)
            @foreach ($panduan->insektisida->cross_resistens_names ?? [] as $index => $name)
                <div class="modal fade" id="modalDetail-{{ $panduan->id }}-{{ $index }}" tabindex="-1"
                    aria-labelledby="modalDetailLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail {{ $name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <strong>Nama Golongan:</strong>
                                <p>{{ $name }}</p>

                                <strong>Bahan:</strong>
                                <p>{!! htmlspecialchars_decode($panduan->insektisida->cross_resistens_bahan[$index] ?? '-') !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        <!-- Modal Looping untuk Saran Insektisida -->
        @foreach ($panduans as $panduan)
            @foreach ($panduan->insektisida->saran_insektisida_names ?? [] as $index => $name)
                <div class="modal fade" id="modalDetail-{{ $panduan->id }}-saran-{{ $index }}" tabindex="-1"
                    aria-labelledby="modalDetailLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail {{ $name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <strong>Nama Golongan:</strong>
                                <p>{{ $name }}</p>

                                <strong>Bahan:</strong>
                                <p>{!! htmlspecialchars_decode($panduan->insektisida->saran_insektisida_bahan[$index] ?? '-') !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
@endsection
