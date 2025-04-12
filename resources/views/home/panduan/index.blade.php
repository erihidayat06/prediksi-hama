@extends('home.layouts.main')

@section('content')
    <div class="container">
        <div class="col-lg-5  mx-auto">
            <h2>Panduan Insektisida - {{ $tanaman->nama }}</h2>
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="bio_id" class="form-label">Pilih Hama</label>
                        <select id="bio_id" class="form-select">
                            <option value="">-- Pilih Hama --</option>
                            @foreach ($panduans->pluck('bio')->unique('id') as $bio)
                                <option value="{{ $bio->id }}">{{ $bio->nm_hama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="insektisidaDiv" style="display: none;">
                        <label for="insektisida_id" class="form-label">Insektisida apa yang terakhir anda gunakan?</label>
                        <select id="insektisida_id" class="form-select">
                            <option value="">-- Pilih Insektisida --</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="kondisiDiv">
                        <label for="kondisi" class="form-label">Apakah hama sasaran mati?</label>
                        <select id="kondisi" class="form-select">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Mati">Mati</option>
                            <option value="Tidak">Tidak Mati</option>
                        </select>
                    </div>

                    <div id="hasilArea" class="mt-4"></div>
                </div>

                {{-- Script Section --}}
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    const panduanData = @json($processedPanduans);

                    $(document).ready(function() {
                        $('#bio_id').on('change', function() {
                            const bioId = $(this).val();
                            $('#insektisida_id').empty().append('<option value="">-- Pilih Insektisida --</option>');
                            $('#kondisiDiv').addClass('d-none');
                            $('#hasilArea').empty();

                            if (bioId) {
                                $('#insektisidaDiv').show();

                                panduanData.forEach(p => {
                                    if (p.bio_id == bioId && p.insektisida) {
                                        $('#insektisida_id').append(
                                            `<option value="${p.insektisida_id}" data-panduan-id="${p.id}">${p.insektisida.nm_insektisida}</option>`
                                        );
                                    }
                                });
                            } else {
                                $('#insektisidaDiv').hide();
                            }
                        });

                        $('#insektisida_id').on('change', function() {
                            const val = $(this).val();
                            if (val) {
                                $('#kondisiDiv').removeClass('d-none');
                            } else {
                                $('#kondisiDiv').addClass('d-none');
                                $('#hasilArea').empty();
                            }
                        });

                        $('#kondisi').on('change', function() {
                            const kondisi = $(this).val();
                            const selectedPanduanId = $('#insektisida_id option:selected').data('panduan-id');
                            const panduan = panduanData.find(p => p.id == selectedPanduanId);

                            $('#hasilArea').empty();

                            if (panduan && panduan.insektisida) {
                                let output = '<div class="mt-2">';

                                if (kondisi === 'Mati') {
                                    output += '<strong>Rekomendasi penggunaan insektisida berikutnya:</strong><br>';
                                    (panduan.insektisida.cross_resistens_names || []).forEach((name, index) => {
                                        output +=
                                            `<a href="#" data-bs-toggle="modal" data-bs-target="#modalDetail-${panduan.id}-${index}">${name}</a>`;
                                        if (index !== panduan.insektisida.cross_resistens_names.length - 1)
                                            output += ', ';
                                    });
                                } else if (kondisi === 'Tidak') {
                                    output += '<strong>Rekomendasi penggunaan insektisida berikutnya:</strong><br>';
                                    (panduan.insektisida.saran_insektisida_names || []).forEach((name, index) => {
                                        output +=
                                            `<a href="#" data-bs-toggle="modal" data-bs-target="#modalDetail-${panduan.id}-saran-${index}">${name}</a>`;
                                        if (index !== panduan.insektisida.saran_insektisida_names.length - 1)
                                            output += ', ';
                                    });
                                }

                                output += '</div>';
                                $('#hasilArea').html(output);
                            }
                        });
                    });
                </script>

                {{-- Modals --}}
                @foreach ($processedPanduans as $panduan)
                    @if ($panduan['insektisida'])
                        {{-- Cross Resistens --}}
                        @foreach ($panduan['insektisida']['cross_resistens_names'] as $index => $name)
                            <div class="modal fade" id="modalDetail-{{ $panduan['id'] }}-{{ $index }}" tabindex="-1"
                                aria-labelledby="modalLabel{{ $panduan['id'] }}{{ $index }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $panduan['id'] }}{{ $index }}">
                                                Detail Cross
                                                Resistens</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>Nama Golongan:</strong>
                                            {{ $panduan['insektisida']['cross_resistens_names'][$index] }}<br>
                                            <strong>Bahan Aktif:</strong>
                                            {!! $panduan['insektisida']['cross_resistens_bahan'][$index] ?? '-' !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Saran Insektisida --}}
                        @foreach ($panduan['insektisida']['saran_insektisida_names'] as $index => $name)
                            <div class="modal fade" id="modalDetail-{{ $panduan['id'] }}-saran-{{ $index }}"
                                tabindex="-1" aria-labelledby="modalSaranLabel{{ $panduan['id'] }}{{ $index }}"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="modalSaranLabel{{ $panduan['id'] }}{{ $index }}">Detail
                                                Saran Insektisida</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <strong>Nama Golongan:</strong>
                                            {{ $panduan['insektisida']['saran_insektisida_names'][$index] }}<br>
                                            <strong>Bahan Aktif:</strong>
                                            {!! $panduan['insektisida']['saran_insektisida_bahan'][$index] ?? '-' !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
