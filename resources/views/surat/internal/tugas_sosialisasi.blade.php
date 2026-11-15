<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        @page Section1 {
            size: 21cm 33cm; /* Ukuran Kertas F4 */
            margin: 1.5cm 1.91cm 1.5cm 1.91cm;
            mso-header-margin: 1.25cm;
            mso-footer-margin: 1.25cm;
            mso-header: h1;
        }
        div.Section1 { page: Section1; }
        table#hrdftrtbl {
            margin: 0in 0in 0in 900in;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: black;
            line-height: 1.15;
        }

        .text-justify {
            text-align: justify;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="Section1">
    <!-- KOP SURAT WILL BE AT THE BOTTOM IN hrdftrtbl -->
    <table style="width: 100%; border: none;">
        <tr>
            <td style="width: 15%;">Nomor</td>
            <td style="width: 85%;">: {{ $surat->nomor_surat_full }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: -</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>: Surat Tugas Sosialisasi {{ $surat->tema_st ?? 'CBPR QRIS PeKA' }}</td>
        </tr>
    </table>
    
    <p style="margin-top: 15px;">Yang bertanda tangan di bawah ini:</p>

    <table style="width: 100%; border: none; margin-left: 1.25cm; margin-bottom: 10px;">
        <tr>
            <td style="width: 25%;">Nama</td>
            <td style="width: 75%;">: <b>{{ $admin->name ?? '[NAMA KETUA UMUM]' }}</b></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: Ketua Umum GenBI Sultra Koms. USN Kolaka</td>
        </tr>
    </table>

    <p style="margin-top: 10px;">dengan ini memberikan tugas kepada:</p>

    <table style="width: 100%; border: none; margin-left: 1.25cm; margin-bottom: 10px;">
        <tr>
            <td style="width: 25%;">Nama</td>
            <td style="width: 75%;">: <b>{{ $surat->anggota_st ?? '[NAMA ANGGOTA]' }}</b></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: {{ $surat->jabatan_st ?? '[Jabatan]' }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            @php
                $divisiSos = trim($surat->divisi_st ?? '');
                if (empty($divisiSos) || $divisiSos === '[Kode Divisi]') {
                    $userAnggota = \App\Models\User::where('name', $surat->anggota_st)->first();
                    if ($userAnggota && !empty($userAnggota->devisi)) {
                        $divisiSos = $userAnggota->devisi;
                    } else {
                        $divisiSos = '-';
                    }
                }
            @endphp
            <td>: {{ $divisiSos }}</td>
        </tr>
    </table>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 15px;">Untuk melaksanakan tugas sebagai <b>{{ $surat->jabatan_st ?? '[Jabatan]' }}</b> pada <b>{{ $surat->kegiatan_st ?? '[Kelompok Sosialisasi]' }}</b> yang diselenggarakan oleh GenBI Sultra Koms. USN Kolaka.</p>
    
    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 15px;">Surat tugas ini diberikan sebagai bentuk penugasan resmi kepada yang bersangkutan untuk berperan aktif dalam perencanaan, persiapan, pelaksanaan, dan evaluasi kegiatan, sesuai dengan tugas dan tanggungjawab yang telah ditetapkan.</p>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 15px;">Demikian surat tugas ini dibuat untuk dapat dilaksanakan dengan penuh tanggung jawab. Atas perhatian, kerjasama, dan dedikasi yang diberikan.</p>

    <table style="width: 100%; border: none; margin-top: 25px;">
        <tr>
            <td style="width: 55%;"></td>
            <td style="width: 45%;" class="text-center">Kolaka, {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center" style="padding-top: 5px;">Ketua Umum,</td>
        </tr>
        <tr>
            <td></td>
            <td style="height: 70px; text-align: center; vertical-align: middle;">
                @php
                    $finalStempel = $stempel ?? ($stempelKetua ?? null);
                @endphp
                @if(isset($finalStempel) && $finalStempel && isset($ttdKetua) && $ttdKetua)
                    <img src="{{ $finalStempel }}" height="95" style="margin-right: -22px; margin-bottom: -15px; opacity: 0.9; position: relative; z-index: 2; vertical-align: middle;">
                    <img src="{{ $ttdKetua }}" height="60" style="position: relative; z-index: 1; vertical-align: middle;">
                @elseif(isset($ttdKetua) && $ttdKetua)
                    <img src="{{ $ttdKetua }}" height="60" style="display: block; margin: 0 auto;">
                @elseif(isset($finalStempel) && $finalStempel)
                    <img src="{{ $finalStempel }}" height="90" style="display: block; margin: 0 auto;">
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center"><b>{{ $admin->name ?? '[NAMA KETUA]' }}</b></td>
        </tr>
    </table>
    </div>

    <!-- Header definition for MS Word -->
    <table id="hrdftrtbl" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <div style="mso-element:header" id="h1">
                    <table style="width: 100%; margin-bottom: 10px; border-collapse: collapse;">
                        <tr>
                            <td width="15%" style="text-align: center; vertical-align: middle; padding-top: 10px; padding-bottom: 0; border-bottom: 4px solid black;">
                                @if (isset($logoL))
                                    <img src="{{ $logoL }}" width="80" style="display: block; margin: 0 auto;">
                                @endif
                            </td>
                            <td width="70%" style="text-align: center; line-height: 1.2; padding-top: 10px; padding-bottom: 0; border-bottom: 4px solid black;">
                                <b style="font-size: 14pt; text-transform: uppercase;">GENERASI BARU INDONESIA (GenBI)</b><br>
                                <b style="font-size: 12pt; text-transform: uppercase;">PROVINSI SULAWESI TENGGARA</b><br>
                                <b style="font-size: 12pt; text-transform: uppercase;">KOMISARIAT USN KOLAKA TAHUN 2026/2027</b><br>
                                <span style="font-size: 10pt; font-style: italic;">Sekretariat Usn: Jl. Pemuda, Gang lorong Ayam Geprek Berkah,</span><br>
                                <span style="font-size: 10pt; font-style: italic;">Balandete, Kec. Kolaka, Kab. Kolaka, Provinsi Sulawesi Tenggara.</span><br>
                                <span style="font-size: 10pt; font-style: italic;">No. Hp: 0823-7285-6787 Email: <span style="color: blue;">genbisultra@gmail.com</span></span>
                            </td>
                            <td width="15%" style="text-align: center; vertical-align: middle; padding-top: 10px; padding-bottom: 0; border-bottom: 4px solid black;">
                                @if (isset($logoR))
                                    <img src="{{ $logoR }}" width="80" style="display: block; margin: 0 auto;">
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
