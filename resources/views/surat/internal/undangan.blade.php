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
            <td>: Undangan {{ $surat->nama_undangan }}</td>
        </tr>
    </table>
    <br>
    
    <p><b>Kepada Yth.</b><br>
    <b>Seluruh Anggota GenBI USN Kolaka</b><br>
    <b>Di -</b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<b>Tempat,</b></p>

    <p><b><i>Assalamualaikum Wr. Wb.</i></b></p>
    
    <p class="text-justify" style="text-indent: 1.25cm;">Sehubungan dengan akan diselenggarakan <b>{{ $surat->nama_undangan }}</b>, oleh pengurus inti GenBI Sulawesi Komisariat Universitas Sembilanbelas November Kolaka Provinsi Sulawesi Tenggara, kami selaku pengurus inti bermaksud untuk memberitahukan kepada seluruh anggota atas akan diselenggarakannya rapat tersebut pada:</p>

    <table style="width: 100%; border: none; margin-left: 1.25cm; margin-bottom: 15px;">
        <tr>
            <td style="width: 25%;">Hari/Tanggal</td>
            <td style="width: 75%;">: {{ $surat->tanggal_kegiatan }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>: {{ $surat->waktu_kegiatan }} WITA</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>: {{ $surat->tempat_kegiatan }}</td>
        </tr>
    </table>

    <p class="text-justify" style="text-indent: 1.25cm;">Demikian surat undangan ini kami sampaikan. Atas perhatian dan kehadiranya, kami ucapkan terima kasih.</p>

    <table style="width: 100%; border: none; margin-top: 15px;">
        <tr>
            <td style="width: 60%;"></td>
            <td style="width: 40%;" class="text-center">Kolaka, {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center" style="padding-top: 5px;">Sekretaris</td>
        </tr>
        <tr>
            <td></td>
            <td style="height: 60px; text-align: center; vertical-align: middle;">
                @if(isset($ttdSekretaris) && $ttdSekretaris)
                    <img src="{{ $ttdSekretaris }}" height="60" style="display: block; margin: 0 auto;">
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="text-center"><b>{{ $sekretaris->name ?? '[Nama Sekretaris]' }}</b></td>
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
