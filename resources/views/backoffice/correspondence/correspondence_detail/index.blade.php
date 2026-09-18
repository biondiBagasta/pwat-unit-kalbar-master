@extends("backoffice.backoffice_components.body")

@section("page-title")
Detail Surat
@endsection

@section("content")
<div style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; max-width: 800px; margin: 0 auto;">

<!-- KOP SURAT -->
<div style="text-align: center; border-bottom: 3px solid #000; padding-bottom: 8px; margin-bottom: 20px;">
    <div style="font-size: 16pt; font-weight: bold;">
        NAMA INSTANSI / ORGANISASI
    </div>
    <div style="font-size: 14pt; font-weight: bold;">
        NAMA UNIT / BAGIAN
    </div>
    <div style="font-size: 10pt;">
        Alamat: Jl. Contoh Alamat No. 123, Kota, Provinsi
    </div>
    <div style="font-size: 10pt;">
        Telp. (000) 123456 &nbsp; | &nbsp; Email: email@example.com
    </div>
</div>

<!-- NOMOR SURAT -->
<table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
    <tr>
        <td style="width: 70px;">Nomor</td>
        <td style="width: 10px;">:</td>
        <td>001/ABC/IX/2026</td>
    </tr>
    <tr>
        <td>Lampiran</td>
        <td>:</td>
        <td>1 (satu) berkas</td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>:</td>
        <td><strong>Permohonan / Pemberitahuan</strong></td>
    </tr>
</table>

<!-- TUJUAN SURAT -->
<div style="margin-bottom: 20px;">
    Yth.<br>
    <strong>Nama Penerima Surat</strong><br>
    Jabatan / Instansi<br>
    di Tempat
</div>

<!-- PEMBUKA -->
<p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
    Dengan hormat,
</p>

<!-- ISI SURAT -->
<p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
    Sehubungan dengan kegiatan yang akan dilaksanakan oleh
    <strong>Nama Instansi / Organisasi</strong>, bersama ini kami
    menyampaikan <strong>isi atau maksud surat</strong>.
</p>

<p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
    Adapun kegiatan tersebut akan dilaksanakan pada:
</p>

<!-- DETAIL KEGIATAN -->
<table style="width: 100%; border-collapse: collapse; margin: 10px 0 20px 40px;">
    <tr>
        <td style="width: 130px; vertical-align: top;">Hari / Tanggal</td>
        <td style="width: 15px; vertical-align: top;">:</td>
        <td>Senin, 21 September 2026</td>
    </tr>
    <tr>
        <td style="vertical-align: top;">Waktu</td>
        <td style="vertical-align: top;">:</td>
        <td>09.00 WIB s.d. selesai</td>
    </tr>
    <tr>
        <td style="vertical-align: top;">Tempat</td>
        <td style="vertical-align: top;">:</td>
        <td>Nama Tempat / Lokasi Kegiatan</td>
    </tr>
    <tr>
        <td style="vertical-align: top;">Acara</td>
        <td style="vertical-align: top;">:</td>
        <td>Nama Kegiatan</td>
    </tr>
</table>

<p style="text-align: justify; text-indent: 40px; margin-bottom: 15px;">
    Demikian surat ini kami sampaikan. Besar harapan kami agar
    Bapak/Ibu dapat memberikan perhatian dan kerja sama sebagaimana
    mestinya. Atas perhatian dan kerja samanya, kami ucapkan terima kasih.
</p>

<!-- PENUTUP -->
<div style="margin-top: 30px; width: 250px; margin-left: auto; text-align: center;">
    <div>
        Kota, 18 September 2026
    </div>
    <div>
        <strong>Jabatan Penandatangan</strong>
    </div>

    <div style="height: 90px;"></div>

    <div>
        <strong><u>Nama Lengkap</u></strong>
    </div>
    <div>
        NIP. ............................
    </div>
</div>

<!-- LAMPIRAN -->
<div style="page-break-before: always; margin-top: 40px;">

    <div style="text-align: center; margin-bottom: 25px;">
        <div style="font-weight: bold; font-size: 14pt;">
            LAMPIRAN
        </div>
        <div style="margin-top: 5px;">
            Surat Nomor: 001/ABC/IX/2026
        </div>
        <div>
            Tanggal: 18 September 2026
        </div>
    </div>

    <div style="margin-bottom: 20px;">
        <strong>DAFTAR LAMPIRAN / RINCIAN KEGIATAN</strong>
    </div>

    <!-- TABEL LAMPIRAN -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
        <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 50px;">
                    No.
                </th>
                <th style="border: 1px solid #000; padding: 8px; text-align: left;">
                    Uraian
                </th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center; width: 120px;">
                    Keterangan
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    1
                </td>
                <td style="border: 1px solid #000; padding: 8px;">
                    Surat / Dokumen Pendukung
                </td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    Terlampir
                </td>
            </tr>

            <tr>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    2
                </td>
                <td style="border: 1px solid #000; padding: 8px;">
                    Daftar Peserta / Data Pendukung
                </td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    Terlampir
                </td>
            </tr>

            <tr>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    3
                </td>
                <td style="border: 1px solid #000; padding: 8px;">
                    Dokumen lainnya
                </td>
                <td style="border: 1px solid #000; padding: 8px; text-align: center;">
                    Terlampir
                </td>
            </tr>
        </tbody>
    </table>

    <!-- CATATAN LAMPIRAN -->
    <p style="text-align: justify;">
        Demikian lampiran ini dibuat sebagai bagian yang tidak terpisahkan
        dari surat tersebut di atas.
    </p>

</div>

@endsection
