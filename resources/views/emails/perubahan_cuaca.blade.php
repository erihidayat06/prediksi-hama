<!DOCTYPE html>
<html>

<head>
    <title>Peringatan Perubahan Sebaran Hama</title>
</head>

<body>
    <h2>Peringatan Perubahan Sebaran Hama Berdasarkan Cuaca</h2>
    <p>Ada perubahan sebaran hama pada beberapa kecamatan:</p>

    <ul>
        @foreach ($perbandinganWarna as $kecamatan => $perubahan)
            <li><strong>{{ $kecamatan }}</strong></li>
            <ul>
                @foreach ($perubahan as $jenis => $status)
                    <li>{{ ucfirst($jenis) }}: {{ $status }}</li>
                @endforeach
            </ul>
        @endforeach
    </ul>

    <p>Silakan cek lebih lanjut di sistem.</p>
</body>

</html>
