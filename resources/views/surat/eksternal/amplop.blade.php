<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns:v='urn:schemas-microsoft-com:vml' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <style>
        @page Section1 {
            size: 23cm 11cm; /* Standard long envelope */
            margin: 0.8cm 1cm 0.5cm 1cm;
        }
        div.Section1 { page: Section1; }
        
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
        <!-- KOP SURAT -->
        <table style="width: 100%; margin-bottom: 5px; border-collapse: collapse;">
            <tr>
                <td width="15%" style="text-align: center; vertical-align: middle; padding-bottom: 5px; border-bottom: 4px solid black;">
                    @if (isset($logoL))
                        <img src="{{ $logoL }}" width="80" style="display: block; margin: 0 auto;">
                    @endif
                </td>
                <td width="70%" style="text-align: center; line-height: 1.2; padding-bottom: 5px; border-bottom: 4px solid black;">
                    <b style="font-size: 14pt; text-transform: uppercase;">GENERASI BARU INDONESIA (GenBI)</b><br>
                    <b style="font-size: 12pt; text-transform: uppercase;">PROVINSI SULAWESI TENGGARA</b><br>
                    <b style="font-size: 12pt; text-transform: uppercase;">KOMISARIAT USN KOLAKA TAHUN 2026/2027</b><br>
                    <span style="font-size: 10pt; font-style: italic;">Sekretariat Usn: Jl. Pemuda, Gang lorong Ayam Geprek Berkah, Balandete,</span><br>
                    <span style="font-size: 10pt; font-style: italic;">Kec Kolaka, Sulawesi Tenggara. No. Hp: 0823-7285-6787 Email: <span style="color: blue;">genbisultra@gmail.com</span></span>
                </td>
                <td width="15%" style="text-align: center; vertical-align: middle; padding-bottom: 5px; border-bottom: 4px solid black;">
                    @if (isset($logoR))
                        <img src="{{ $logoR }}" width="80" style="display: block; margin: 0 auto;">
                    @endif
                </td>
            </tr>
        </table>
        
        <table style="width: 100%; border: none; margin-top: 10px;">
            <tr>
                <td style="width: 10%; vertical-align: top;">Nomor</td>
                <td style="width: 90%; vertical-align: top;">: {{ $surat->nomor_surat_full }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Perihal</td>
                <td style="vertical-align: top;">: 
                    @if($surat->jenis_surat == 'Amplop')
                        {{ $surat->nama_kegiatan ?? '[Nama Amplop]' }}
                    @elseif($surat->jenis_surat == 'Permohonan')
                        Permohonan Izin Mengadakan {{ $surat->nama_kegiatan }}
                    @elseif($surat->jenis_surat == 'Peminjaman')
                        Peminjaman {{ $surat->nama_alat }}
                    @elseif($surat->jenis_surat == 'Undangan Eksternal')
                        Undangan Menghadiri Kegiatan
                    @elseif($surat->jenis_surat == 'Undangan Narasumber')
                        Undangan Narasumber
                    @elseif($surat->jenis_surat == 'Kerjasama')
                        Permohonan Kerjasama
                    @else
                        {{ $surat->nama_kegiatan ?? ($surat->jenis_surat ?? '[Nama Amplop]') }}
                    @endif
                </td>
            </tr>
        </table>

        <!-- Right Side Box using VML for rounded corners in Word or fallback table -->
        <table style="width: 100%; margin-top: 15px;">
            <tr>
                <td style="width: 40%;"></td>
                <td style="width: 60%; padding: 5px;">
                    <!--[if mso]>
                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" arcsize="10%" fillcolor="white" strokecolor="black" strokeweight="1.5pt" style="width:300pt;height:90pt;position:relative;">
                        <v:textbox inset="15pt,15pt,15pt,15pt" style="mso-fit-shape-to-text:true;">
                            <div>
                                <b style="font-size:12pt;font-family:'Times New Roman',serif;color:black;">Kepada Yth.</b><br>
                                <b style="font-size:12pt;font-family:'Times New Roman',serif;color:black;">{{ $surat->nama_tempat ?? '[Nama Yang Ditujukan]' }}</b><br>
                                <b style="font-size:12pt;font-family:'Times New Roman',serif;color:black;">Di -</b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;<b style="font-size:12pt;font-family:'Times New Roman',serif;color:black;">Tempat,</b>
                            </div>
                        </v:textbox>
                    </v:roundrect>
                    <![endif]-->
                    <!--[if !mso]><!-->
                    <table style="width: 100%; border-collapse: separate; border: 2px solid black; border-radius: 10px; padding: 15px;">
                        <tr>
                            <td>
                                <b>Kepada Yth.</b><br>
                                <b>{{ $surat->nama_tempat ?? '[Nama Yang Ditujukan]' }}</b><br>
                                <b>Di -</b><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;<b>Tempat,</b>
                            </td>
                        </tr>
                    </table>
                    <!--<![endif]-->
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
