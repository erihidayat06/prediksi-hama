@extends('home.layouts.main')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach ($dataHama as $hama)
                <div class="col">
                    <div class="card shadow-sm border-0 rounded overflow-hidden h-100">
                        <img src="{{ $hama['gambar'] }}" class="card-img-top img-fluid" alt="{{ $hama['nm_hama'] }}"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary fw-bold">{{ $hama['nm_hama'] }}</h5>
                            <p class="card-text mb-1"><strong>Order:</strong> {{ $hama['order'] }}</p>
                            <p class="card-text mb-1"><strong>Suborder:</strong> {{ $hama['suborder'] }}</p>
                            <p class="card-text mb-1"><strong>Families:</strong> {{ $hama['families'] }}</p>
                            <p class="card-text mb-1"><strong>Genus:</strong> {{ $hama['genus'] }}</p>
                            <p class="card-text mb-3"><strong>Species:</strong> {{ $hama['species'] }}</p>
                            {{-- <p class="card-text text-muted">{!! Str::limit($hama['deskripsi'], 100) !!}</p> --}}
                            <button class="btn btn-outline-success mt-auto" data-bs-toggle="modal"
                                data-bs-target="#modalHama{{ $loop->index }}">Detail</button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalHama{{ $loop->index }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $loop->index }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $loop->index }}">{{ $hama['nm_hama'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row align-items-center">
                                    <div class="col-md-5 text-center">
                                        <img src="{{ $hama['gambar'] }}" class="img-fluid rounded shadow-sm"
                                            alt="{{ $hama['nm_hama'] }}">
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="list-unstyled">
                                            <li><strong>Order:</strong> {{ $hama['order'] }}</li>
                                            <li><strong>Suborder:</strong> {{ $hama['suborder'] }}</li>
                                            <li><strong>Families:</strong> {{ $hama['families'] }}</li>
                                            <li><strong>Genus:</strong> {{ $hama['genus'] }}</li>
                                            <li><strong>Species:</strong> {{ $hama['species'] }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                                <p class="mt-3">{!! $hama['deskripsi'] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
