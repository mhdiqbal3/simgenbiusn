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
            <td>: Laporan Pemberhentian Anggota GenBI Sultra Komisariat USN Kolaka</td>
        </tr>
    </table>
    
    <p style="margin-top: 15px;"><b>Kepada Yth.</b><br>
    <b>Biro Akademik Universitas Sembilanbelas November Kolaka</b><br>
    <b>Di -</b><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<b>Tempat,</b></p>
    
    <p>Dengan Hormat,</p>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 10px; margin-bottom: 5px;">Sehubungan dengan hasil evaluasi internal Pengurus Generasi Baru Indonesia (GenBI) Komisariat Universitas Sembilanbelas November Kolaka, bersama ini kami menyampaikan usulan pemberhentian anggota GenBI Komisariat USN Kolaka atas:</p>

    <table style="width: 100%; border: none; margin-left: 1.25cm; margin-top: 10px; margin-bottom: 10px;">
        <tr>
            <td style="width: 25%;">Nama</td>
            <td style="width: 75%;">: <b>{{ $surat->nama_anggota }}</b></td>
        </tr>
        <tr>
            <td>Nim</td>
            <td>: {{ $surat->nim_anggota }}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>: {{ $surat->jurusan_anggota }}</td>
        </tr>
    </table>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 5px; margin-bottom: 5px;">Melalui surat ini, kami menginformasikan adanya pemberhentian terhadap anggota GenBI USN Kolaka, keputusan ini telah melalui pertimbangan Pengurus Inti GenBI Komisariat USN Kolaka seta persetujuan dari pembina GenBI Sultra. Bersama surat ini kami lampirkan Surat Pernyataan Sikap dan SP 2 dari yang bersangkutan.</p>

    <p class="text-justify" style="text-indent: 1.25cm; margin-top: 5px; margin-bottom: 5px;">Demikian surat pengantar ini kami sampaikan. Atas perhatian dan dukungan yang diberikan, kami ucapkan terima kasih.</p>
    
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

    <!-- Page Break for SURAT PERNYATAAN SIKAP -->
    <br clear=all style='mso-special-character:line-break;page-break-before:always'>

    <!-- NO KOP SURAT ON THIS PAGE? The PDF shows KOP SURAT AGAIN on page 2! 
         With `mso-header: h1`, the header will automatically repeat on every page in MS Word! -->
    
    <div class="text-center" style="margin-top: 20px; font-weight: bold; text-decoration: underline;">
        SURAT PERNYATAAN SIKAP
    </div>

    <p style="margin-top: 15px;">Saya Yang bertanda tangan di bawah ini:</p>
    <table style="width: 100%; border: none; margin-bottom: 10px;">
        <tr>
            <td style="width: 25%;">Nama</td>
            <td style="width: 75%;">: <b>{{ $surat->nama_anggota }}</b></td>
        </tr>
        <tr>
            <td>Nim</td>
            <td>: {{ $surat->nim_anggota }}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>: {{ $surat->jurusan_anggota }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: Anggota GenBI Sultra Komisariat USN Kolaka Tahun {{ $surat->periode_pengurus }}</td>
        </tr>
    </table>

    <p style="margin-bottom: 5px;">Dengan ini menyatakan dengan sesungguhnya dan penuh kesadaran bahwa:</p>
    <ol style="margin-top: 0; padding-left: 20px; text-align: justify;">
        @php
            $teksSP2 = 'Surat Peringatan 2 (SP 2)';
            if (!empty($surat->alasan_sp2) && !str_contains($surat->alasan_sp2, 'uploads/')) {
                $teksSP2 = $surat->alasan_sp2;
            }
        @endphp
        <li>Saya mengakui bahwa saya bergabung sebagai anggota GenBI Komisariat USN Kolaka selama 1 (satu) tahun, dan tidak menjalankan bentuk penugasan seperti yang tertulis pada {{ $teksSP2 }}.</li>
        <li>Saya menyatakan bahwa saya tidak sanggup lagi berkontribusi bersama GenBI Komisariat USN Kolaka.</li>
        <li>Saya siap mengembalikan seluruh anggaran beasiswa yang telah saya terima, sesuai ketentuan yang berlaku di GenBI Provinsi Sulawesi Tenggara.</li>
        <li>Saya menyatakan bahwa secara sadar selama ini saya memiliki komunikasi yang kurang baik dengan pengurus, sesama anggota, serta pihak terkait di komisariat.</li>
        <li>Saya mengakui bahwa poin kehadiran/absen saya telah sesuai dengan ketentuan untuk mendapatkan Surat Peringatan 2 (SP 2) sebagai konsekuensi dari ketidakdisiplinan saya.</li>
        <li>Saya menyatakan siap menerima seluruh sanksi yang diberikan oleh Bank Indonesia (BI) Kantor Perwakilan (KPw) Sulawesi Tenggara apabila di kemudian hari nama baik komunitas GenBI Komisariat USN Kolaka menjadi kurang baik akibat dampak dari sikap saya selaku anggota. Demikian surat pernyataan ini saya buat dengan penuh kesadaran, tanpa tekanan dari pihak manapun, untuk dapat digunakan sebagaimana mestinya.</li>
    </ol>

    <table style="width: 100%; border: none; margin-top: 15px;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" class="text-center">Kolaka, {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" class="text-center" style="padding-top: 10px;"><b>Yang Membuat Pernyataan,</b></td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td style="height: 60px;"></td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" class="text-center"><b>[{{ $surat->nama_anggota }}]</b></td>
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
