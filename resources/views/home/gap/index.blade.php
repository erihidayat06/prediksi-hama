@extends('home.layouts.main')

@section('content')
    <style>
        .nav-link.active {
            background-color: rgb(17, 90, 32) !important;
            color: #ffffff !important;
        }



        .nav-sticky {
            position: sticky;
            top: 70px;
            max-height: 80vh;
            overflow-y: auto;
            background-color: #f8fff5;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #4CAF50;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .separator {
            border-left: 3px solid #4CAF50;
            height: 100%;
            margin: 0 20px;
        }

        .fw-bold {
            color: #4CAF50;
        }

        .text-secondary-emphasis {
            font-weight: bold;
            color: #757575 !important;
        }

        @media (max-width: 768px) {
            .nav-sticky {
                position: relative;
                max-height: unset;
                overflow-y: unset;
                display: flex;
                flex-wrap: nowrap;
                gap: 10px;
                overflow-x: auto;
                white-space: nowrap;
                padding: 10px;
                border-radius: 0;
                border: none;
                background: #f8fff5;
                margin-bottom: 50px;
                top: 0px;
            }

            .separator {
                display: none;
            }

            .nav-sticky .nav-link {
                flex-shrink: 0;
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>

    <div class="container">
        <div class="mt-1">
            <div class="row">
                <div class="col-md-3">
                    <!-- Navigasi di kiri (akan horizontal di mobile) -->
                    <div class="nav flex-column flex-md-column nav-pills p-3 nav-sticky" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical">
                        @foreach ($tanaman->gaps as $gap)
                            <button class="nav-link text-start fw-bold text-dark {{ $loop->first ? 'active' : '' }}"
                                id="v-pills-home-tab{{ $gap->id }}" data-bs-toggle="pill"
                                data-bs-target="#v-pills-home{{ $gap->id }}" type="button" role="tab"
                                aria-controls="v-pills-home{{ $gap->id }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                <img src="{{ asset($gap->gambar) }}" width="20px" class="me-2" alt="">
                                {{ $gap->kegiatan }}
                            </button>
                        @endforeach
                    </div>
                </div>


                <!-- Konten utama -->
                <div class="col-lg-8 mb-5">
                    <div class="tab-content mb-5" id="v-pills-tabContent">
                        @foreach ($tanaman->gaps as $gap)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="v-pills-home{{ $gap->id }}" role="tabpanel"
                                aria-labelledby="v-pills-home-tab{{ $gap->id }}" tabindex="0">
                                <div class="card p-4">
                                    <div class="card-body">
                                        <img src="{{ asset($gap->gambar) }}" width="50%" class="rounded mb-3"
                                            alt="">
                                        <h2 class="fw-bold"> {{ $gap->kegiatan }}</h2>
                                        <p class="text-secondary-emphasis"> Usia: {{ $gap->usia }}</p>
                                        <div class="text-dark keterangan"> {!! $gap->keterangan !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
