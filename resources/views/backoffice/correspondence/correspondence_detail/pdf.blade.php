<body style="font-family: 'Times New Roman', serif; font-size: 12pt;">

    <div style="text-align: center; margin-bottom: 20px;">
        <div style="font-size: 16pt; font-weight: bold;">
            NAMA INSTANSI
        </div>

        <div style="font-size: 14pt; font-weight: bold;">
            NAMA ORGANISASI / UNIT
        </div>

        <div style="font-size: 10pt;">
            Alamat Instansi, Kota, Provinsi
        </div>

        <hr style="border: 0; border-top: 2px solid #000;">
    </div>

    <table width="100%" style="margin-bottom: 20px;">
        <tr>
            <td width="80">Nomor</td>
            <td width="10">:</td>
            <td>{{ $data->letter_number }}</td>
        </tr>

        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>{{ $data->attachment ?? '-' }}</td>
        </tr>

        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td>{{ $data->subject }}</td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        Yth.<br>
        <strong>{{ $data->recepient_data->full_name ?? '-' }}</strong><br>
        di Tempat
    </div>

    <p style="text-align: justify; text-indent: 40px;">
        Dengan hormat,
    </p>

    <div style="text-align: justify;">
        {!! $data->content !!}
    </div>

    <div style="margin-top: 40px; margin-left: 65%;">
        <div style="text-align: center;">
            {{ $data->letter_date
                ? \Carbon\Carbon::parse($data->letter_date)->translatedFormat('d F Y')
                : '-' }}
        </div>

        <br><br><br>

        <strong>
            {{ $data->sender_data->full_name ?? '-' }}
        </strong>
    </div>

</body>
