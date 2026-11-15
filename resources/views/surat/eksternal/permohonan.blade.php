<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
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
            <td>: Permohonan Izin Mengadakan {{ $surat->nama_kegiatan }}</td>
        </tr>
    </table>
    
    <p style="margin-top: 15px;"><b>Kepada Yth.</b><br>
    <b>{{ $surat->nama_tempat }}</b><br>
    <b>Di -</b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<b>Tempat,</b></p>
    
    <p><i>Assalamualaikum Wr.Wb.</i></p>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 10px; margin-bottom: 5px;">Teriring salam dan doa kita haturkan kehadirat Tuhan Yang Maha Esa yang masih memberikan kesehatan dan kekuatan kepada kita semua, semoga setiap langkah kaki kita dilindugi oleh-Nya. Aminn.</p>
    
    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 5px; margin-bottom: 5px;">Sehubung dengan akan diselenggarakan kegiatan {{ $surat->nama_kegiatan }} oleh Generasi Baru Indonesia (GenBI) Komisariat Universitas SembilanBelas November Kolaka Provinsi Sulawesi Tenggara, kami selaku pengurus bermaksud untuk memberitahukan kepada Bapak/Ibu atas akan diselenggarakannya kegiatan tersebut pada:</p>

    <table style="width: 100%; border: none; margin-left: 1.25cm; margin-top: 10px; margin-bottom: 10px;">
        <tr>
            <td style="width: 25%;">Hari/Tanggal</td>
            <td style="width: 75%;">: {{ $surat->hari_tanggal }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            @php
                $waktuVal = trim($surat->waktu ?? '');
                if (!empty($waktuVal)) {
                    if (!str_contains(strtolower($waktuVal), 'wita') && !str_contains(strtolower($waktuVal), 'selesai')) {
                        $waktuFormatted = $waktuVal . ' WITA - Selesai';
                    } elseif (!str_contains(strtolower($waktuVal), 'selesai')) {
                        $waktuFormatted = $waktuVal . ' - Selesai';
                    } else {
                        $waktuFormatted = $waktuVal;
                    }
                } else {
                    $waktuFormatted = '[Waktu] WITA - Selesai';
                }
            @endphp
            <td>: {{ $waktuFormatted }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>: {{ $surat->tempat_kegiatan }}</td>
        </tr>
    </table>

    <p class="text-justify" style="margin-top: 5px; margin-bottom: 5px;">Maka dengan ini kami mengajukan permohonan Izin untuk kegiatan tersebut sebagaimana terlampir.</p>

    <p class="text-justify" style="margin-top: 5px; margin-bottom: 5px;">Demikianlah Surat permohonan Izin ini kami ajukan dengan harapan dapat dikabulkan. Atas perhatian dan kerjasamanya kami ucapkan terimakasih.</p>
    
    <p><i>Wassalamualaikum Wr. Wb.</i></p>

    <table style="width: 100%; border: none; margin-top: 15px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" class="text-center">Kolaka, {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-center" style="padding-top: 10px;"><b>Hormat Kami,</b></td>
        </tr>
        <tr>
            <td class="text-center" style="padding-top: 10px;"><b>KETUA UMUM GENBI SULTRA</b><br><b>KOMS. USN KOLAKA</b></td>
            <td class="text-center" style="padding-top: 10px;"><b>SEKRETARIS</b></td>
        </tr>
        <tr>
            <td style="height: 60px; text-align: center; vertical-align: middle;">
                @php
                    $finalStempel = $stempelKetua ?? ($stempel ?? null);
                @endphp
                @if(isset($finalStempel) && $finalStempel && isset($ttdKetua) && $ttdKetua)
                    <img src="{{ $finalStempel }}" height="95" style="margin-right: -22px; margin-bottom: -15px; opacity: 0.9; position: relative; z-index: 2; vertical-align: middle;">
                    <img src="{{ $ttdKetua }}" height="60" style="position: relative; z-index: 1; vertical-align: middle;">
                @elseif(isset($ttdKetua) && $ttdKetua)
                    <img src="{{ $ttdKetua }}" height="60" style="display: block; margin: 0 auto;">
                @elseif(isset($finalStempel) && $finalStempel)
                    <img src="{{ $finalStempel }}" height="95" style="display: block; margin: 0 auto; opacity: 0.85;">
                @endif
            </td>
            <td style="height: 60px; text-align: center; vertical-align: middle;">
                @if(isset($ttdSekretaris) && $ttdSekretaris)
                    <img src="{{ $ttdSekretaris }}" height="60" style="display: block; margin: 0 auto;">
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center"><b>{{ $admin->name ?? '[NAMA KETUA UMUM]' }}</b></td>
            <td class="text-center"><b>{{ $sekretaris->name ?? '[NAMA SEKRETARIS]' }}</b></td>
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
