@extends('layout.app')

@section('content')
    {{-- ===== HEADER ===== --}}
    <div class="mb-8 animate-fade-in-down flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Surat Eksternal</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar surat eksternal organisasi.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-bold flex items-center gap-3">
            <div class="bg-emerald-500 text-white p-1.5 rounded-full flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            {{ session('success') }}
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold flex flex-col gap-1">
            <div class="flex items-center gap-2 text-red-800">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Gagal menyimpan data surat:</span>
            </div>
            <ul class="list-disc list-inside font-normal text-xs text-red-600 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('download_id'))
        <iframe src="{{ route('surat.eksternal.download', session('download_id')) }}" style="display:none;"></iframe>
    @endif

    {{-- ===== TABEL ===== --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50 relative z-20">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="text-xl font-extrabold text-gray-800">Daftar Surat Eksternal</h2>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button onclick="document.getElementById('modalTemplate').classList.remove('hidden')"
                    class="px-5 py-2.5 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold hover:bg-gray-50 hover:shadow-sm transition-all duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Pilih Template
                </button>
                <button onclick="openAddModal()"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Surat
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="dataTable" class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-gray-100">
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider w-10">No</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Nomor Surat</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Jenis</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Instansi Tujuan / Kepada</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Perihal / Kegiatan</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/80">
                    @foreach($suratEksternals as $i => $surat)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-4 text-sm text-gray-400 font-semibold">{{ $i + 1 }}</td>

                            {{-- Nomor Surat --}}
                            <td class="py-4 px-4">
                                <p class="text-sm font-bold text-gray-800 leading-tight">{{ $surat->nomor_surat_full }}</p>
                            </td>

                            {{-- Jenis Badge --}}
                            <td class="py-4 px-4">
                                @if($surat->jenis_surat == 'SP-3')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> SP-3
                                    </span>
                                @elseif($surat->jenis_surat == 'Permohonan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-indigo-100 text-indigo-700">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span> PERM
                                    </span>
                                @elseif($surat->jenis_surat == 'Peminjaman')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-orange-100 text-orange-700">
                                        <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span> PJM
                                    </span>
                                @elseif(str_contains($surat->jenis_surat, 'Undangan'))
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-blue-100 text-blue-700">
                                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span> UND
                                    </span>
                                @elseif($surat->jenis_surat == 'Kerjasama')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> KER
                                    </span>
                                @elseif($surat->jenis_surat == 'Amplop')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-teal-100 text-teal-700">
                                        <span class="w-1.5 h-1.5 bg-teal-500 rounded-full"></span> AMP
                                    </span>
                                @elseif($surat->jenis_surat == 'Daftar Hadir')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-violet-100 text-violet-700">
                                        <span class="w-1.5 h-1.5 bg-violet-500 rounded-full"></span> DH
                                    </span>
                                @endif
                            </td>

                            {{-- Ditujukan Kepada --}}
                            <td class="py-4 px-4">
                                @if($surat->jenis_surat == 'SP-3')
                                    <p class="text-sm font-bold text-gray-800">Biro Akademik USN Kolaka</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Tembusan: Pembina</p>
                                @elseif($surat->jenis_surat == 'Daftar Hadir')
                                    <p class="text-sm font-bold text-gray-800">Peserta: {{ $surat->nama_tempat ?? 'Bebas Isi' }}</p>
                                @else
                                    <p class="text-sm font-bold text-gray-800">{{ $surat->nama_tempat }}</p>
                                @endif
                            </td>

                            {{-- Perihal --}}
                            <td class="py-4 px-4 max-w-[200px]">
                                @if($surat->jenis_surat == 'SP-3')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Pemberhentian {{ $surat->nama_anggota }}</p>
                                @elseif($surat->jenis_surat == 'Permohonan')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Izin {{ $surat->nama_kegiatan }}</p>
                                @elseif($surat->jenis_surat == 'Peminjaman')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Peminjaman {{ $surat->nama_alat }}</p>
                                @elseif(str_contains($surat->jenis_surat, 'Undangan'))
                                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $surat->jenis_surat }}</p>
                                @elseif($surat->jenis_surat == 'Kerjasama')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Kerjasama {{ $surat->nama_kegiatan }}</p>
                                @elseif($surat->jenis_surat == 'Amplop')
                                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $surat->nama_kegiatan }}</p>
                                @elseif($surat->jenis_surat == 'Daftar Hadir')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Daftar Hadir {{ $surat->nama_kegiatan }}</p>
                                @endif
                            </td>

                            {{-- Tanggal Dibuat --}}
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-600">{{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y') }}</p>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-4 text-center">
                                @php
                                    $perihalAmplop = '';
                                    $tujuanAmplop = $surat->nama_tempat ?? '';
                                    if ($surat->jenis_surat == 'SP-3') {
                                        $perihalAmplop = 'Pemberhentian ' . ($surat->nama_anggota ?? 'Anggota');
                                        $tujuanAmplop = 'Biro Akademik USN Kolaka';
                                    } elseif ($surat->jenis_surat == 'Permohonan') {
                                        $perihalAmplop = 'Permohonan Izin Mengadakan ' . ($surat->nama_kegiatan ?? '');
                                    } elseif ($surat->jenis_surat == 'Peminjaman') {
                                        $perihalAmplop = 'Peminjaman ' . ($surat->nama_alat ?? '');
                                    } elseif ($surat->jenis_surat == 'Undangan Eksternal') {
                                        $perihalAmplop = 'Undangan Menghadiri Kegiatan';
                                    } elseif ($surat->jenis_surat == 'Undangan Narasumber') {
                                        $perihalAmplop = 'Undangan Narasumber';
                                    } elseif ($surat->jenis_surat == 'Kerjasama') {
                                        if ($surat->nama_kegiatan) {
                                            $keg = trim($surat->nama_kegiatan);
                                            if (stripos($keg, 'Kerjasama') !== false) {
                                                $perihalAmplop = 'Permohonan ' . $keg;
                                            } else {
                                                $perihalAmplop = 'Permohonan Kerjasama ' . $keg;
                                            }
                                        } else {
                                            $perihalAmplop = 'Permohonan Kerjasama';
                                        }
                                    } else {
                                        $perihalAmplop = $surat->nama_kegiatan ?? ($surat->jenis_surat ?? 'Amplop Surat');
                                    }
                                @endphp
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('surat.eksternal.download', $surat->id) }}" title="Unduh Surat"
                                        class="p-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>

                                    <button type="button" 
                                        onclick="openAmplopModal({{ $surat->id }}, @js($surat->nomor_surat_full), @js($perihalAmplop), @js($tujuanAmplop))" 
                                        title="Amplop Surat"
                                        class="p-2.5 bg-teal-600 text-white rounded-xl hover:bg-teal-700 hover:shadow-lg hover:shadow-teal-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </button>

                                    @if($surat->jenis_surat == 'Undangan Eksternal')
                                        {{-- Tombol Daftar Kehadiran (Khusus Surat Undangan Kegiatan) --}}
                                        <button type="button" 
                                            onclick="openDaftarHadirModal({{ $surat->id }}, @js($surat->nama_kegiatan), @js($surat->waktu), @js($surat->hari_tanggal), @js($surat->tempat_kegiatan))" 
                                            title="Daftar Kehadiran"
                                            class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                        </button>
                                    @endif

                                    <button type="button" onclick="openEditModal({{ $surat->id }})" title="Edit"
                                        class="p-2.5 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 hover:shadow-lg hover:shadow-yellow-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button type="button" onclick="openDeleteModal('{{ route('surat.eksternal.destroy', $surat->id) }}')" title="Hapus"
                                        class="p-2.5 bg-red-500 text-white rounded-xl hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== MODAL PILIH TEMPLATE ===== --}}
    <div id="modalTemplate" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="document.getElementById('modalTemplate').classList.add('hidden')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg border border-gray-100 max-h-[90vh] flex flex-col">
                <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">Pilih Template Surat Eksternal</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Unduh contoh format surat dalam file Word (.doc)</p>
                    </div>
                    <button onclick="document.getElementById('modalTemplate').classList.add('hidden')" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-3 overflow-y-auto">
                    {{-- SP-3 --}}
                    <a href="{{ route('surat.eksternal.template.download', 'sp3') }}" class="flex items-center gap-4 p-4 border-2 border-red-100 hover:border-red-300 hover:bg-red-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Surat SP-3</p>
                            <p class="text-xs text-gray-400">Format Laporan Pemberhentian Anggota</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Permohonan --}}
                    <a href="{{ route('surat.eksternal.template.download', 'permohonan') }}" class="flex items-center gap-4 p-4 border-2 border-indigo-100 hover:border-indigo-300 hover:bg-indigo-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Surat Permohonan (PERM)</p>
                            <p class="text-xs text-gray-400">Format Permohonan Izin Kegiatan</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Peminjaman --}}
                    <a href="{{ route('surat.eksternal.template.download', 'peminjaman') }}" class="flex items-center gap-4 p-4 border-2 border-orange-100 hover:border-orange-300 hover:bg-orange-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Surat Peminjaman (PJM)</p>
                            <p class="text-xs text-gray-400">Format Peminjaman Barang / Alat</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Undangan Kegiatan --}}
                    <a href="{{ route('surat.eksternal.template.download', 'undangan') }}" class="flex items-center gap-4 p-4 border-2 border-blue-100 hover:border-blue-300 hover:bg-blue-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Surat Undangan (UND)</p>
                            <p class="text-xs text-gray-400">Format Undangan Menghadiri Kegiatan</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Undangan Narasumber --}}
                    <a href="{{ route('surat.eksternal.template.download', 'undangan_narasumber') }}" class="flex items-center gap-4 p-4 border-2 border-cyan-100 hover:border-cyan-300 hover:bg-cyan-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-cyan-100 text-cyan-600 rounded-xl flex items-center justify-center group-hover:bg-cyan-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Surat Undangan Narasumber</p>
                            <p class="text-xs text-gray-400">Format Pemateri / Narasumber Kegiatan</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Kerjasama --}}
                    <a href="{{ route('surat.eksternal.template.download', 'kerjasama') }}" class="flex items-center gap-4 p-4 border-2 border-emerald-100 hover:border-emerald-300 hover:bg-emerald-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Surat Kerjasama (KER)</p>
                            <p class="text-xs text-gray-400">Format Permohonan Kerjasama</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Daftar Hadir --}}
                    <a href="{{ route('surat.eksternal.template.download', 'daftar_hadir') }}" class="flex items-center gap-4 p-4 border-2 border-gray-100 hover:border-gray-300 hover:bg-gray-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-xl flex items-center justify-center group-hover:bg-gray-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Daftar Hadir</p>
                            <p class="text-xs text-gray-400">Format List Peserta / Tamu Undangan</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Amplop --}}
                    <a href="{{ route('surat.eksternal.template.download', 'amplop') }}" class="flex items-center gap-4 p-4 border-2 border-yellow-100 hover:border-yellow-300 hover:bg-yellow-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-xl flex items-center justify-center group-hover:bg-yellow-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Amplop Surat</p>
                            <p class="text-xs text-gray-400">Format Cover Depan Amplop Surat</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-yellow-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL TAMBAH SURAT EKSTERNAL ===== --}}
    <div id="modalTambah" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeAddModal()"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[95vh] flex flex-col border border-gray-100 overflow-hidden">
            
            <div class="px-8 py-5 border-b border-gray-50 flex justify-between items-center bg-white flex-shrink-0 z-10">
                <div>
                    <h3 id="modalTitle" class="text-xl font-extrabold text-gray-800">Buat Surat Eksternal Baru</h3>
                    <p id="modalSubtitle" class="text-xs text-gray-400 mt-0.5">Pilih jenis surat, isi semua data, lalu simpan.</p>
                </div>
                <button type="button" onclick="closeAddModal()" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="overflow-y-auto w-full p-8 pt-6 flex-1">
                <form id="formSuratEksternal" action="{{ route('surat.eksternal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    {{-- Jenis Surat --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Jenis Surat <span class="text-red-500">*</span></label>
                        <select name="jenis_surat" id="jenis_surat" required onchange="toggleFields()" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:border-blue-500 focus:bg-white outline-none transition-colors font-semibold">
                            <option value="">-- Pilih Jenis Surat Eksternal --</option>
                            <option value="SP-3">Surat SP-3 (Pemberhentian Anggota)</option>
                            <option value="Permohonan">Surat Permohonan (Izin Kegiatan)</option>
                            <option value="Peminjaman">Surat Peminjaman (Barang/Alat)</option>
                            <option value="Undangan Eksternal">Surat Undangan (Kegiatan)</option>
                            <option value="Undangan Narasumber">Surat Undangan (Narasumber)</option>
                            <option value="Kerjasama">Surat Kerjasama</option>
                        </select>
                    </div>

                    {{-- Nomor Surat Builder --}}
                    <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5">
                        <label class="block text-[11px] font-black text-blue-600 uppercase tracking-wider mb-3">Penomoran Surat <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap items-center gap-1.5 mb-4">
                            <input type="text" name="ns_no" id="ns_no" value="{{ $nextNo }}" placeholder="{{ $nextNo }}" required class="w-14 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold" oninput="updateNomor()">
                            <span class="text-gray-400 font-bold">/</span>
                            <input type="text" value="B" readonly class="w-10 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-500 outline-none">
                            <span class="text-gray-400 font-bold">/</span>
                            <input type="text" name="ns_kode" id="ns_kode" placeholder="..." readonly class="w-16 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-500 outline-none">
                            <span class="text-gray-400 font-bold">/</span>
                            <input type="text" value="GENBI-KOMS-USN" readonly class="w-36 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-500 outline-none">
                            <span class="text-gray-400 font-bold">/</span>
                            @php
                                $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                                $currentMonthRoman = $romanMonths[date('n') - 1];
                            @endphp
                            <input type="text" name="ns_bulan" id="ns_bulan" value="{{ $currentMonthRoman }}" class="w-14 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold" oninput="updateNomor()">
                            <span class="text-gray-400 font-bold">/</span>
                            <input type="text" name="ns_tahun" id="ns_tahun" value="{{ \Carbon\Carbon::now()->format('Y') }}" class="w-16 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold" oninput="updateNomor()">
                        </div>
                        <input type="hidden" name="nomor_surat_full" id="nomor_surat_full">
                        <p class="text-xs text-gray-500">Hasil: <span id="preview_nomor" class="font-bold text-blue-600 tracking-wide">...</span></p>
                    </div>

                    {{-- Dynamic Fields Container --}}
                    <div id="dynamic_fields" class="space-y-6 hidden">
                        
                        {{-- Peminjaman: Perihal --}}
                        <div id="field_alat" class="hidden">
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Peminjaman (Perihal Surat Utama) <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_alat" id="nama_alat" class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none" placeholder="Contoh: Gedung dan Fasilitas Pendukung">
                        </div>

                        {{-- Umum: Kepada / Instansi Tujuan --}}
                        <div id="field_tujuan" class="hidden">
                            <label id="label_tujuan" class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Instansi Tujuan / Kepada <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_tempat" id="nama_tempat" class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: Rektor USN Kolaka">
                        </div>

                        {{-- Khusus SP-3 --}}
                        <div id="fields_sp3" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4 bg-red-50/30 p-4 rounded-2xl border border-red-100">
                            <div class="col-span-full mb-1">
                                <p class="text-xs font-bold text-red-600 uppercase tracking-wider"><svg class="w-3.5 h-3.5 inline mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> Data SP-3</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Anggota <span class="text-red-500">*</span></label>
                                <select name="nama_anggota" id="nama_anggota" onchange="autoFillSP3()" class="w-full border-gray-200 rounded-lg text-sm p-2.5 focus:border-blue-500 outline-none">
                                    <option value="">-- Pilih Anggota (Dari Data SP) --</option>
                                    @foreach($poins as $poin)
                                        <option value="{{ $poin->nama_lengkap }}"
                                            data-nim="{{ $poin->nim ?? '' }}"
                                            data-jurusan="{{ $poin->jurusan ?? '' }}">
                                            {{ $poin->nama_lengkap }} ({{ $poin->sp }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">NIM <span class="text-red-500">*</span></label>
                                <input type="text" name="nim_anggota" id="nim_anggota" class="w-full border-gray-200 rounded-lg text-sm p-2.5 focus:border-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Jurusan <span class="text-red-500">*</span></label>
                                <input type="text" name="jurusan_anggota" id="jurusan_anggota" class="w-full border-gray-200 rounded-lg text-sm p-2.5 focus:border-blue-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">Periode Pengurus <span class="text-red-500">*</span></label>
                                <input type="text" name="periode_pengurus" id="periode_pengurus" placeholder="2026/2027" class="w-full border-gray-200 rounded-lg text-sm p-2.5 focus:border-blue-500 outline-none">
                            </div>
                                <input type="hidden" name="alasan_sp2" id="alasan_sp2" value="">
                            </div>
                        </div>

                        {{-- Khusus Kegiatan (Selain SP-3) --}}
                        <div id="fields_kegiatan" class="hidden space-y-5">

                            {{-- Pilih dari Halaman Kegiatan (isi otomatis) --}}
                            @if($kegiatans->count() > 0)
                            @php
                                $panitiaTugasMap = [];
                                foreach ($suratTugas->whereNotNull('kegiatan_st')->groupBy('kegiatan_st') as $kegName => $tugasGroup) {
                                    $tugas = $tugasGroup->first();
                                    $ketua = $tugasGroup->first(function($item) {
                                        return trim(strtolower($item->jabatan_st)) === 'ketua panitia';
                                    });
                                    $sekretaris = $tugasGroup->first(function($item) {
                                        return trim(strtolower($item->jabatan_st)) === 'sekretaris panitia';
                                    });
                                    $panitiaTugasMap[trim($kegName)] = [
                                        'tema'       => $tugas->tema_st ?? '',
                                        'ketua'      => $ketua ? $ketua->anggota_st : '',
                                        'sekretaris' => $sekretaris ? $sekretaris->anggota_st : '',
                                    ];
                                }
                            @endphp
                            <div id="wrapper_pilih_kegiatan">
                                <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">
                                    Pilih dari Halaman Kegiatan
                                    <span class="text-gray-400 normal-case font-semibold">(isi otomatis)</span>
                                </label>
                                <select id="pilih_kegiatan_eksternal" onchange="fillKegiatanEksternal(this)"
                                    class="w-full bg-white border-2 border-indigo-100 text-gray-800 text-sm rounded-xl focus:border-indigo-400 block p-3 outline-none font-semibold cursor-pointer">
                                    <option value="">— Pilih kegiatan —</option>
                                    @foreach($kegiatans as $k)
                                        @php
                                            $namaK = trim($k->nama_kegiatan);
                                            $panitiaData = $panitiaTugasMap[$namaK] ?? null;
                                            $temaVal = (!empty($panitiaData['tema'])) ? $panitiaData['tema'] : ($k->tujuan ?? '');
                                            $ketuaVal = $panitiaData['ketua'] ?? '';
                                            $sekretarisVal = $panitiaData['sekretaris'] ?? '';

                                            $tglFormatted = '';
                                            $tglDisplay = '';
                                            if (!empty($k->tanggal)) {
                                                try {
                                                    $tglFormatted = \Carbon\Carbon::parse($k->tanggal)->locale('id')->translatedFormat('l, d F Y');
                                                    $tglDisplay = \Carbon\Carbon::parse($k->tanggal)->locale('id')->isoFormat('D MMM YYYY');
                                                } catch (\Exception $e) {
                                                    $tglFormatted = $k->tanggal;
                                                    $tglDisplay = $k->tanggal;
                                                }
                                            }
                                            $wktFormatted = '';
                                            if (!empty($k->waktu)) {
                                                try {
                                                    $wktFormatted = \Carbon\Carbon::parse($k->waktu)->format('H:i');
                                                } catch (\Exception $e) {
                                                    $wktFormatted = $k->waktu;
                                                }
                                            }
                                        @endphp
                                        <option value="{{ $namaK }}"
                                            data-nama="{{ $namaK }}"
                                            data-tanggal="{{ $tglFormatted }}"
                                            data-waktu="{{ $wktFormatted }}"
                                            data-tempat="{{ $k->tempat ?? '' }}"
                                            data-tema="{{ $temaVal }}"
                                            data-ketua="{{ $ketuaVal }}"
                                            data-sekretaris="{{ $sekretarisVal }}">
                                            {{ $namaK }} — {{ $tglDisplay }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="divider_kegiatan" class="flex items-center gap-2 text-xs text-gray-400">
                                <div class="flex-1 h-px bg-gray-200"></div><span>atau isi manual</span><div class="flex-1 h-px bg-gray-200"></div>
                            </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div id="container_nama_kegiatan">
                                    <label id="label_nama_kegiatan" class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Nama Kegiatan <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_kegiatan" id="input_nama_kegiatan" class="w-full bg-white border border-gray-200 text-sm rounded-xl p-3 focus:border-blue-500 outline-none font-semibold text-gray-700" placeholder="Contoh: GenBI GROW">
                                </div>
                                <div id="field_tema">
                                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Tema Kegiatan <span class="text-[10px] text-gray-400 font-normal lowercase">(otomatis surat tugas / isi manual)</span></label>
                                    <input type="text" name="tema_kegiatan" id="tema_kegiatan" class="w-full bg-gray-50 border border-gray-200 text-sm text-gray-700 font-semibold rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none" placeholder="Otomatis jika ada Surat Tugas, atau ketik tema kegiatan">
                                </div>
                                <div id="field_tujuan_kegiatan" class="hidden col-span-full">
                                    <label id="label_tujuan_kegiatan" class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Tujuan / Dalam Rangka <span class="text-red-500">*</span></label>
                                    <input type="text" name="tujuan_kegiatan" id="tujuan_kegiatan" class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none" placeholder="Contoh: Memperingati Milad GenBI Ke-5">
                                </div>
                                <div id="field_materi" class="hidden col-span-full">
                                    <label class="block text-[11px] font-black text-cyan-600 uppercase tracking-wider mb-1.5">Nama / Topik Materi Narasumber <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_materi" id="nama_materi" class="w-full bg-cyan-50/30 border border-cyan-200 text-sm rounded-xl p-3 focus:bg-white focus:border-cyan-500 outline-none" placeholder="Contoh: Kepemimpinan dan Manajemen Organisasi di Era Digital">
                                </div>
                            </div>
                            
                            <div id="fields_jadwal" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Hari, Tanggal</label>
                                    <input type="text" name="hari_tanggal" id="hari_tanggal" class="w-full bg-white border border-gray-200 text-sm text-gray-700 font-semibold rounded-xl p-3 focus:border-blue-500 outline-none" placeholder="Contoh: Senin, 12 Oktober 2026">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Waktu</label>
                                    <input type="text" name="waktu" id="waktu" class="w-full bg-white border border-gray-200 text-sm text-gray-700 font-semibold rounded-xl p-3 focus:border-blue-500 outline-none" placeholder="Contoh: 08.00">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Tempat</label>
                                    <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" class="w-full bg-white border border-gray-200 text-sm text-gray-700 font-semibold rounded-xl p-3 focus:border-blue-500 outline-none" placeholder="Contoh: Auditorium USN Kolaka">
                                </div>
                            </div>

                            <div id="field_barang" class="hidden">
                                <div class="p-4 border border-blue-100 bg-blue-50/50 rounded-xl">
                                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-3">Daftar Barang / Fasilitas <span class="text-red-500">*</span></label>
                                    <div id="barang_container" class="space-y-3">
                                        <div class="flex gap-3 barang-row">
                                            <input type="text" name="barang_nama[]" placeholder="Nama Barang" class="w-2/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                                            <input type="text" name="barang_jumlah[]" placeholder="Jumlah (Misal: 1 Unit)" class="w-1/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                                            <button type="button" onclick="hapusBarang(this)" class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 hidden btn-hapus-barang">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" onclick="tambahBarang()" class="mt-3 text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Barang Lain
                                    </button>
                                </div>
                            </div>


                            <div id="field_panitia" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <div>
                                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Ketua Panitia <span class="text-[10px] text-gray-400 font-normal lowercase">(otomatis surat tugas / isi manual)</span></label>
                                    <input type="text" name="nama_ketua_panitia" id="nama_ketua_panitia" class="w-full bg-white border border-gray-200 text-sm text-gray-700 font-semibold rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none" placeholder="Otomatis jika ada Surat Tugas, atau isi nama ketua panitia">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Sekretaris Panitia <span class="text-[10px] text-gray-400 font-normal lowercase">(otomatis surat tugas / isi manual)</span></label>
                                    <input type="text" name="nama_sekretaris_panitia" id="nama_sekretaris_panitia" class="w-full bg-white border border-gray-200 text-sm text-gray-700 font-semibold rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none" placeholder="Otomatis jika ada Surat Tugas, atau isi nama sekretaris panitia">
                                </div>
                            </div>

                        </div>

                        <div class="pt-4 border-t border-gray-100 flex gap-4">
                            <button type="button" onclick="closeAddModal()" class="w-1/3 py-3.5 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all flex justify-center items-center">
                                Batal
                            </button>
                            <button type="submit" id="btnSubmitModal" class="w-2/3 py-3.5 bg-blue-600 text-white rounded-xl font-extrabold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                <span>Simpan dan Generate Surat</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cetak Daftar Kehadiran -->
    <div id="modalDaftarHadir" onclick="if(event.target === this) closeDaftarHadirModal()" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-lg overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="p-6 bg-gradient-to-r from-indigo-600 to-blue-600 text-white flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-inner">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black tracking-tight">Cetak Daftar Kehadiran</h3>
                        <p class="text-xs text-indigo-100 font-medium">Otomatis dari data Surat Undangan Kegiatan</p>
                    </div>
                </div>
                <button type="button" onclick="closeDaftarHadirModal()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('surat.eksternal.daftar_hadir.custom_download') }}" method="POST" onsubmit="setTimeout(closeDaftarHadirModal, 600);" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="surat_id" id="dh_surat_id">

                <!-- Agenda / Nama Kegiatan -->
                <div>
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Agenda / Nama Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" id="dh_nama_kegiatan" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-bold">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Waktu -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Waktu <span class="text-red-500">*</span></label>
                        <input type="text" name="waktu" id="dh_waktu" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-semibold" placeholder="Contoh: 08.00 - Selesai WITA">
                    </div>

                    <!-- Tempat / Hari, Tanggal -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Hari, Tanggal / Tempat <span class="text-red-500">*</span></label>
                        <input type="text" name="hari_tanggal" id="dh_hari_tanggal" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-semibold" placeholder="Contoh: Senin, 12 Oktober 2026">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Peserta -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Peserta (Bebas Isi) <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_tempat" id="dh_nama_tempat" required value="Tamu Undangan dan Peserta" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-semibold" placeholder="Contoh: Tamu Undangan / Seluruh Anggota GenBI">
                    </div>

                    <!-- Jumlah Baris -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Jumlah Baris Tanda Tangan (Maks. 1000)</label>
                        <input type="number" name="jumlah_baris" id="dh_jumlah_baris" value="100" min="1" max="1000" placeholder="Contoh: 100, 400, 1000" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-bold">
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-gray-100 flex gap-3">
                    <button type="button" onclick="closeDaftarHadirModal()" class="w-1/3 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white rounded-xl font-extrabold hover:from-indigo-700 hover:to-blue-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Unduh Daftar Hadir (.doc)</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Cetak Amplop Surat -->
    <div id="modalAmplopSurat" onclick="if(event.target === this) closeAmplopModal()" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-lg overflow-hidden transform transition-all">
            <!-- Modal Header -->
            <div class="p-6 bg-gradient-to-r from-teal-600 to-emerald-600 text-white flex justify-between items-start">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-inner">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black tracking-tight">Cetak Amplop Surat</h3>
                        <p class="text-xs text-teal-100 font-medium">Data otomatis diambil dari surat terpilih</p>
                    </div>
                </div>
                <button type="button" onclick="closeAmplopModal()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('surat.eksternal.amplop.custom_download') }}" method="POST" onsubmit="setTimeout(closeAmplopModal, 600);" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="surat_id" id="amplop_surat_id">

                <!-- Nomor Surat -->
                <div>
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Nomor Surat <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_surat_full" id="amplop_nomor_surat" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-teal-500 outline-none font-bold">
                </div>

                <!-- Ditujukan Kepada -->
                <div>
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Nama Yang Ditujukan / Kepada Yth. <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_tempat" id="amplop_nama_tempat" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-teal-500 outline-none font-semibold" placeholder="Contoh: Rektor USN Kolaka">
                </div>

                <!-- Perihal -->
                <div>
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Perihal / Nama Amplop <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" id="amplop_perihal" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-teal-500 outline-none font-semibold" placeholder="Contoh: Undangan Kegiatan / Permohonan Kerjasama">
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-gray-100 flex gap-3">
                    <button type="button" onclick="closeAmplopModal()" class="w-1/3 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" class="w-2/3 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 text-white rounded-xl font-extrabold hover:from-teal-700 hover:to-emerald-700 hover:shadow-lg hover:shadow-teal-500/30 transition-all flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Unduh Amplop (.doc)</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== MODAL HAPUS ===== --}}
    <div id="modalHapus" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalHapusContent">
            <div class="px-8 py-6 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Surat?</h3>
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat dibatalkan dan berkas surat akan terhapus.</p>
            </div>
            <div class="px-8 py-5 bg-gray-50 flex gap-3 justify-end border-t border-gray-100">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <form id="formHapus" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition-all shadow-lg shadow-red-500/30">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- DataTables CSS & JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select { padding-right: 2rem; border-radius: 0.5rem; border: 1px solid #e5e7eb; }
        .dataTables_wrapper .dataTables_filter input { border-radius: 0.5rem; border: 1px solid #e5e7eb; padding: 0.25rem 0.75rem; margin-left: 0.5rem; }
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { margin-top: 1rem; }
        table.dataTable thead th { border-bottom: 1px solid #f3f4f6; }
        table.dataTable.no-footer { border-bottom: 1px solid #f3f4f6; }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "emptyTable": "Tidak ada data surat eksternal tersedia",
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
        
        const daftarSuratEksternal = @json($suratEksternals->keyBy('id'));

        function openAddModal() {
            document.getElementById('formSuratEksternal').reset();
            document.getElementById('formSuratEksternal').action = "{{ route('surat.eksternal.store') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('modalTitle').innerText = "Buat Surat Eksternal Baru";
            document.getElementById('modalSubtitle').innerText = "Pilih jenis surat, isi semua data, lalu simpan.";
            document.querySelector('#btnSubmitModal span').innerText = "Simpan dan Generate Surat";
            
            // Set default date values & auto nomor urut berikutnya
            const nextNo = "{{ $nextNo }}";
            document.getElementById('ns_no').value = nextNo;
            const m = "{{ $currentMonthRoman }}";
            const y = "{{ \Carbon\Carbon::now()->format('Y') }}";
            document.getElementById('ns_bulan').value = m;
            document.getElementById('ns_tahun').value = y;

            // Reset dynamic barang rows
            document.getElementById('barang_container').innerHTML = `
                <div class="flex gap-3 barang-row">
                    <input type="text" name="barang_nama[]" placeholder="Nama Barang" class="w-2/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                    <input type="text" name="barang_jumlah[]" placeholder="Jumlah (Misal: 1 Unit)" class="w-1/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                    <button type="button" onclick="hapusBarang(this)" class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 hidden btn-hapus-barang">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            `;

            document.getElementById('modalTambah').classList.remove('hidden');
            if (document.getElementById('pilih_kegiatan_eksternal')) {
                document.getElementById('pilih_kegiatan_eksternal').value = '';
            }
            if (document.getElementById('input_nama_kegiatan')) {
                document.getElementById('input_nama_kegiatan').value = '';
            }
            if (document.getElementById('hari_tanggal')) {
                document.getElementById('hari_tanggal').value = '';
            }
            if (document.getElementById('waktu')) {
                document.getElementById('waktu').value = '';
            }
            if (document.getElementById('tempat_kegiatan')) {
                document.getElementById('tempat_kegiatan').value = '';
            }
            if (document.getElementById('tema_kegiatan')) {
                document.getElementById('tema_kegiatan').value = '';
            }
            if (document.getElementById('alasan_sp2')) {
                document.getElementById('alasan_sp2').value = '';
            }
            toggleFields();
            updateNomor();
        }

        function openEditModal(id) {
            const surat = daftarSuratEksternal[id];
            if (!surat) return;

            document.getElementById('formSuratEksternal').reset();
            document.getElementById('formSuratEksternal').action = `/surat-eksternal/update/${id}`;
            document.getElementById('formMethod').value = "PUT";
            document.getElementById('modalTitle').innerText = "Edit Surat Eksternal";
            document.getElementById('modalSubtitle').innerText = "Perbarui data surat eksternal yang sudah ada.";
            document.querySelector('#btnSubmitModal span').innerText = "Simpan Perubahan";

            // Parse and populate jenis_surat first
            document.getElementById('jenis_surat').value = surat.jenis_surat || '';
            
            // Toggle fields based on jenis_surat
            toggleFields();

            // Split nomor surat: 001/B/SP-3/GENBI-KOMS-USN/X/2026
            if (surat.nomor_surat_full) {
                const parts = surat.nomor_surat_full.split('/');
                if(parts.length >= 6) {
                    document.getElementById('ns_no').value = parts[0];
                    document.getElementById('ns_kode').value = parts[2];
                    document.getElementById('ns_bulan').value = parts[4];
                    document.getElementById('ns_tahun').value = parts[5];
                }
            } else {
                if (surat.no_urut) document.getElementById('ns_no').value = surat.no_urut;
                if (surat.kode_surat) document.getElementById('ns_kode').value = surat.kode_surat;
                if (surat.bulan) document.getElementById('ns_bulan').value = surat.bulan;
                if (surat.tahun) document.getElementById('ns_tahun').value = surat.tahun;
            }

            if (surat.jenis_surat === 'SP-3') {
                document.getElementById('ns_kode').value = 'SP-3';
            }

            document.getElementById('nama_tempat').value = surat.nama_tempat || '';

            // Handle nama_anggota
            if (surat.nama_anggota) {
                const anggotaSelect = document.getElementById('nama_anggota');
                let found = false;
                for (let i = 0; i < anggotaSelect.options.length; i++) {
                    if (anggotaSelect.options[i].value === surat.nama_anggota) {
                        anggotaSelect.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    const opt = document.createElement('option');
                    opt.value = surat.nama_anggota;
                    opt.textContent = surat.nama_anggota;
                    opt.selected = true;
                    anggotaSelect.appendChild(opt);
                }
            } else {
                document.getElementById('nama_anggota').value = '';
            }

            document.getElementById('nim_anggota').value = surat.nim_anggota || '';
            document.getElementById('jurusan_anggota').value = surat.jurusan_anggota || '';
            document.getElementById('periode_pengurus').value = surat.periode_pengurus || '';
            if (document.getElementById('alasan_sp2')) {
                document.getElementById('alasan_sp2').value = surat.alasan_sp2 || '';
            }
            
            // Handle nama_kegiatan
            if (document.getElementById('input_nama_kegiatan')) {
                document.getElementById('input_nama_kegiatan').value = surat.nama_kegiatan || '';
            }
            if (document.getElementById('pilih_kegiatan_eksternal')) {
                const sel = document.getElementById('pilih_kegiatan_eksternal');
                let found = false;
                for (let i = 0; i < sel.options.length; i++) {
                    if (sel.options[i].value === (surat.nama_kegiatan || '')) {
                        sel.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    sel.value = '';
                }
            }

            document.getElementById('tema_kegiatan').value = surat.tema_kegiatan || '';
            document.getElementById('tujuan_kegiatan').value = surat.tujuan_kegiatan || '';
            document.getElementById('nama_materi').value = surat.nama_materi || '';
            document.getElementById('hari_tanggal').value = surat.hari_tanggal || '';
            document.getElementById('waktu').value = surat.waktu || '';
            document.getElementById('tempat_kegiatan').value = surat.tempat_kegiatan || '';
            document.getElementById('nama_alat').value = surat.nama_alat || '';
            
            // Populate dynamic barang rows
            const barangContainer = document.getElementById('barang_container');
            barangContainer.innerHTML = '';
            if (surat.barang_jumlah) {
                try {
                    const barangs = JSON.parse(surat.barang_jumlah);
                    if (barangs && barangs.length > 0) {
                        barangs.forEach((b, idx) => {
                            const hiddenClass = (barangs.length === 1 && idx === 0) ? 'hidden' : '';
                            const row = `
                                <div class="flex gap-3 barang-row">
                                    <input type="text" name="barang_nama[]" value="${b.nama || ''}" placeholder="Nama Barang" class="w-2/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                                    <input type="text" name="barang_jumlah[]" value="${b.jumlah || ''}" placeholder="Jumlah (Misal: 1 Unit)" class="w-1/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                                    <button type="button" onclick="hapusBarang(this)" class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 ${hiddenClass} btn-hapus-barang">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            `;
                            barangContainer.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        tambahBarang();
                    }
                } catch(e) {
                    tambahBarang();
                }
            } else {
                tambahBarang();
            }

            document.getElementById('nama_ketua_panitia').value = surat.nama_ketua_panitia || '';
            document.getElementById('nama_sekretaris_panitia').value = surat.nama_sekretaris_panitia || '';

            updateNomor();
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        function updateNomor() {
            const no = document.getElementById('ns_no').value || '...';
            let kode = document.getElementById('ns_kode').value || '...';
            const jenis = document.getElementById('jenis_surat').value;
            if (jenis === 'SP-3') {
                kode = 'SP-3';
            }
            const bulan = document.getElementById('ns_bulan').value || '...';
            const tahun = document.getElementById('ns_tahun').value || '...';
            
            const full = `${no}/B/${kode}/GENBI-KOMS-USN/${bulan}/${tahun}`;
            document.getElementById('nomor_surat_full').value = full;
            document.getElementById('preview_nomor').innerText = full;
        }

        function toggleFields() {
            const jenis = document.getElementById('jenis_surat').value;
            const dynamicFields = document.getElementById('dynamic_fields');
            
            const fieldTujuan = document.getElementById('field_tujuan');
            const fieldsSp3 = document.getElementById('fields_sp3');
            const fieldsKegiatan = document.getElementById('fields_kegiatan');
            const fieldsJadwal = document.getElementById('fields_jadwal');
            const fieldTujuanKeg = document.getElementById('field_tujuan_kegiatan');
            const fieldTema = document.getElementById('field_tema');
            const fieldMateri = document.getElementById('field_materi');
            const fieldAlat = document.getElementById('field_alat');
            const fieldBarang = document.getElementById('field_barang');
            const fieldPanitia = document.getElementById('field_panitia');
            const nsKode = document.getElementById('ns_kode');

            const wrapperPilihKeg = document.getElementById('wrapper_pilih_kegiatan');
            const dividerKeg = document.getElementById('divider_kegiatan');

            const labelTujuan = document.getElementById('label_tujuan');
            const inputTujuan = document.getElementById('nama_tempat');
            const labelNamaKegiatan = document.getElementById('label_nama_kegiatan');
            const inputNamaKegiatan = document.getElementById('input_nama_kegiatan');
            const labelTujuanKeg = document.getElementById('label_tujuan_kegiatan');
            const inputTujuanKeg = document.getElementById('tujuan_kegiatan');
            const containerNamaKeg = document.getElementById('container_nama_kegiatan');

            // Reset visibilities
            dynamicFields.classList.remove('hidden');
            fieldTujuan.classList.add('hidden');
            fieldsSp3.classList.add('hidden');
            fieldsKegiatan.classList.add('hidden');
            if (fieldsJadwal) fieldsJadwal.classList.remove('hidden');
            fieldTujuanKeg.classList.add('hidden');
            fieldTema.classList.add('hidden');
            fieldMateri.classList.add('hidden');
            fieldAlat.classList.add('hidden');
            fieldBarang.classList.add('hidden');
            fieldPanitia.classList.add('hidden');
            if (wrapperPilihKeg) wrapperPilihKeg.classList.remove('hidden');
            if (dividerKeg) dividerKeg.classList.remove('hidden');

            // Reset all optional/dynamic required attributes
            inputTujuan.removeAttribute('required');
            inputTujuanKeg.removeAttribute('required');
            if (inputNamaKegiatan) inputNamaKegiatan.removeAttribute('required');
            if (document.getElementById('nama_alat')) document.getElementById('nama_alat').removeAttribute('required');
            if (document.getElementById('nama_materi')) document.getElementById('nama_materi').removeAttribute('required');
            ['nama_anggota', 'nim_anggota', 'jurusan_anggota', 'periode_pengurus', 'alasan_sp2'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.removeAttribute('required');
            });
            ['hari_tanggal', 'waktu', 'tempat_kegiatan'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.removeAttribute('required');
            });

            // Default label texts & placeholders
            if (labelTujuan) {
                labelTujuan.innerHTML = 'Instansi Tujuan / Kepada <span class="text-red-500">*</span>';
                inputTujuan.placeholder = 'Contoh: Rektor USN Kolaka';
            }
            if (labelNamaKegiatan) {
                labelNamaKegiatan.innerHTML = 'Nama Kegiatan <span class="text-red-500">*</span>';
            }
            if (inputNamaKegiatan) {
                inputNamaKegiatan.placeholder = 'Contoh: GenBI GROW';
            }
            if (labelTujuanKeg) {
                labelTujuanKeg.innerHTML = 'Tujuan / Dalam Rangka <span class="text-red-500">*</span>';
                inputTujuanKeg.placeholder = 'Contoh: Tujuan Kegiatan Singkat';
            }
            if (containerNamaKeg) {
                containerNamaKeg.classList.remove('col-span-full');
            }
            
            if (jenis === '') {
                dynamicFields.classList.add('hidden');
                nsKode.value = '...';
            } else if (jenis === 'SP-3') {
                nsKode.value = 'SP-3';
                fieldsSp3.classList.remove('hidden');

                // Set required for SP-3 fields (alasan_sp2 is optional)
                ['nama_anggota', 'nim_anggota', 'jurusan_anggota', 'periode_pengurus'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.setAttribute('required', 'required');
                });
                autoFillSP3();
                updateNomor();
            } else if (jenis === 'Amplop') {
                nsKode.value = 'AMP';
                fieldsKegiatan.classList.remove('hidden');
                fieldTujuan.classList.remove('hidden');
                inputTujuan.setAttribute('required', 'required');
                if (inputNamaKegiatan) inputNamaKegiatan.setAttribute('required', 'required');
                if (fieldsJadwal) fieldsJadwal.classList.add('hidden');
                if (wrapperPilihKeg) wrapperPilihKeg.classList.add('hidden');
                if (dividerKeg) dividerKeg.classList.add('hidden');
                
                if (labelTujuan) {
                    labelTujuan.innerHTML = 'Nama Yang Ditujukan / Kepada Yth. <span class="text-red-500">*</span>';
                    inputTujuan.placeholder = 'Contoh: Rektor USN Kolaka / Pimpinan Cabang Bank BNI';
                }
                if (labelNamaKegiatan) {
                    labelNamaKegiatan.innerHTML = 'Nama Amplop / Perihal <span class="text-red-500">*</span>';
                }
                if (inputNamaKegiatan) {
                    inputNamaKegiatan.placeholder = 'Contoh: Undangan Kegiatan / Permohonan Kerjasama';
                }
                if (containerNamaKeg) {
                    containerNamaKeg.classList.add('col-span-full');
                }
            } else if (jenis === 'Daftar Hadir') {
                nsKode.value = 'DH';
                fieldsKegiatan.classList.remove('hidden');
                fieldTujuan.classList.remove('hidden');
                inputTujuan.setAttribute('required', 'required');
                if (inputNamaKegiatan) inputNamaKegiatan.setAttribute('required', 'required');
                if (fieldsJadwal) fieldsJadwal.classList.remove('hidden');
                
                if (labelTujuan) {
                    labelTujuan.innerHTML = 'Peserta (Bebas Isi) <span class="text-red-500">*</span>';
                    inputTujuan.placeholder = 'Contoh: Tamu Undangan / Seluruh Anggota GenBI / Mahasiswa';
                }
                if (labelNamaKegiatan) {
                    labelNamaKegiatan.innerHTML = 'Agenda / Nama Kegiatan <span class="text-red-500">*</span>';
                }
                if (inputNamaKegiatan) {
                    inputNamaKegiatan.placeholder = 'Contoh: Rapat Koordinasi Bulanan';
                }
                if (containerNamaKeg) {
                    containerNamaKeg.classList.add('col-span-full');
                }
            } else {
                fieldsKegiatan.classList.remove('hidden');
                fieldTujuan.classList.remove('hidden');
                inputTujuan.setAttribute('required', 'required');
                if (inputNamaKegiatan) inputNamaKegiatan.setAttribute('required', 'required');
                
                if (jenis === 'Permohonan') {
                    nsKode.value = 'PERM';
                    if (labelTujuan) {
                        labelTujuan.innerHTML = 'Instansi Tujuan / Kepada <span class="text-red-500">*</span>';
                        inputTujuan.placeholder = 'Contoh: Rektor USN Kolaka / Dekan FTI USN Kolaka';
                    }
                } else if (jenis === 'Peminjaman') {
                    nsKode.value = 'PJM';
                    fieldTema.classList.remove('hidden');
                    fieldAlat.classList.remove('hidden');
                    if (document.getElementById('nama_alat')) {
                        document.getElementById('nama_alat').setAttribute('required', 'required');
                    }
                    fieldBarang.classList.remove('hidden');
                } else if (jenis === 'Undangan Eksternal') {
                    nsKode.value = 'UND';
                    fieldTujuanKeg.classList.remove('hidden');
                    inputTujuanKeg.setAttribute('required', 'required');
                    fieldTema.classList.remove('hidden');
                    fieldPanitia.classList.remove('hidden');
                    if (labelTujuanKeg) {
                        labelTujuanKeg.innerHTML = 'Tujuan / Dalam Rangka <span class="text-red-500">*</span>';
                        inputTujuanKeg.placeholder = 'Contoh: Memperingati Milad GenBI Ke-5';
                    }
                } else if (jenis === 'Undangan Narasumber') {
                    nsKode.value = 'UND';
                    fieldTujuanKeg.classList.remove('hidden');
                    inputTujuanKeg.setAttribute('required', 'required');
                    fieldTema.classList.remove('hidden');
                    fieldMateri.classList.remove('hidden');
                    if (document.getElementById('nama_materi')) {
                        document.getElementById('nama_materi').setAttribute('required', 'required');
                    }
                    fieldPanitia.classList.remove('hidden');
                    if (labelTujuan) {
                        labelTujuan.innerHTML = 'Nama Instansi / Yang Ditujukan (Narasumber) <span class="text-red-500">*</span>';
                        inputTujuan.placeholder = 'Contoh: Dr. Nama Pemateri, M.Pd / Nama Instansi';
                    }
                    if (labelTujuanKeg) {
                        labelTujuanKeg.innerHTML = 'Tujuan Kegiatan (Dalam rangka meningkatkan...) <span class="text-red-500">*</span>';
                        inputTujuanKeg.placeholder = 'Contoh: Pemahaman dan Wawasan Literasi Keuangan';
                    }
                } else if (jenis === 'Kerjasama') {
                    nsKode.value = 'KER';
                    fieldTujuanKeg.classList.remove('hidden');
                    inputTujuanKeg.setAttribute('required', 'required');
                    fieldPanitia.classList.remove('hidden');
                    if (labelTujuan) {
                        labelTujuan.innerHTML = 'Nama Instansi / Mitra Kerjasama <span class="text-red-500">*</span>';
                        inputTujuan.placeholder = 'Contoh: Bank BNI Cabang Kolaka / Dinas Lingkungan Hidup / PT. Antam Tbk';
                    }
                    if (labelTujuanKeg) {
                        labelTujuanKeg.innerHTML = 'Tujuan Kerjasama (sarana untuk...) <span class="text-red-500">*</span>';
                        inputTujuanKeg.placeholder = 'Contoh: Mempererat kemitraan strategis dan mendukung program pemberdayaan masyarakat';
                    }
                }

                if (containerNamaKeg) {
                    if (fieldTema.classList.contains('hidden')) {
                        containerNamaKeg.classList.add('col-span-full');
                    } else {
                        containerNamaKeg.classList.remove('col-span-full');
                    }
                }
            }
            
            updateNomor();
        }

        @php
            $userMap = [];
            foreach($semuaAnggota as $anggota) {
                $userMap[$anggota->name] = [
                    'nim' => $anggota->nim ?? '',
                    'jurusan' => $anggota->jurusan ?? '',
                ];
            }

            $sp2Map = [];
            foreach($suratSP2 as $sp) {
                $sp2Map[$sp->anggota_sp] = [
                    'nomor' => $sp->nomor_surat_full,
                    'tanggal' => \Carbon\Carbon::parse($sp->created_at)->locale('id')->isoFormat('D MMMM YYYY'),
                ];
            }
        @endphp

        const userDetails = @json($userMap);
        const sp2Details = @json($sp2Map);

        function autoFillSP3() {
            const sel = document.getElementById('nama_anggota');
            if (!sel) return;
            const opt = sel.options[sel.selectedIndex];
            const nama = sel.value;
            
            let nim = (opt && opt.dataset.nim) ? opt.dataset.nim : (userDetails[nama] ? userDetails[nama].nim : '');
            let jurusan = (opt && opt.dataset.jurusan) ? opt.dataset.jurusan : (userDetails[nama] ? userDetails[nama].jurusan : '');

            document.getElementById('nim_anggota').value = nim || '';
            document.getElementById('jurusan_anggota').value = jurusan || '';
            
            const alasanInput = document.getElementById('alasan_sp2');
            if (alasanInput) {
                if (sp2Details[nama]) {
                    alasanInput.value = `Nomor: ${sp2Details[nama].nomor} tanggal ${sp2Details[nama].tanggal}`;
                } else {
                    alasanInput.value = '';
                }
            }
        }
        
        function fillKegiatanEksternal(sel) {
            if (!sel) sel = document.getElementById('pilih_kegiatan_eksternal');
            if (!sel) return;

            const opt = sel.options[sel.selectedIndex];
            const inputNama = document.getElementById('input_nama_kegiatan');
            const inputHt   = document.getElementById('hari_tanggal');
            const inputWk   = document.getElementById('waktu');
            const inputTp   = document.getElementById('tempat_kegiatan');
            const inputTema = document.getElementById('tema_kegiatan');
            const inputKetua = document.getElementById('nama_ketua_panitia');
            const inputSekretaris = document.getElementById('nama_sekretaris_panitia');

            if (!opt || !opt.value) {
                if (inputNama) inputNama.value = '';
                if (inputHt)   inputHt.value   = '';
                if (inputWk)   inputWk.value   = '';
                if (inputTp)   inputTp.value   = '';
                if (inputTema) inputTema.value = '';
                return;
            }

            const nama = opt.dataset.nama || opt.value;
            const tanggal = opt.dataset.tanggal || '';
            const waktu = opt.dataset.waktu || '';
            const tempat = opt.dataset.tempat || '';
            const tema = opt.dataset.tema || '';
            const ketua = opt.dataset.ketua || '';
            const sekretaris = opt.dataset.sekretaris || '';

            if (inputNama) {
                inputNama.value = nama;
                try { inputNama.dispatchEvent(new Event('input', { bubbles: true })); } catch(e) {}
            }
            if (inputHt) {
                inputHt.value = tanggal;
                try { inputHt.dispatchEvent(new Event('input', { bubbles: true })); } catch(e) {}
            }
            if (inputWk) {
                inputWk.value = waktu;
                try { inputWk.dispatchEvent(new Event('input', { bubbles: true })); } catch(e) {}
            }
            if (inputTp) {
                inputTp.value = tempat;
                try { inputTp.dispatchEvent(new Event('input', { bubbles: true })); } catch(e) {}
            }
            if (inputTema && tema) {
                inputTema.value = tema;
            }
            if (inputKetua && ketua) {
                inputKetua.value = ketua;
            }
            if (inputSekretaris && sekretaris) {
                inputSekretaris.value = sekretaris;
            }
        }
        window.autoFillKegiatan = fillKegiatanEksternal;

        function tambahBarang() {
            const container = document.getElementById('barang_container');
            const row = document.createElement('div');
            row.className = 'flex gap-3 barang-row';
            row.innerHTML = `
                <input type="text" name="barang_nama[]" placeholder="Nama Barang" class="w-2/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                <input type="text" name="barang_jumlah[]" placeholder="Jumlah (Misal: 1 Unit)" class="w-1/3 bg-white border border-gray-200 text-sm rounded-lg p-2.5 focus:border-blue-500 outline-none">
                <button type="button" onclick="hapusBarang(this)" class="p-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 btn-hapus-barang">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(row);
            updateTombolHapusBarang();
        }

        function hapusBarang(button) {
            const row = button.closest('.barang-row');
            row.remove();
            updateTombolHapusBarang();
        }

        function updateTombolHapusBarang() {
            const rows = document.querySelectorAll('.barang-row');
            const buttons = document.querySelectorAll('.btn-hapus-barang');
            if (rows.length <= 1) {
                buttons.forEach(btn => btn.classList.add('hidden'));
            } else {
                buttons.forEach(btn => btn.classList.remove('hidden'));
            }
        }
        function openAmplopModal(id, nomorSurat, perihal, ditujukan) {
            document.getElementById('amplop_surat_id').value = id || '';
            document.getElementById('amplop_nomor_surat').value = nomorSurat || '';
            document.getElementById('amplop_nama_tempat').value = ditujukan || '';
            document.getElementById('amplop_perihal').value = perihal || '';
            
            const modal = document.getElementById('modalAmplopSurat');
            modal.classList.remove('hidden');
        }

        function closeAmplopModal() {
            const modal = document.getElementById('modalAmplopSurat');
            modal.classList.add('hidden');
        }

        function openDaftarHadirModal(id, namaKegiatan, waktu, hariTanggal, tempatKegiatan) {
            document.getElementById('dh_surat_id').value = id || '';
            document.getElementById('dh_nama_kegiatan').value = namaKegiatan || '';
            document.getElementById('dh_waktu').value = waktu || '';
            
            let lokasi = hariTanggal || '';
            if (tempatKegiatan && hariTanggal && tempatKegiatan !== hariTanggal) {
                lokasi = hariTanggal + ' / ' + tempatKegiatan;
            } else if (tempatKegiatan && !hariTanggal) {
                lokasi = tempatKegiatan;
            }
            document.getElementById('dh_hari_tanggal').value = lokasi;
            document.getElementById('dh_nama_tempat').value = 'Tamu Undangan dan Peserta';
            document.getElementById('dh_jumlah_baris').value = '100';

            const modal = document.getElementById('modalDaftarHadir');
            modal.classList.remove('hidden');
        }

        function closeDaftarHadirModal() {
            const modal = document.getElementById('modalDaftarHadir');
            modal.classList.add('hidden');
        }

        function openDeleteModal(url) {
            const modal = document.getElementById('modalHapus');
            const modalContent = document.getElementById('modalHapusContent');
            document.getElementById('formHapus').action = url;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('modalHapus');
            const modalContent = document.getElementById('modalHapusContent');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        const btnSubmit = document.getElementById('btnSubmitModal');
        if (btnSubmit) {
            btnSubmit.addEventListener('click', function() {
                const form = document.getElementById('formSuratEksternal');
                if (!form) return;
                form.querySelectorAll('.hidden input, .hidden select, .hidden textarea, [style*="display: none"] input, [style*="display: none"] select, [style*="display: none"] textarea').forEach(el => {
                    el.removeAttribute('required');
                });
            });
        }

        document.getElementById('formSuratEksternal').addEventListener('submit', function(e) {
            updateNomor();

            // Safety check: jika ada kegiatan yang dipilih tapi hari_tanggal belum terisi, lakukan autofill sebelum submit
            const selKeg = document.getElementById('pilih_kegiatan_eksternal');
            if (selKeg && selKeg.value && (!document.getElementById('hari_tanggal').value || !document.getElementById('waktu').value || !document.getElementById('tempat_kegiatan').value)) {
                fillKegiatanEksternal(selKeg);
            }

            // Safety check: remove 'required' from all inputs inside any hidden container
            const hiddenContainers = this.querySelectorAll('.hidden, [style*="display: none"]');
            hiddenContainers.forEach(container => {
                container.querySelectorAll('input, select, textarea').forEach(el => {
                    el.removeAttribute('required');
                });
            });
        });
    </script>
@endsection
