<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <style>
        @page Section1 {
            size: 21cm 33cm; /* Ukuran Kertas F4 */
            margin: 1cm 1.91cm 1cm 1.91cm;
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
            <td>: Permohonan Kerjasama</td>
        </tr>
    </table>
    
    <p style="margin-top: 10px; margin-bottom: 0;"><b>Kepada Yth.</b><br>
    <b>{{ $surat->nama_tempat ?? '[Nama Instansi]' }}</b><br>
    <b>Di -</b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<b>Tempat,</b></p>
    
    <p style="margin-top: 10px; margin-bottom: 0;"><i>Assalamualaikum Wr.Wb.</i></p>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 10px; margin-bottom: 0;">Teriring salam dan doa kita haturkan kehadirat Tuhan Yang Maha Esa yang masih memberikan kesehatan dan kekuatan kepada kita semua, semoga setiap langkah kaki kita dilindungi oleh-Nya. Aminn.</p>
    
    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 10px; margin-bottom: 0;">Dalam rangka mendukung pelaksanaan <b>{{ $surat->nama_kegiatan ?? '[Nama Kegiatan]' }}</b>, GenBI USN Kolaka bermaksud menjalin kerja sama dengan <b>{{ $surat->nama_tempat ?? '[Nama Instansi]' }}</b>. Kerjasama ini diharapkan dapat menjadi sarana untuk {{ !empty($surat->tujuan_kegiatan) ? rtrim($surat->tujuan_kegiatan, ',. ') : '[Tujuan]' }}, Adapun kegiatan yang dimaksud akan dilaksanakan pada:</p>

    <table style="width: 100%; border: none; margin-left: 1.25cm; margin-top: 8px; margin-bottom: 8px;">
        <tr>
            <td style="width: 25%;">Hari/Tanggal</td>
            <td style="width: 75%;">: {{ $surat->hari_tanggal ?? '[Hari, Tanggal]' }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            @php
                $waktuVal = trim($surat->waktu ?? '');
                if (!empty($waktuVal)) {
                    if (!str_contains(strtolower($waktuVal), 'wita') && !str_contains(strtolower($waktuVal), 'selesai')) {
                        $waktuFormatted = $waktuVal . ' WITA - Selesai.';
                    } elseif (!str_contains(strtolower($waktuVal), 'selesai')) {
                        $waktuFormatted = $waktuVal . ' - Selesai.';
                    } else {
                        $waktuFormatted = $waktuVal;
                    }
                } else {
                    $waktuFormatted = '[Waktu] WITA - Selesai.';
                }
            @endphp
            <td>: {{ $waktuFormatted }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>: {{ $surat->tempat_kegiatan ?? '[Tempat]' }}</td>
        </tr>
    </table>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 5px; margin-bottom: 0;">Sehubungan dengan hal tersebut, kami mengharapkan kesediaan <b>{{ $surat->nama_tempat ?? '[Nama Instansi]' }}</b> untuk dapat berkolaborasi dan mendukung pelaksanaan kegiatan dimaksud. Adapun bentuk kerjasama, teknis pelaksanaan, serta hal-hal lain yang berkaitan dengan kegiatan dapat dikoordinasikan lebih lanjut oleh kedua belah pihak.</p>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 10px; margin-bottom: 0;">Demikian surat ini kami sampaikan. Besar harapan kami agar kerja sama ini dapat terjalin dengan baik dan memberikan manfaat bagi kedua belah pihak. Atas perhatian dan kerja sama yang diberikan, kami ucapkan terima kasih.</p>
    
    <table style="width: 100%; border: none; margin-top: 15px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" class="text-center">Kolaka, {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-center" style="padding-top: 10px;"><b>Hormat Kami,<br>Panitia Pelaksana Kegiatan</b></td>
        </tr>
        <tr>
            <td class="text-center" style="padding-top: 10px;">Ketua Panitia</td>
            <td class="text-center" style="padding-top: 10px;">Sekretaris Panitia</td>
        </tr>
        <tr>
            <td style="height: 60px; text-align: center; vertical-align: bottom;">
                @if(isset($ttdKetuaPanitia) && $ttdKetuaPanitia)
                    <img src="{{ $ttdKetuaPanitia }}" height="60">
                @endif
            </td>
            <td style="height: 60px; text-align: center; vertical-align: bottom;">
                @php
                    $finalStempelPanitia = $stempelPanitia ?? ($stempel ?? null);
                @endphp
                @if(isset($finalStempelPanitia) && $finalStempelPanitia && isset($ttdSekretarisPanitia) && $ttdSekretarisPanitia)
                    <img src="{{ $finalStempelPanitia }}" height="95" style="margin-right: -22px; margin-bottom: -20px; opacity: 0.9; position: relative; z-index: 2; vertical-align: middle;">
                    <img src="{{ $ttdSekretarisPanitia }}" height="60" style="position: relative; z-index: 1; vertical-align: middle;">
                @elseif(isset($ttdSekretarisPanitia) && $ttdSekretarisPanitia)
                    <img src="{{ $ttdSekretarisPanitia }}" height="60" style="position: relative; z-index: 1;">
                @elseif(isset($finalStempelPanitia) && $finalStempelPanitia)
                    <img src="{{ $finalStempelPanitia }}" height="95" style="margin-right: -40px; margin-bottom: -20px; opacity: 0.8; z-index: -1; position: relative;">
                @endif
            </td>
        </tr>
        <tr>
            <td class="text-center"><b>{{ $namaKetuaPanitia ?? ($surat->nama_ketua_panitia ?? '[Nama Ketua Panitia]') }}</b></td>
            <td class="text-center"><b>{{ $namaSekretarisPanitia ?? ($surat->nama_sekretaris_panitia ?? '[Nama Sekretaris Panitia]') }}</b></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center" style="padding-top: 20px;"><b>Mengetahui,<br>Ketua Umum GenBI Sultra<br>Koms. USN Kolaka</b></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 60px; text-align: center; vertical-align: middle;">
                @if(isset($stempelKetua) && $stempelKetua && isset($ttdKetua) && $ttdKetua)
                    <img src="{{ $stempelKetua }}" height="95" style="margin-right: -22px; margin-bottom: -15px; opacity: 0.9; position: relative; z-index: 2; vertical-align: middle;">
                    <img src="{{ $ttdKetua }}" height="60" style="position: relative; z-index: 1; vertical-align: middle;">
                @elseif(isset($ttdKetua) && $ttdKetua)
                    <img src="{{ $ttdKetua }}" height="60" style="display: block; margin: 0 auto;">
                @elseif(isset($stempelKetua) && $stempelKetua)
                    <img src="{{ $stempelKetua }}" height="95" style="display: block; margin: 0 auto; opacity: 0.85;">
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center"><b>{{ $admin->name ?? '[NAMA KETUA UMUM]' }}</b></td>
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
                                <span style="font-size: 10pt; font-style: italic;">Sekretariat Usn: Jl. Pemuda, Gang lorong Ayam Geprek Berkah, Balandete,</span><br>
                                <span style="font-size: 10pt; font-style: italic;">Kec Kolaka, Sulawesi Tenggara. No. Hp: 0823-7285-6787 Email: <span style="color: blue;">genbisultra@gmail.com</span></span>
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
