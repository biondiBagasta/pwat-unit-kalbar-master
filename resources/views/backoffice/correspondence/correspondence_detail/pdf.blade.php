<body style="font-family: 'Times New Roman', serif; font-size: 12pt; color: #000;">

    {{-- =========================================================
        HEADER SURAT
    ========================================================== --}}

    @php
        $logoPath = base_path('public/theme/media/logos/logo-main.png');
    @endphp

    <div style="margin-bottom: 20px;">

        <table style="width: 100%; border-collapse: collapse;">
            <tr>

                {{-- LOGO KIRI --}}
                <td
                    style="
                        width: 20%;
                        vertical-align: middle;
                        text-align: left;
                    "
                >
                    @if (file_exists($logoPath))
                        <img
                            src="{{ $logoPath }}"
                            style="
                                width: 70px;
                                height: auto;
                            "
                        >
                    @endif
                </td>


                {{-- HEADER TENGAH --}}
                <td
                    style="
                        width: 80%;
                        vertical-align: middle;
                        text-align: center;
                        padding-right: 20%;
                    "
                >

                    <div
                        style="
                            font-size: 16pt;
                            font-weight: bold;
                        "
                    >
                        Persatuan Wanita Aneka Tambang
                    </div>

                    <div
                        style="
                            font-size: 14pt;
                            font-weight: bold;
                        "
                    >
                        Unit Kalbar
                    </div>

                    <div
                        style="
                            font-size: 10pt;
                        "
                    >
                        Pontianak, Kalimantan Barat
                    </div>

                </td>

            </tr>
        </table>


        {{-- GARIS HEADER --}}
        <div
            style="
                border-bottom: 2px solid #000;
                margin-top: 8px;
            "
        ></div>

    </div>




    {{-- =========================================================
        INFORMASI SURAT
    ========================================================== --}}
    <table
        style="
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        "
    >

        {{-- NOMOR --}}
        <tr>
            <td
                style="
                    width: 80px;
                    vertical-align: top;
                    padding: 2px 0;
                "
            >
                Nomor
            </td>

            <td
                style="
                    width: 15px;
                    vertical-align: top;
                    padding: 2px 0;
                "
            >
                :
            </td>

            <td
                style="
                    vertical-align: top;
                    padding: 2px 0;
                "
            >
                {{ $data->letter_number ?? '-' }}
            </td>
        </tr>


        {{-- =====================================================
            LAMPIRAN
        ====================================================== --}}
        @if ($data->correspondence_attachments->isEmpty())

            <tr>
                <td
                    style="
                        width: 80px;
                        vertical-align: top;
                        padding: 2px 0;
                    "
                >
                    Lampiran
                </td>

                <td
                    style="
                        width: 15px;
                        vertical-align: top;
                        padding: 2px 0;
                    "
                >
                    :
                </td>

                <td
                    style="
                        vertical-align: top;
                        padding: 2px 0;
                    "
                >
                    {{ $data->attachment ?? '-' }}
                </td>
            </tr>

        @else

            <tr>
                <td
                    style="
                        width: 80px;
                        vertical-align: top;
                        padding: 2px 0;
                    "
                >
                    Lampiran
                </td>

                <td
                    style="
                        width: 15px;
                        vertical-align: top;
                        padding: 2px 0;
                    "
                >
                    :
                </td>

                <td
                    style="
                        vertical-align: top;
                        padding: 2px 0;
                    "
                >

                    @foreach ($data->correspondence_attachments as $ca)

                        {{ $ca->name ?? '-' }} (<a href="{{ storage_path(
                            'app/public/attachments/' . $ca->file_name
                        ) }}" target="_blank">Download</a>)

                        @if (!$loop->last)
                            <br>
                        @endif

                    @endforeach

                </td>
            </tr>

        @endif


        {{-- =====================================================
            PERIHAL
        ====================================================== --}}
        <tr>
            <td
                style="
                    width: 80px;
                    vertical-align: top;
                    padding: 2px 0;
                "
            >
                Perihal
            </td>

            <td
                style="
                    width: 15px;
                    vertical-align: top;
                    padding: 2px 0;
                "
            >
                :
            </td>

            <td
                style="
                    vertical-align: top;
                    padding: 2px 0;
                "
            >
                {{ $data->subject ?? '-' }}
            </td>
        </tr>

    </table>


    {{-- =========================================================
        PENERIMA
    ========================================================== --}}
    <div style="margin-bottom: 25px;">

        <div>
            Yth.
        </div>

        <div>
            <strong>
                {{ $data->recepient_data->full_name ?? '-' }}
            </strong>
        </div>

        <div>
            di Tempat
        </div>

    </div>


    {{-- =========================================================
        PEMBUKA
    ========================================================== --}}
    <p
        style="
            text-align: justify;
            text-indent: 40px;
            margin-top: 0;
            margin-bottom: 15px;
        "
    >
        Dengan hormat,
    </p>


    {{-- =========================================================
        ISI SURAT
    ========================================================== --}}
    <div
        style="
            text-align: justify;
            line-height: 1.5;
        "
    >
        {!! $data->content !!}
    </div>


    {{-- =========================================================
        SIGNATURE
    ========================================================== --}}

    @php
        $signaturePath = null;

        if (!empty($data->signature)) {
            $signaturePath = storage_path(
                'app/public/signatures/' . $data->signature
            );
        }
    @endphp


    <table
        style="
            width: 100%;
            border-collapse: collapse;
            margin-top: 45px;
        "
    >

        <tr>

            {{-- SPACER KIRI --}}
            <td
                style="
                    width: 55%;
                    vertical-align: top;
                "
            >
            </td>


            {{-- SIGNATURE --}}
            <td
                style="
                    width: 45%;
                    text-align: center;
                    vertical-align: top;
                "
            >

                {{-- TANGGAL --}}
                <div>
                    {{ $data->letter_date
                        ? \Carbon\Carbon::parse($data->letter_date)
                            ->translatedFormat('d F Y')
                        : '-'
                    }}
                </div>


                {{-- AREA SIGNATURE --}}
                <div
                    style="
                        height: 100px;
                        text-align: center;
                    "
                >

                    @if (
                        !empty($signaturePath) &&
                        file_exists($signaturePath)
                    )

                        <img
                            src="{{ $signaturePath }}"
                            style="
                                width: 180px;
                                height: auto;
                                max-height: 100px;
                            "
                        >

                    @endif

                </div>


                {{-- NAMA PENGIRIM --}}
                <div
                    style="
                        text-align: center;
                        font-weight: bold;
                    "
                >
                    {{ $data->sender_data->full_name ?? '-' }}
                </div>

            </td>

        </tr>

    </table>

</body>
