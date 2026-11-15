<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Penghargaan - {{ $tempat }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800;900&family=Montserrat:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background-color: #0f172a;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Top Action Bar */
        .top-bar {
            width: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        .top-bar .title-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .top-bar .badge {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #ffffff;
            font-weight: 800;
            font-size: 11px;
            letter-spacing: 1px;
            padding: 4px 10px;
            border-radius: 8px;
            text-transform: uppercase;
        }

        .top-bar h1 {
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
        }

        .top-bar .btn-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .btn-print {
            background: linear-gradient(135deg, #0284c7, #0369a1);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.35);
        }
        .btn-print:hover {
            background: linear-gradient(135deg, #0369a1, #075985);
            transform: translateY(-1px);
        }

        .btn-word {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }
        .btn-word:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
        }

        /* Container for Certificate */
        .preview-wrapper {
            padding: 30px 20px 50px 20px;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        /* Certificate A4 Landscape Dimensions */
        .cert-container {
            width: 1024px;
            height: 723px;
            position: relative;
            background-image: url('{{ $bgBase64 }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            background-color: #ffffff;
        }

        /* Typography Positioning */
        .cert-nomor {
            position: absolute;
            top: 15.0%;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .cert-title {
            position: absolute;
            top: 17.8%;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Cinzel', 'Times New Roman', serif;
            font-size: 82px;
            font-weight: 900;
            letter-spacing: 8px;
            color: #0b1329;
            line-height: 1;
        }

        .cert-pill-text {
            position: absolute;
            top: 33.3%;
            left: 38.6%;
            width: 22.8%;
            height: 4.3%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 3px;
            color: #0f172a;
            text-transform: uppercase;
        }

        .cert-label {
            position: absolute;
            top: 39.2%;
            left: 0;
            right: 0;
            text-align: center;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 2.5px;
            color: #475569;
            text-transform: uppercase;
        }

        .cert-tempat {
            position: absolute;
            top: 43.6%;
            left: 4%;
            right: 4%;
            text-align: center;
            font-family: 'Cinzel', 'Times New Roman', serif;
            font-size: 50px;
            font-weight: 900;
            color: #0369a1;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cert-desc {
            position: absolute;
            top: 54.3%;
            left: 2%;
            right: 2%;
            text-align: center;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            line-height: 1.6;
            color: #1e293b;
        }

        .cert-desc div {
            white-space: nowrap;
        }

        /* Signatures */
        .sign-col-left {
            position: absolute;
            top: 68.8%;
            left: 20.4%;
            width: 22.6%;
            text-align: center;
        }

        .sign-col-right {
            position: absolute;
            top: 68.8%;
            left: 56.4%;
            width: 22.6%;
            text-align: center;
        }

        .sign-title {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 11.5px;
            font-weight: 800;
            line-height: 1.35;
            color: #0f172a;
            text-transform: uppercase;
        }

        .sign-space {
            height: 95px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign-space img {
            max-height: 85px;
            max-width: 190px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .sign-combo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .sign-combo .sign-stamp {
            max-height: 90px;
            max-width: 90px;
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-right: -22px;
            position: relative;
            z-index: 2;
            opacity: 0.92;
            mix-blend-mode: multiply;
            pointer-events: none;
        }

        .sign-combo .sign-ttd {
            max-height: 85px;
            max-width: 140px;
            width: auto;
            height: auto;
            object-fit: contain;
            position: relative;
            z-index: 1;
            mix-blend-mode: multiply;
        }

        .sign-space img.sign-ttd {
            position: relative;
            z-index: 1;
            mix-blend-mode: multiply;
        }

        .sign-space img.sign-stamp-standalone {
            max-height: 90px;
            max-width: 90px;
            width: 90px;
            height: 90px;
            object-fit: contain;
            mix-blend-mode: multiply;
        }

        .sign-name-left {
            position: absolute;
            top: 87.2%;
            left: 20.4%;
            width: 22.6%;
            text-align: center;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            white-space: nowrap;
        }

        .sign-name-right {
            position: absolute;
            top: 87.2%;
            left: 56.4%;
            width: 22.6%;
            text-align: center;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: 13.5px;
            font-weight: 800;
            color: #0f172a;
            white-space: nowrap;
        }

        /* Print Mode */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body {
                background: none !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .top-bar {
                display: none !important;
            }

            .preview-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                width: 100vw !important;
                height: 100vh !important;
            }

            .cert-container {
                width: 297mm !important;
                height: 210mm !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Action Toolbar (Hidden during Print) -->
    <div class="top-bar">
        <div class="title-box">
            <span class="badge">Sertifikat</span>
            <h1>Pratinjau Sertifikat Sosialisasi - {{ $tempat }}</h1>
        </div>
        <div class="btn-group">
            <a href="{{ route('surat.sosialisasi') }}" class="btn btn-back">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>

            <button type="button" onclick="window.print()" class="btn btn-print">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Certificate Visual Canvas -->
    <div class="preview-wrapper">
        <div class="cert-container">
            <!-- Nomor Surat -->
            <div class="cert-nomor">
                Nomor: {{ $nomor }}
            </div>

            <!-- Judul SERTIFIKAT -->
            <div class="cert-title">
                SERTIFIKAT
            </div>

            <!-- Teks PENGHARGAAN di dalam Gold Pill Background -->
            <div class="cert-pill-text">
                PENGHARGAAN
            </div>

            <!-- Label DIBERIKAN KEPADA : -->
            <div class="cert-label">
                DIBERIKAN KEPADA :
            </div>

            @php
                $cleanTempat = trim($tempat);
                while (preg_match('/^(Kepala\s+Sekolah|Kepala|Sekolah|Rektor|Pimpinan|Ketua|Direktur)\s+/i', $cleanTempat, $matches)) {
                    $cleanTempat = trim(substr($cleanTempat, strlen($matches[0])));
                }
                $displayTempat = !empty($cleanTempat) ? $cleanTempat : $tempat;
                $tempatLen = mb_strlen($displayTempat);
                $tempatSize = $tempatLen > 32 ? '38px' : ($tempatLen > 24 ? '44px' : '50px');
            @endphp

            <!-- Nama Tempat Penerima (Font sama dengan Judul SERTIFIKAT: Cinzel) -->
            <div class="cert-tempat" style="font-size: {{ $tempatSize }};" title="{{ $displayTempat }}">
                {{ $displayTempat }}
            </div>

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

            <!-- Deskripsi Kegiatan (3 Baris Rapi Sesuai Kebijakan) -->
            <div class="cert-desc">
                <div>{!! $line1 !!}</div>
                <div>{!! $line2 !!}</div>
                <div>{!! $line3 !!}</div>
            </div>

            <!-- Tanda Tangan Kiri: Ketua Umum -->
            <div class="sign-col-left">
                <div class="sign-title">
                    KETUA UMUM<br>
                    GENBI SULTRA KOMS. USN KOLAKA
                </div>
                <div class="sign-space">
                    @if(!empty($stempelKetua) && !empty($ttdKetua))
                        <div class="sign-combo">
                            <img class="sign-stamp" src="{{ $stempelKetua }}" alt="Stempel">
                            <img class="sign-ttd" src="{{ $ttdKetua }}" alt="TTD Ketua">
                        </div>
                    @elseif(!empty($ttdKetua))
                        <img class="sign-ttd" src="{{ $ttdKetua }}" alt="TTD Ketua">
                    @elseif(!empty($stempelKetua))
                        <img class="sign-stamp-standalone" src="{{ $stempelKetua }}" alt="Stempel">
                    @endif
                </div>
            </div>
            <div class="sign-name-left">
                {{ $nama_ketua }}
            </div>

            <!-- Tanda Tangan Kanan: Sekretaris Umum -->
            <div class="sign-col-right">
                <div class="sign-title">
                    SEKRETARIS UMUM<br>
                    GENBI SULTRA KOMS. USN KOLAKA
                </div>
                <div class="sign-space">
                    @if(!empty($ttdSekretaris))
                        <img class="sign-ttd" src="{{ $ttdSekretaris }}" alt="TTD Sekretaris">
                    @endif
                </div>
            </div>
            <div class="sign-name-right">
                {{ $nama_sekretaris }}
            </div>
        </div>
    </div>

</body>
</html>
