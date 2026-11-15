@extends('layout.app')

@section('content')
    @php
        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $currentMonthRoman = $romanMonths[date('n') - 1];
    @endphp

    {{-- ===== HEADER ===== --}}
    <div class="mb-8 animate-fade-in-down flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Sosialisasi</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola dan buat surat permohonan sosialisasi organisasi.</p>
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
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-bold flex items-center gap-3">
            <div class="bg-red-500 text-white p-1.5 rounded-full flex-shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <span>Silakan lengkapi formulir dengan benar.</span>
        </div>
    @endif

    {{-- ===== TABEL SURAT SOSIALISASI ===== --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="text-xl font-extrabold text-gray-800">Daftar Surat Sosialisasi</h2>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button onclick="document.getElementById('modalTemplate').classList.remove('hidden')"
                    class="px-5 py-2.5 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold hover:bg-gray-50 hover:shadow-sm transition-all duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Pilih Template
                </button>
                @if (auth()->user()->canManageSosialisasi())
                <button onclick="openAddModal()"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 transition-all duration-200 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Surat
                </button>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="dataTable" class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-gray-100">
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider w-10">No</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Nomor Surat</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Instansi Tujuan / Kepada</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Topik Sosialisasi</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Tempat</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/80">
                    @forelse($suratSosialisasis as $i => $surat)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-4 text-sm text-gray-400 font-semibold">{{ $i + 1 }}</td>
                            <td class="py-4 px-4 text-sm font-bold text-gray-800">
                                {{ $surat->nomor_surat_full }}
                            </td>
                            <td class="py-4 px-4 text-sm font-semibold text-gray-800">
                                {{ $surat->nama_tempat }}
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-600">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg font-bold text-xs border border-blue-100/80">
                                    {{ $surat->nama_kebijakan }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs text-gray-600">
                                <div class="font-bold text-gray-800">{{ $surat->hari_tanggal }}</div>
                                @php
                                    $rawWaktu = trim($surat->waktu ?? '');
                                    $cleanWaktu = preg_replace('/(\s*WITA|\s*-\s*Selesai|\s*Selesai)/i', '', $rawWaktu);
                                    $cleanWaktu = trim(rtrim(trim($cleanWaktu), '-'));
                                    $displayWaktu = !empty($cleanWaktu) ? $cleanWaktu . ' WITA - Selesai' : ($surat->waktu ?? '-');
                                @endphp
                                <div class="text-gray-500 font-medium mt-0.5">{{ $displayWaktu }}</div>
                            </td>
                            <td class="py-4 px-4 text-sm font-semibold text-gray-800">
                                {{ $surat->tempat_kegiatan }}
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($surat->created_at)->locale('id')->isoFormat('D MMM YYYY') }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                @php
                                    $perihalAmplop = 'Permohonan Izin Mengadakan Sosialisasi ' . $surat->nama_kebijakan;
                                    $tujuanAmplop = $surat->nama_tempat;
                                    $agendaDaftarHadir = 'Sosialisasi ' . $surat->nama_kebijakan;
                                @endphp
                                <div class="flex items-center justify-center gap-1.5">
                                    {{-- Unduh Word --}}
                                    <a href="{{ route('surat.sosialisasi.download', $surat->id) }}" title="Unduh Surat (.doc)"
                                        class="p-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>

                                    {{-- Amplop Surat --}}
                                    <button type="button" 
                                        onclick="openAmplopModal({{ $surat->id }}, @js($surat->nomor_surat_full), @js($perihalAmplop), @js($tujuanAmplop))" 
                                        title="Amplop Surat"
                                        class="p-2.5 bg-teal-600 text-white rounded-xl hover:bg-teal-700 hover:shadow-lg hover:shadow-teal-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </button>

                                    {{-- Daftar Kehadiran --}}
                                    <button type="button" 
                                        onclick="openDaftarHadirModal({{ $surat->id }}, @js($agendaDaftarHadir), @js($displayWaktu), @js($surat->hari_tanggal), @js($surat->tempat_kegiatan))" 
                                        title="Daftar Kehadiran"
                                        class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </button>

                                    {{-- Sertifikat Penghargaan --}}
                                    <a href="{{ route('surat.sosialisasi.sertifikat', $surat->id) }}" target="_blank" 
                                        title="Sertifikat Penghargaan"
                                        class="p-2.5 bg-amber-500 text-white rounded-xl hover:bg-amber-600 hover:shadow-lg hover:shadow-amber-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                    </a>

                                    @if (auth()->user()->canManageSosialisasi())
                                    {{-- Edit --}}
                                    <button onclick="openEditModal({{ $surat->id }}, {{ json_encode($surat) }})" title="Edit"
                                        class="p-2.5 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600 hover:shadow-lg hover:shadow-yellow-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>

                                    {{-- Hapus --}}
                                    <form action="{{ route('surat.sosialisasi.destroy', $surat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus"
                                            class="p-2.5 bg-red-500 text-white rounded-xl hover:bg-red-600 hover:shadow-lg hover:shadow-red-500/30 transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Data kosong -->
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== MODAL TAMBAH & EDIT SURAT SOSIALISASI ===== --}}
    @if (auth()->user()->canManageSosialisasi())
    <div id="modalTambahSurat" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-hidden shadow-2xl flex flex-col border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 id="modalTitle" class="text-xl font-extrabold text-gray-800">Buat Surat Sosialisasi Baru</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Surat Permohonan Izin Mengadakan Sosialisasi</p>
                </div>
                <button type="button" onclick="closeAddModal()" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="overflow-y-auto w-full p-8 pt-6 flex-1">
                <form id="formSuratSosialisasi" action="{{ route('surat.sosialisasi.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    {{-- Nomor Surat Builder --}}
                    <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5">
                        <label class="block text-[11px] font-black text-blue-600 uppercase tracking-wider mb-3">Penomoran Surat <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap items-center gap-1.5 mb-4">
                            <input type="text" name="ns_no" id="ns_no" value="{{ $nextNo }}" placeholder="{{ $nextNo }}" required class="w-14 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold" oninput="updateNomor()">
                            <span class="text-gray-400 font-bold">/</span>
                            <input type="text" value="B" readonly class="w-10 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-500 outline-none">
                            <span class="text-gray-400 font-bold">/</span>
                            <input type="text" name="ns_kode" id="ns_kode" value="PERM" readonly class="w-16 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-500 outline-none">
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

                    {{-- Nama Kebijakan / Topik Sosialisasi --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Nama Kebijakan <span class="text-red-500">*</span></label>
                        <select name="nama_kebijakan" id="nama_kebijakan" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:border-blue-500 focus:bg-white outline-none transition-colors font-semibold">
                            <option value="">-- Pilih Nama Kebijakan --</option>
                            <option value="CBPR QRIS PeKA">CBPR QRIS PeKA</option>
                            <option value="CBPR">CBPR</option>
                            <option value="QRIS">QRIS</option>
                            <option value="PeKA">PeKA</option>
                            <option value="CBPR QRIS">CBPR QRIS</option>
                            <option value="QRIS PeKA">QRIS PeKA</option>
                            <option value="CBPR PeKA">CBPR PeKA</option>
                        </select>
                    </div>

                    {{-- Instansi Tujuan / Kepada Yth. --}}
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Instansi Tujuan / Kepada Yth. <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_tempat" id="nama_tempat" required class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none transition-colors" placeholder="Contoh: Kepala SMA Negeri 1 Kolaka / Rektor USN Kolaka">
                    </div>

                    {{-- Jadwal & Tempat Kegiatan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Hari Kegiatan <span class="text-red-500">*</span></label>
                            <select name="hari" id="hari" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none transition-colors font-semibold">
                                <option value="">-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" required onchange="autoDetectHari(this.value)" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none transition-colors font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Waktu Kegiatan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" name="waktu" id="waktu" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 pr-32 focus:bg-white focus:border-blue-500 outline-none transition-colors font-semibold" placeholder="Contoh: 08.00">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-[11px] font-bold text-gray-400 bg-gray-100 px-2 py-1 rounded-lg border border-gray-200">WITA - Selesai</span>
                                </div>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">Otomatis tertulis: <strong>[Waktu] WITA - Selesai</strong> pada surat.</p>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Tempat Kegiatan <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-blue-500 outline-none transition-colors font-semibold" placeholder="Contoh: Aula SMA Negeri 1 Kolaka">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="closeAddModal()" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors text-sm">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all text-sm">
                            Simpan Surat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- ===== MODAL PILIH TEMPLATE ===== --}}
    <div id="modalTemplate" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="document.getElementById('modalTemplate').classList.add('hidden')"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg border border-gray-100 max-h-[90vh] flex flex-col">
                <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">Pilih Template Sosialisasi</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Unduh contoh format surat dalam file Word (.doc)</p>
                    </div>
                    <button onclick="document.getElementById('modalTemplate').classList.add('hidden')" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-3 overflow-y-auto">
                    {{-- Template Permohonan Sosialisasi --}}
                    <a href="{{ route('surat.sosialisasi.template.download') }}" class="flex items-center gap-4 p-4 border-2 border-blue-100 hover:border-blue-300 hover:bg-blue-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Permohonan Sosialisasi</p>
                            <p class="text-xs text-gray-400">Format Permohonan Izin Mengadakan Sosialisasi</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Daftar Hadir --}}
                    <a href="{{ route('surat.sosialisasi.template.jenis', 'daftar_hadir') }}" class="flex items-center gap-4 p-4 border-2 border-indigo-100 hover:border-indigo-300 hover:bg-indigo-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Daftar Kehadiran</p>
                            <p class="text-xs text-gray-400">Format List Peserta / Daftar Kehadiran Sosialisasi</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>

                    {{-- Amplop --}}
                    <a href="{{ route('surat.sosialisasi.template.jenis', 'amplop') }}" class="flex items-center gap-4 p-4 border-2 border-teal-100 hover:border-teal-300 hover:bg-teal-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Amplop Surat</p>
                            <p class="text-xs text-gray-400">Format Cover Depan Amplop Surat Sosialisasi</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL CETAK AMPLOP SURAT ===== --}}
    <div id="modalAmplopSurat" onclick="if(event.target === this) closeAmplopModal()" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl flex flex-col border border-gray-100">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gradient-to-r from-teal-600 to-emerald-600 text-white">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-white/10 rounded-xl backdrop-blur-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black tracking-tight">Cetak Amplop Surat Sosialisasi</h3>
                        <p class="text-xs text-teal-100 font-medium">Data otomatis diambil dari surat terpilih</p>
                    </div>
                </div>
                <button type="button" onclick="closeAmplopModal()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('surat.sosialisasi.amplop.custom_download') }}" method="POST" onsubmit="setTimeout(closeAmplopModal, 600);" class="p-6 space-y-4">
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
                    <input type="text" name="nama_tempat" id="amplop_nama_tempat" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-teal-500 outline-none font-semibold" placeholder="Contoh: Kepala SMA Negeri 1 Kolaka">
                </div>

                <!-- Perihal / Nama Amplop -->
                <div>
                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Perihal / Nama Amplop <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kegiatan" id="amplop_perihal" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-teal-500 outline-none font-semibold" placeholder="Contoh: Permohonan Izin Mengadakan Sosialisasi CBP Rupiah">
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

    {{-- ===== MODAL CETAK DAFTAR KEHADIRAN ===== --}}
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
                        <p class="text-xs text-indigo-100 font-medium">Data otomatis diambil dari surat sosialisasi</p>
                    </div>
                </div>
                <button type="button" onclick="closeDaftarHadirModal()" class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('surat.sosialisasi.daftar_hadir.custom_download') }}" method="POST" onsubmit="setTimeout(closeDaftarHadirModal, 600);" class="p-6 space-y-4">
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

                    <!-- Hari, Tanggal / Tempat -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Hari, Tanggal / Tempat <span class="text-red-500">*</span></label>
                        <input type="text" name="hari_tanggal" id="dh_hari_tanggal" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-semibold" placeholder="Contoh: Senin, 12 Oktober 2026">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Peserta -->
                    <div>
                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">Peserta (Bebas Isi) <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_tempat" id="dh_nama_tempat" required value="Tamu Undangan dan Peserta" class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl p-3 focus:bg-white focus:border-indigo-500 outline-none font-semibold" placeholder="Contoh: Tamu Undangan / Siswa SMA Negeri 1 Kolaka">
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
                    "emptyTable": "Tidak ada dokumen sosialisasi tersedia",
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
            updateNomor();
        });

        function updateNomor() {
            const elNo = document.getElementById('ns_no');
            if (!elNo) return;
            const no = elNo.value || '...';
            const kode = document.getElementById('ns_kode') ? document.getElementById('ns_kode').value || 'PERM' : 'PERM';
            const bulan = document.getElementById('ns_bulan') ? document.getElementById('ns_bulan').value || '...' : '...';
            const tahun = document.getElementById('ns_tahun') ? document.getElementById('ns_tahun').value || '...' : '...';
            
            const nomorFull = `${no}/B/${kode}/GENBI-KOMS-USN/${bulan}/${tahun}`;
            if (document.getElementById('nomor_surat_full')) document.getElementById('nomor_surat_full').value = nomorFull;
            if (document.getElementById('preview_nomor')) document.getElementById('preview_nomor').innerText = nomorFull;
        }

        function autoDetectHari(dateVal) {
            if (!dateVal) return;
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const d = new Date(dateVal + 'T00:00:00');
            if (!isNaN(d.getTime())) {
                const dayName = days[d.getDay()];
                const hariSelect = document.getElementById('hari');
                if (hariSelect) {
                    hariSelect.value = dayName;
                }
            }
        }

        function openAddModal() {
            if (!document.getElementById('modalTambahSurat')) return;
            document.getElementById('modalTitle').innerText = 'Buat Surat Sosialisasi Baru';
            document.getElementById('formSuratSosialisasi').action = "{{ route('surat.sosialisasi.store') }}";
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('formSuratSosialisasi').reset();
            
            // Generate auto nomor urut berikutnya
            document.getElementById('ns_no').value = "{{ $nextNo }}";
            document.getElementById('ns_kode').value = 'PERM';
            document.getElementById('ns_bulan').value = "{{ $currentMonthRoman }}";
            document.getElementById('ns_tahun').value = "{{ \Carbon\Carbon::now()->format('Y') }}";
            
            document.getElementById('hari').value = '';
            document.getElementById('tanggal').value = '';
            document.getElementById('waktu').value = '';
            document.getElementById('tempat_kegiatan').value = '';
            
            updateNomor();
            document.getElementById('modalTambahSurat').classList.remove('hidden');
        }

        function openEditModal(id, data) {
            if (!document.getElementById('modalTambahSurat')) return;
            document.getElementById('modalTitle').innerText = 'Edit Surat Sosialisasi';
            document.getElementById('formSuratSosialisasi').action = `/sosialisasi/update/${id}`;
            document.getElementById('formMethod').value = 'PUT';

            // Extract nomor jika ada
            if (data.nomor_surat_full) {
                const parts = data.nomor_surat_full.split('/');
                if (parts.length >= 6) {
                    document.getElementById('ns_no').value = parts[0] || '';
                    document.getElementById('ns_kode').value = parts[2] || 'PERM';
                    document.getElementById('ns_bulan').value = parts[4] || '';
                    document.getElementById('ns_tahun').value = parts[5] || '';
                }
            }
            if (data.no_urut) document.getElementById('ns_no').value = data.no_urut;
            if (data.kode_surat) document.getElementById('ns_kode').value = data.kode_surat;
            else document.getElementById('ns_kode').value = 'PERM';
            if (data.bulan) document.getElementById('ns_bulan').value = data.bulan;
            if (data.tahun) document.getElementById('ns_tahun').value = data.tahun;

            document.getElementById('nama_kebijakan').value = data.nama_kebijakan || '';
            document.getElementById('nama_tempat').value = data.nama_tempat || '';

            // Hari & Tanggal
            document.getElementById('hari').value = data.hari || '';
            if (data.tanggal) {
                document.getElementById('tanggal').value = data.tanggal.substring(0, 10);
            } else {
                document.getElementById('tanggal').value = '';
                if (!data.hari && data.hari_tanggal) {
                    const parts = data.hari_tanggal.split(',');
                    if (parts.length > 1) {
                        document.getElementById('hari').value = parts[0].trim();
                    }
                }
            }

            // Clean waktu untuk input form
            let cleanWaktu = data.waktu || '';
            cleanWaktu = cleanWaktu.replace(/(\s*WITA|\s*-\s*Selesai|\s*Selesai)/gi, '').trim();
            cleanWaktu = cleanWaktu.replace(/-+$/, '').trim();
            document.getElementById('waktu').value = cleanWaktu || data.waktu || '';

            document.getElementById('tempat_kegiatan').value = data.tempat_kegiatan || '';

            updateNomor();
            document.getElementById('modalTambahSurat').classList.remove('hidden');
        }

        function closeAddModal() {
            if (document.getElementById('modalTambahSurat')) {
                document.getElementById('modalTambahSurat').classList.add('hidden');
            }
        }

        function openAmplopModal(id, nomor, perihal, tujuan) {
            document.getElementById('amplop_surat_id').value = id;
            document.getElementById('amplop_nomor_surat').value = nomor || '';
            document.getElementById('amplop_nama_tempat').value = tujuan || '';
            document.getElementById('amplop_perihal').value = perihal || '';
            document.getElementById('modalAmplopSurat').classList.remove('hidden');
        }

        function closeAmplopModal() {
            document.getElementById('modalAmplopSurat').classList.add('hidden');
        }

        function openDaftarHadirModal(id, namaKegiatan, waktu, hariTanggal, tempatKegiatan) {
            document.getElementById('dh_surat_id').value = id;
            document.getElementById('dh_nama_kegiatan').value = namaKegiatan || '';
            document.getElementById('dh_waktu').value = waktu || '';
            
            let lokasiGabung = hariTanggal || '';
            if (tempatKegiatan) {
                lokasiGabung += (lokasiGabung ? ' / ' : '') + tempatKegiatan;
            }
            document.getElementById('dh_hari_tanggal').value = lokasiGabung;
            
            document.getElementById('modalDaftarHadir').classList.remove('hidden');
        }

        function closeDaftarHadirModal() {
            document.getElementById('modalDaftarHadir').classList.add('hidden');
        }
    </script>
@endsection
