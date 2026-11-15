<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <style>
        @page Section1 {
            size: 21cm 33cm; /* Ukuran Kertas F4 */
            margin: 1.5cm 1.91cm 1.5cm 1.91cm;
            mso-header-margin: 1.25cm;
            mso-footer-margin: 1.25cm;
            mso-header: h1;
            mso-footer: f1;
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
    </style>
</head>
<body>
    <div class="Section1">
    
    <div style="text-align: center; font-weight: bold; font-size: 14pt; margin-top: 20px; margin-bottom: 20px;">
        DAFTAR KEHADIRAN
    </div>

    <table style="width: 100%; border: none; margin-bottom: 15px;">
        <tr>
            <td style="width: 15%;">Waktu</td>
            <td style="width: 35%;">: {{ $surat->waktu ? (str_contains(strtoupper($surat->waktu), 'WITA') ? $surat->waktu : $surat->waktu . ' WITA') : '[Waktu] WITA' }}</td>
            <td style="width: 15%;">Tempat</td>
            <td style="width: 35%;">: {{ $surat->hari_tanggal ?? $surat->tempat_kegiatan ?? '[Hari, Tanggal]' }}</td>
        </tr>
        <tr>
            <td>Peserta</td>
            <td>: {{ $surat->nama_tempat ?? '[Bebas Isi]' }}</td>
            <td>Agenda</td>
            <td>: {{ $surat->nama_kegiatan ?? '[Nama Kegiatan]' }}</td>
        </tr>
    </table>

    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: center; font-weight: bold; background-color: #ffffff; mso-yfti-firstrow: yes; mso-yfti-tblheader: yes;">
                <td style="width: 8%; text-align: center;">NO</td>
                <td style="width: 36%; text-align: center;">NAMA</td>
                <td style="width: 26%; text-align: center;">NO. HANDPHONE</td>
                <td style="width: 30%; text-align: center;">TANDATANGAN</td>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRows = isset($jumlahBaris) && $jumlahBaris > 0 ? (int)$jumlahBaris : 100;
            @endphp
            @for ($i = 1; $i <= $totalRows; $i++)
            <tr>
                <td style="text-align: center; height: 38px; vertical-align: middle;">{{ $i }}.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    </div>

    <!-- Header & Footer definition for MS Word -->
    <table id="hrdftrtbl" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <!-- Header -->
                <div style="mso-element:header" id="h1">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding-bottom: 4px; border-bottom: 2px solid black;">
                                @if(isset($logoBI) && $logoBI)
                                    <img src="{{ $logoBI }}" width="280" style="display: block;">
                                @else
                                    <b style="font-size: 16pt; color: #1e3a8a;">BANK INDONESIA</b><br>
                                    <b style="font-size: 8pt; color: #1e3a8a;">BANK SENTRAL REPUBLIK INDONESIA</b>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 8pt; line-height: 8pt; font-size: 1pt; mso-line-height-rule: exactly;">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <!-- Footer -->
                <div style="mso-element:footer" id="f1">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="background-color: #3b82f6; color: white; padding: 5px; font-size: 10pt;">
                                Daftar Hadir - Seksi Kehumasan&copy;
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
