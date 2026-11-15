<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns:v='urn:schemas-microsoft-com:vml' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--[if gte mso 9]>
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>100</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <![endif]-->
    <style>
        @page Section1 {
            size: 29.7cm 21.0cm; /* A4 Landscape */
            margin: 0.8cm 1.5cm 0.8cm 1.5cm;
            mso-page-orientation: landscape;
        }
        div.Section1 { 
            page: Section1;
        }
        body {
            font-family: "Arial", sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="Section1">
        <!-- Certificate Header -->
        <div style="text-align: center; margin-top: 15px;">
            <p style="font-size: 11pt; font-weight: bold; margin: 0; color: #1e293b;">Nomor: {{ $nomor }}</p>
            <h1 style="font-family: 'Times New Roman', serif; font-size: 42pt; font-weight: bold; letter-spacing: 5px; margin: 10px 0 5px 0; color: #0b1329;">SERTIFIKAT</h1>
            
            <div style="display: inline-block; background-color: #d97706; padding: 6px 30px; border-radius: 15px; margin: 5px auto;">
                <b style="font-size: 12pt; color: #ffffff; letter-spacing: 2px;">PENGHARGAAN</b>
            </div>
            
            <p style="font-size: 11pt; font-weight: bold; letter-spacing: 1.5px; margin: 15px 0 5px 0; color: #334155;">DIBERIKAN KEPADA :</p>
            
            @php
                $cleanTempat = trim($tempat);
                while (preg_match('/^(Kepala\s+Sekolah|Kepala|Sekolah|Rektor|Pimpinan|Ketua|Direktur)\s+/i', $cleanTempat, $matches)) {
                    $cleanTempat = trim(substr($cleanTempat, strlen($matches[0])));
                }
                $displayTempat = !empty($cleanTempat) ? $cleanTempat : $tempat;
            @endphp
            <h2 style="font-family: 'Times New Roman', serif; font-size: 28pt; font-weight: 900; color: #0369a1; text-transform: uppercase; margin: 8px 0 15px 0; letter-spacing: 2px;">
                {{ $displayTempat }}
            </h2>
            
            @php
                $kebijakanRaw = trim($nama_kebijakan ?? 'CBPR QRIS PeKA');
                $kebijakanUpper = strtoupper($kebijakanRaw);
                $hasCBPR = str_contains($kebijakanUpper, 'CBPR') || str_contains($kebijakanUpper, 'CINTA BANGGA PAHAM RUPIAH');
                $hasQRIS = str_contains($kebijakanUpper, 'QRIS') || str_contains($kebijakanUpper, 'QUICK RESPOND') || str_contains($kebijakanUpper, 'QUICK RESPONSE');
                $hasPeKA = str_contains($kebijakanUpper, 'PEKA') || str_contains($kebijakanUpper, 'PEDULI KENALI ADUKAN');

                if ($hasCBPR && $hasQRIS && $hasPeKA) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi Cinta Bangga Paham Rupiah (CBPR),';
                    $line2 = 'Quick Respond Code Indonesian Standard (QRIS), &amp; Peduli Kenali Adukan (PeKA) oleh GenBI Sultra Komisariat USN Kolaka';
                } elseif ($hasCBPR && $hasQRIS) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi Cinta Bangga Paham Rupiah (CBPR)';
                    $line2 = '&amp; Quick Respond Code Indonesian Standard (QRIS) oleh GenBI Sultra Komisariat USN Kolaka';
                } elseif ($hasQRIS && $hasPeKA) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi Quick Respond Code Indonesian Standard (QRIS)';
                    $line2 = '&amp; Peduli Kenali Adukan (PeKA) oleh GenBI Sultra Komisariat USN Kolaka';
                } elseif ($hasCBPR && $hasPeKA) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi Cinta Bangga Paham Rupiah (CBPR)';
                    $line2 = '&amp; Peduli Kenali Adukan (PeKA) oleh GenBI Sultra Komisariat USN Kolaka';
                } elseif ($hasCBPR) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi';
                    $line2 = 'Cinta Bangga Paham Rupiah (CBPR) oleh GenBI Sultra Komisariat USN Kolaka';
                } elseif ($hasQRIS) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi';
                    $line2 = 'Quick Respond Code Indonesian Standard (QRIS) oleh GenBI Sultra Komisariat USN Kolaka';
                } elseif ($hasPeKA) {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi';
                    $line2 = 'Peduli Kenali Adukan (PeKA) oleh GenBI Sultra Komisariat USN Kolaka';
                } else {
                    $line1 = 'Atas Kerjasamanya Sebagai Tempat Pelaksanaan Kegiatan Sosialiasi ' . e($kebijakanRaw);
                    $line2 = 'oleh GenBI Sultra Komisariat USN Kolaka';
                }
                $line3 = 'Yang Diselenggarakan Pada ' . e($hari_tanggal) . '.';
            @endphp

            <p style="font-size: 11pt; line-height: 1.5; max-width: 90%; margin: 0 auto; color: #1e293b; font-weight: 600;">
                {!! $line1 !!}<br>
                {!! $line2 !!}<br>
                {!! $line3 !!}
            </p>
        </div>

        <!-- Signatures Table -->
        <table style="width: 100%; border: none; margin-top: 45px;">
            <tr>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b style="font-size: 10pt; line-height: 1.3; text-transform: uppercase; color: #0f172a;">
                        KETUA UMUM<br>
                        GENBI SULTRA KOMS. USN KOLAKA
                    </b>
                    <div style="height: 75px; text-align: center; vertical-align: middle; padding: 5px 0;">
                        @if(isset($stempelKetua) && $stempelKetua && isset($ttdKetua) && $ttdKetua)
                            <img src="{{ $stempelKetua }}" height="75" style="margin-right: -20px; opacity: 0.9; position: relative; z-index: 2; vertical-align: middle;">
                            <img src="{{ $ttdKetua }}" height="55" style="position: relative; z-index: 1; vertical-align: middle;">
                        @elseif(isset($ttdKetua) && $ttdKetua)
                            <img src="{{ $ttdKetua }}" height="55" style="display: block; margin: 0 auto;">
                        @elseif(isset($stempelKetua) && $stempelKetua)
                            <img src="{{ $stempelKetua }}" height="75" style="display: block; margin: 0 auto;">
                        @else
                            <br><br><br>
                        @endif
                    </div>
                    <b style="font-size: 11pt; color: #0f172a;">{{ $nama_ketua }}</b>
                </td>
                <td style="width: 50%; text-align: center; vertical-align: top;">
                    <b style="font-size: 10pt; line-height: 1.3; text-transform: uppercase; color: #0f172a;">
                        SEKRETARIS UMUM<br>
                        GENBI SULTRA KOMS. USN KOLAKA
                    </b>
                    <div style="height: 75px; text-align: center; vertical-align: middle; padding: 5px 0;">
                        @if(isset($ttdSekretaris) && $ttdSekretaris)
                            <img src="{{ $ttdSekretaris }}" height="55" style="display: block; margin: 0 auto;">
                        @else
                            <br><br><br>
                        @endif
                    </div>
                    <b style="font-size: 11pt; color: #0f172a;">{{ $nama_sekretaris }}</b>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
