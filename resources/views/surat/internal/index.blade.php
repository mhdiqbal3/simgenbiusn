@extends('layout.app')

@section('content')
    {{-- ===== HEADER ===== --}}
    <div class="mb-8 animate-fade-in-down flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Surat Internal</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola dan buat surat resmi internal organisasi.</p>
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

    {{-- ===== TABEL ===== --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-50">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="text-xl font-extrabold text-gray-800">Daftar Surat Internal</h2>
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
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Ditujukan Kepada</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Perihal / Kegiatan</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="py-3.5 px-4 text-[10.5px] font-black text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50/80">
                    @foreach($suratInternals as $i => $surat)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-4 px-4 text-sm text-gray-400 font-semibold">{{ $i + 1 }}</td>

                            {{-- Nomor Surat --}}
                            <td class="py-4 px-4">
                                <p class="text-sm font-bold text-gray-800 leading-tight">{{ $surat->nomor_surat_full }}</p>
                            </td>

                            {{-- Jenis Badge --}}
                            <td class="py-4 px-4">
                                @if($surat->jenis_surat == 'Surat Peringatan')
                                    @php
                                        $spLabel = (str_contains($surat->nama_sp ?? '', '2') || str_contains($surat->nomor_surat_full ?? '', 'SP-2')) ? 'SP2' : 'SP1';
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-red-100 text-red-700">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> {{ $spLabel }}
                                    </span>
                                @elseif($surat->jenis_surat == 'Surat Undangan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-indigo-100 text-indigo-700">
                                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span> UND
                                    </span>
                                @elseif($surat->jenis_surat == 'Surat Tugas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> TGS
                                    </span>
                                @elseif($surat->jenis_surat == 'Surat Tugas Sosialisasi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-teal-100 text-teal-700">
                                        <span class="w-1.5 h-1.5 bg-teal-500 rounded-full"></span> TS
                                    </span>
                                @elseif($surat->jenis_surat == 'Surat Izin Kegiatan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10.5px] font-extrabold rounded-lg bg-purple-100 text-purple-700">
                                        <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span> PERM
                                    </span>
                                @endif
                            </td>

                            {{-- Ditujukan Kepada --}}
                            <td class="py-4 px-4">
                                @if($surat->jenis_surat == 'Surat Peringatan')
                                    <p class="text-sm font-bold text-gray-800">{{ $surat->anggota_sp }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $surat->divisi_sp }}</p>
                                @elseif($surat->jenis_surat == 'Surat Undangan')
                                    <p class="text-sm font-bold text-gray-800">Seluruh Anggota GenBI</p>
                                    <p class="text-xs text-gray-400 mt-0.5">USN Kolaka</p>
                                @elseif($surat->jenis_surat == 'Surat Tugas')
                                    <p class="text-sm font-bold text-gray-800">{{ $surat->anggota_st }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $surat->jabatan_st }} — {{ $surat->divisi_st }}</p>
                                @elseif($surat->jenis_surat == 'Surat Tugas Sosialisasi')
                                    <p class="text-sm font-bold text-gray-800">{{ $surat->anggota_st }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $surat->jabatan_st }} — {{ $surat->divisi_st }}</p>
                                @elseif($surat->jenis_surat == 'Surat Izin Kegiatan')
                                    <p class="text-sm font-bold text-gray-800">{{ $surat->kepada_izin }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Surat Izin</p>
                                @endif
                            </td>

                            {{-- Perihal --}}
                            <td class="py-4 px-4 max-w-[200px]">
                                @if($surat->jenis_surat == 'Surat Peringatan')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Surat Peringatan {{ $surat->nama_sp }}</p>
                                @elseif($surat->jenis_surat == 'Surat Undangan')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Surat Undangan {{ $surat->nama_undangan }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $surat->tanggal_kegiatan }} · {{ $surat->tempat_kegiatan }}</p>
                                @elseif($surat->jenis_surat == 'Surat Tugas')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Surat Tugas {{ $surat->kegiatan_st }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $surat->tanggal_kegiatan_st }}</p>
                                @elseif($surat->jenis_surat == 'Surat Tugas Sosialisasi')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Surat Tugas Sosialisasi</p>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $surat->kegiatan_st }}</p>
                                @elseif($surat->jenis_surat == 'Surat Izin Kegiatan')
                                    <p class="text-sm font-semibold text-gray-700 truncate">Surat Izin {{ $surat->nama_kegiatan_izin }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $surat->tanggal_kegiatan_izin }} · {{ $surat->tempat_kegiatan_izin }}</p>
                                @endif
                            </td>

                            {{-- Tanggal Dibuat --}}
                            <td class="py-4 px-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-600">{{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y') }}</p>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-4 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('surat.internal.download', $surat->id) }}" title="Unduh"
                                        class="p-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                    
                                    <button type="button" title="Edit" data-surat="{{ json_encode($surat) }}" onclick="openEditModal(JSON.parse(this.dataset.surat))" class="p-2.5 bg-yellow-50 text-yellow-600 rounded-xl hover:bg-yellow-500 hover:text-white transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <button type="button" title="Hapus" onclick="openDeleteModal('{{ route('surat.internal.destroy', $surat->id) }}')" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all flex items-center justify-center">
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
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg border border-gray-100">
                <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">Pilih Template Surat</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Unduh contoh format surat dalam file Word (.doc)</p>
                    </div>
                    <button onclick="document.getElementById('modalTemplate').classList.add('hidden')" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('surat.template.download', 'peringatan') }}" class="flex items-center gap-4 p-4 border-2 border-red-100 hover:border-red-300 hover:bg-red-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Surat Peringatan</p>
                            <p class="text-xs text-gray-400">Format SP dengan kop surat</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                    <a href="{{ route('surat.template.download', 'undangan') }}" class="flex items-center gap-4 p-4 border-2 border-indigo-100 hover:border-indigo-300 hover:bg-indigo-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Surat Undangan</p>
                            <p class="text-xs text-gray-400">Format undangan kegiatan resmi</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                    <a href="{{ route('surat.template.download', 'tugas') }}" class="flex items-center gap-4 p-4 border-2 border-emerald-100 hover:border-emerald-300 hover:bg-emerald-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Surat Tugas</p>
                            <p class="text-xs text-gray-400">Format penugasan anggota</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                    <a href="{{ route('surat.template.download', 'tugas_sosialisasi') }}" class="flex items-center gap-4 p-4 border-2 border-teal-100 hover:border-teal-300 hover:bg-teal-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Surat Tugas Sosialisasi</p>
                            <p class="text-xs text-gray-400">Format penugasan sosialisasi kebijakan</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                    <a href="{{ route('surat.template.download', 'izin') }}" class="flex items-center gap-4 p-4 border-2 border-purple-100 hover:border-purple-300 hover:bg-purple-50 rounded-2xl transition-all group">
                        <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-all flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-extrabold text-gray-800">Template Surat Izin Kegiatan</p>
                            <p class="text-xs text-gray-400">Format surat izin kegiatan</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== MODAL TAMBAH SURAT ===== --}}
    <div id="modalTambahSurat" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="tutupModal()"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[95vh] flex flex-col border border-gray-100 overflow-hidden">

                {{-- Header --}}
                <div class="px-8 py-5 border-b border-gray-50 flex justify-between items-center bg-white flex-shrink-0 z-10">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-800">Buat Surat Internal Baru</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Pilih jenis surat, isi semua data, lalu simpan.</p>
                    </div>
                    <button onclick="tutupModal()" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="overflow-y-auto w-full p-8 pt-6 custom-scrollbar flex-1">
                    <form id="formSurat" action="{{ route('surat.internal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                    {{-- Nomor Surat & Jenis Surat --}}
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-2">Jenis Surat <span class="text-red-500">*</span></label>
                            <select name="jenis_surat" id="jenis_surat" onchange="showFormSection(); setDefaultDivisiKode();" required
                                class="w-full bg-gray-50 border-2 border-gray-100 text-gray-800 text-sm rounded-xl focus:border-blue-500 block p-3 outline-none font-bold cursor-pointer">
                                <option value="" disabled selected>— Pilih Jenis —</option>
                                <option value="Surat Peringatan" data-kode="SP-1">⚠️ Surat Peringatan</option>
                                <option value="Surat Undangan" data-kode="UND">📅 Surat Undangan</option>
                                <option value="Surat Tugas" data-kode="TGS">✅ Surat Tugas</option>
                                <option value="Surat Tugas Sosialisasi" data-kode="TS">📢 Surat Tugas Sosialisasi</option>
                                <option value="Surat Izin Kegiatan" data-kode="PERM">📝 Surat Izin Kegiatan</option>
                            </select>
                        </div>

                        {{-- Struktur Nomor Surat Universal untuk Semua Surat Internal --}}
                        <div id="form-nomor-surat" class="bg-blue-50/50 border border-blue-100 rounded-2xl p-5">
                            <label class="block text-[11px] font-black text-blue-600 uppercase tracking-wider mb-3">Struktur Pengisian Nomor Surat <span class="text-red-500">*</span></label>
                            
                            <div class="flex flex-wrap items-center gap-1.5 mb-4">
                                {{-- 1. NOMOR --}}
                                <input type="text" name="ns_no" id="ns_no" value="{{ $nextNo }}" placeholder="{{ $nextNo }}" required class="w-14 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold transition-colors" oninput="updateNomorSurat()" title="Nomor Urut">
                                <span class="text-gray-400 font-bold">/</span>

                                {{-- 2. KODE INTERNAL (A) - Sembunyi untuk Surat Peringatan --}}
                                <div id="wrapper_kode_a" class="flex items-center gap-1.5">
                                    <input type="text" name="ns_kode" id="ns_kode" value="A" readonly class="w-10 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-500 outline-none" title="Klasifikasi Internal">
                                    <span class="text-gray-400 font-bold">/</span>
                                </div>

                                {{-- 3. JENIS (SP-1/SP-2 / UND / TGS / ST / PERM) --}}
                                <input type="text" id="ns_jenis" readonly class="w-16 bg-gray-100 border border-gray-200 text-center text-sm rounded-lg p-2 font-bold text-gray-600 outline-none" placeholder="JENIS" title="Jenis Surat">

                                {{-- 4. NAMA-KEGIATAN-DEVISI - Sembunyi Permanen Sesuai Format Baru --}}
                                <div id="wrapper_kegiatan_devisi" class="hidden items-center gap-1.5">
                                    <span class="text-gray-400 font-bold">/</span>
                                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden focus-within:border-blue-500 transition-colors bg-white">
                                        <input type="text" id="ns_nama_kegiatan" class="w-40 sm:w-48 bg-white text-center text-sm p-2 focus:bg-blue-50/20 outline-none font-bold transition-colors uppercase border-r border-gray-200" placeholder="NAMA-KEGIATAN" oninput="this.value = this.value.replace(/\s+/g, '-').toUpperCase(); updateNomorSurat()" title="Nama Kegiatan / Penugasan">
                                        <span class="text-gray-500 font-bold px-1.5 bg-gray-50 border-r border-gray-200">-</span>
                                        <select id="ns_divisi" class="w-24 sm:w-28 bg-white text-center text-sm p-2 outline-none font-bold cursor-pointer" onchange="updateNomorSurat()" title="Devisi">
                                            <option value="SEK">SEK</option>
                                            <option value="DIKBUD">DIKBUD</option>
                                            <option value="PENGMAS">PENGMAS</option>
                                            <option value="LINGDUP">LINGDUP</option>
                                            <option value="KWU">KWU</option>
                                            <option value="PDD">PDD</option>
                                            <option value="ALL">ALL</option>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="ns_jenis_divisi" id="ns_jenis_divisi">
                                <span class="text-gray-400 font-bold">/</span>

                                {{-- 5. KOMS (GENBI-KOMS-USN / GENBI-SULTRA) --}}
                                <span id="teks_koms" class="text-gray-600 font-bold text-[11px] bg-gray-100 border border-gray-200 rounded-lg py-2.5 px-3">GENBI-KOMS-USN</span>
                                <span class="text-gray-400 font-bold">/</span>

                                {{-- 6. BULAN --}}
                                @php
                                    $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
                                    $currentMonthRoman = $romanMonths[date('n') - 1];
                                @endphp
                                <input type="text" name="ns_bulan" id="ns_bulan" value="{{ $currentMonthRoman }}" required class="w-14 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold transition-colors" oninput="updateNomorSurat()" title="Bulan (Romawi)">
                                <span class="text-gray-400 font-bold">/</span>

                                {{-- 7. TAHUN --}}
                                <input type="text" name="ns_tahun" id="ns_tahun" value="{{ date('Y') }}" required class="w-16 bg-white border border-gray-200 text-center text-sm rounded-lg p-2 focus:border-blue-500 outline-none font-bold transition-colors" oninput="updateNomorSurat()" title="Tahun">
                            </div>

                            <input type="hidden" name="nomor_surat_full" id="nomor_surat_full">
                            <p class="text-xs text-gray-500">Hasil: <span id="preview_nomor" class="font-bold text-blue-600 tracking-wide">...</span></p>
                        </div>
                    </div>

                    {{-- ====== SURAT PERINGATAN ====== --}}
                    <div id="form-peringatan" class="hidden">
                        <div class="bg-red-50/60 border-2 border-red-100 rounded-2xl overflow-hidden">
                            <div class="bg-red-500 px-5 py-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <h4 class="text-sm font-extrabold text-white">Data Surat Peringatan (SP)</h4>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- Hidden Level SP (Otomatis dari Poin Keaktifan) --}}
                                <input type="hidden" name="nama_sp" id="nama_sp" value="Pertama (SP 1)">

                                {{-- Pilih dari poin --}}
                                    @if($poins->count() > 0)
                                    <div>
                                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">
                                            Pilih Anggota dari Halaman Poin Keaktifan
                                            <span class="text-gray-400 normal-case font-semibold">(isi otomatis)</span>
                                        </label>
                                        <select id="pilih_poin" onchange="fillPeringatanData()"
                                            class="w-full bg-white border-2 border-red-100 text-gray-800 text-sm rounded-xl focus:border-red-400 block p-3 outline-none font-semibold cursor-pointer">
                                            <option value="">— Pilih anggota dengan status SP —</option>
                                            @foreach($poins as $poin)
                                                <option value="{{ $poin->id }}"
                                                    data-nama="{{ $poin->nama_lengkap }}"
                                                    data-divisi="{{ $poin->devisi }}"
                                                    data-sp="{{ $poin->sp }}">
                                                    {{ $poin->nama_lengkap }} ({{ $poin->sp }}) — {{ $poin->devisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <div class="flex-1 h-px bg-gray-200"></div><span>atau isi manual</span><div class="flex-1 h-px bg-gray-200"></div>
                                    </div>
                                    @endif

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        {{-- Nama Anggota --}}
                                        <div class="sm:col-span-2">
                                            <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Nama Anggota yang Diberi SP</label>
                                            <input type="text" name="anggota_sp" id="anggota_sp" placeholder="Nama lengkap anggota"
                                                class="w-full bg-white border-2 border-red-100 text-gray-700 text-sm rounded-xl focus:border-red-400 block p-3 outline-none font-semibold">
                                        </div>
                                        {{-- Departemen --}}
                                        <div class="sm:col-span-2">
                                            <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Departemen / Divisi</label>
                                            <input type="text" name="divisi_sp" id="divisi_sp" placeholder="Nama divisi"
                                                class="w-full bg-white border-2 border-red-100 text-gray-700 text-sm rounded-xl focus:border-red-400 block p-3 outline-none font-semibold">
                                        </div>
                                    </div>

                                {{-- Input Berkas SP Kedua --}}
                                <div id="sp-fields-upload" class="hidden">
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Upload Berkas SP Kedua Dari Wilayah <span class="text-red-500">*</span></label>
                                        <input type="file" name="berkas_sp" id="berkas_sp" accept=".pdf,image/*,.doc,.docx"
                                            class="w-full bg-white border-2 border-red-100 text-gray-700 text-sm rounded-xl focus:border-red-400 block p-2 outline-none font-semibold file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition-all cursor-pointer">
                                        <p class="text-[10px] text-gray-400 mt-2 font-semibold">* Upload dokumen (PDF/Word/Gambar) Surat Peringatan Kedua yang berasal dari pengurus wilayah.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ====== SURAT UNDANGAN ====== --}}
                    <div id="form-undangan" class="hidden">
                        <div class="bg-indigo-50/60 border-2 border-indigo-100 rounded-2xl overflow-hidden">
                            <div class="bg-indigo-500 px-5 py-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <h4 class="text-sm font-extrabold text-white">Data Surat Undangan (SU)</h4>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- Pilih dari kegiatan --}}
                                @if($kegiatans->count() > 0)
                                <div>
                                    <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">
                                        Pilih dari Halaman Kegiatan
                                        <span class="text-gray-400 normal-case font-semibold">(isi otomatis)</span>
                                    </label>
                                    <select id="pilih_kegiatan" onchange="fillUndanganData()"
                                        class="w-full bg-white border-2 border-indigo-100 text-gray-800 text-sm rounded-xl focus:border-indigo-400 block p-3 outline-none font-semibold cursor-pointer">
                                        <option value="">— Pilih kegiatan —</option>
                                        @foreach($kegiatans as $k)
                                            <option value="{{ $k->id }}"
                                                data-nama="{{ $k->nama_kegiatan }}"
                                                data-tanggal="{{ \Carbon\Carbon::parse($k->tanggal)->format('Y-m-d') }}"
                                                data-waktu="{{ \Carbon\Carbon::parse($k->waktu)->format('H:i') }}"
                                                data-tempat="{{ $k->tempat }}"
                                                data-devisi="{{ $k->devisi }}">
                                                {{ $k->nama_kegiatan }} — {{ \Carbon\Carbon::parse($k->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <div class="flex-1 h-px bg-gray-200"></div><span>atau isi manual</span><div class="flex-1 h-px bg-gray-200"></div>
                                </div>
                                @endif

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Nama / Perihal Undangan</label>
                                        <input type="text" name="nama_undangan" id="nama_undangan" placeholder="Contoh: Rapat Koordinasi Bulanan"
                                            class="w-full bg-white border-2 border-indigo-100 text-gray-700 text-sm rounded-xl focus:border-indigo-400 block p-3 outline-none font-semibold"
                                            oninput="if(document.getElementById('jenis_surat').value === 'Surat Undangan') { document.getElementById('ns_nama_kegiatan').value = this.value.replace(/\s+/g, '-').toUpperCase(); updateNomorSurat(); }">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Hari / Tanggal</label>
                                        <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan"
                                            class="w-full bg-white border-2 border-indigo-100 text-gray-700 text-sm rounded-xl focus:border-indigo-400 block p-3 outline-none font-semibold">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Waktu</label>
                                        <input type="time" name="waktu_kegiatan" id="waktu_kegiatan"
                                            class="w-full bg-white border-2 border-indigo-100 text-gray-700 text-sm rounded-xl focus:border-indigo-400 block p-3 outline-none font-semibold">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Tempat</label>
                                        <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" placeholder="Nama gedung / lokasi"
                                            class="w-full bg-white border-2 border-indigo-100 text-gray-700 text-sm rounded-xl focus:border-indigo-400 block p-3 outline-none font-semibold">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ====== SURAT TUGAS ====== --}}
                    <div id="form-tugas" class="hidden">
                        <div class="bg-emerald-50/60 border-2 border-emerald-100 rounded-2xl overflow-hidden">
                            <div class="bg-emerald-500 px-5 py-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h4 class="text-sm font-extrabold text-white">Data Surat Tugas (ST)</h4>
                            </div>
                            <div class="p-5 space-y-5">

                                {{-- Penandatangan --}}
                                {{-- Nama Ketua Umum kini diambil otomatis dari user dengan role admin --}}

                                {{-- Detail Kegiatan --}}
                                <div class="mb-6">
                                    <p class="text-[11px] font-black text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <span class="w-4 h-px bg-gray-300 inline-block"></span> Detail Kegiatan Penugasan
                                    </p>
                                    
                                    @if($kegiatans->count() > 0)
                                    <div class="mb-4">
                                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">
                                            Pilih dari Data Kegiatan
                                            <span class="text-gray-400 normal-case font-semibold">(isi otomatis)</span>
                                        </label>
                                        <select id="pilih_kegiatan_st" onchange="fillTugasKegiatanData()"
                                            class="w-full bg-white border-2 border-emerald-100 text-gray-800 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold cursor-pointer">
                                            <option value="">— Pilih kegiatan —</option>
                                            @foreach($kegiatans as $k)
                                                <option value="{{ $k->id }}"
                                                    data-nama="{{ $k->nama_kegiatan }}"
                                                    data-tanggal="{{ \Carbon\Carbon::parse($k->tanggal)->format('Y-m-d') }}"
                                                    data-waktu="{{ \Carbon\Carbon::parse($k->waktu)->format('H:i') }}"
                                                    data-tempat="{{ $k->tempat }}">
                                                    {{ $k->nama_kegiatan }} — {{ \Carbon\Carbon::parse($k->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Nama Kegiatan</label>
                                            <input type="text" id="kegiatan_st" name="kegiatan_st" placeholder="Nama kegiatan"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold"
                                                oninput="if(document.getElementById('jenis_surat').value === 'Surat Tugas') { document.getElementById('ns_nama_kegiatan').value = this.value.replace(/\s+/g, '-').toUpperCase(); updateNomorSurat(); }">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Tema Kegiatan</label>
                                            <input type="text" id="tema_st" name="tema_st" placeholder="Tema kegiatan"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Hari / Tanggal</label>
                                            <input type="date" id="tanggal_kegiatan_st" name="tanggal_kegiatan_st"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Waktu</label>
                                            <input type="time" id="waktu_kegiatan_st" name="waktu_kegiatan_st"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Tempat Kegiatan</label>
                                            <input type="text" id="tempat_kegiatan_st" name="tempat_kegiatan_st" placeholder="Nama gedung / lokasi"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold">
                                        </div>
                                    </div>
                                </div>

                                {{-- Penerima Tugas --}}
                                <div>
                                    <p class="text-[11px] font-black text-gray-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                        <span class="w-4 h-px bg-gray-300 inline-block"></span> Penerima Tugas (Anggota)
                                    </p>
                                    
                                    @if(isset($semuaAnggota) && $semuaAnggota->count() > 0)
                                    <div class="mb-4">
                                        <label class="block text-[11px] font-black text-gray-500 uppercase tracking-wider mb-1.5">
                                            Pilih dari Data Anggota
                                            <span class="text-gray-400 normal-case font-semibold">(isi otomatis)</span>
                                        </label>
                                        <select id="pilih_anggota_st" onchange="fillTugasAnggotaData()"
                                            class="w-full bg-white border-2 border-emerald-100 text-gray-800 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold cursor-pointer">
                                            <option value="">— Pilih anggota —</option>
                                            @foreach($semuaAnggota as $anggota)
                                                <option value="{{ $anggota->id }}"
                                                    data-nama="{{ $anggota->name }}"
                                                    data-divisi="{{ $anggota->devisi }}">
                                                    {{ $anggota->name }} — {{ $anggota->devisi }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div class="sm:col-span-2">
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Nama Anggota yang Ditugaskan</label>
                                            <input type="text" id="anggota_st" name="anggota_st" placeholder="Nama lengkap anggota"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Jabatan dalam Kepanitiaan <span class="text-emerald-500">*</span></label>
                                            <select id="jabatan_st" name="jabatan_st" onchange="toggleStempelTugas()"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold cursor-pointer">
                                                <option value="Ketua Panitia">Ketua Panitia</option>
                                                <option value="Sekretaris Panitia">Sekretaris Panitia</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Departemen / Divisi</label>
                                            <input type="text" id="divisi_st" name="divisi_st" placeholder="Nama divisi"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-3 outline-none font-semibold"
                                                oninput="if(document.getElementById('jenis_surat').value === 'Surat Tugas') { document.getElementById('ns_divisi').value = mapDivisiAbbrev(this.value); updateNomorSurat(); }">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Tanda Tangan (Opsional)</label>
                                            <input type="file" id="ttd_kepanitiaan" name="ttd_kepanitiaan" accept="image/*"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-2 outline-none font-semibold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                            <p class="text-[10px] text-gray-400 mt-1">Upload tanda tangan format gambar</p>
                                        </div>
                                        <div id="stempel_container" class="hidden">
                                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5">Stempel (Opsional)</label>
                                            <input type="file" id="stempel_kepanitiaan" name="stempel_kepanitiaan" accept="image/*"
                                                class="w-full bg-white border-2 border-emerald-100 text-gray-700 text-sm rounded-xl focus:border-emerald-400 block p-2 outline-none font-semibold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                            <p class="text-[10px] text-gray-400 mt-1">Upload stempel panitia (opsional)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ====== SURAT TUGAS SOSIALISASI ====== --}}
                    <div id="form-tugas-sosialisasi" class="hidden">
                        <div class="bg-teal-50/60 border-2 border-teal-100 rounded-2xl overflow-hidden">
                            <div class="bg-teal-600 px-5 py-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <h4 class="text-sm font-extrabold text-white">Data Surat Tugas Sosialisasi</h4>
                            </div>
                            <div class="p-5 space-y-4">
                                {{-- 1. Kelompok Sosialisasi (Pilihan Kelompok 1-10) --}}
                                <div>
                                    <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Kelompok Sosialisasi <span class="text-red-500">*</span></label>
                                    <select id="kegiatan_sos" name="kegiatan_sos" onchange="syncKegiatanSosialisasi()"
                                        class="w-full bg-white border-2 border-teal-100 text-gray-800 text-sm rounded-xl focus:border-teal-400 block p-3 outline-none font-semibold cursor-pointer">
                                        <option value="" disabled selected>— Pilih Kelompok —</option>
                                        @for($k = 1; $k <= 10; $k++)
                                            <option value="Kelompok {{ $k }}">Kelompok {{ $k }}</option>
                                        @endfor
                                    </select>
                                </div>

                                {{-- 2. Nama Anggota (Ambil data Dari Kelola User) --}}
                                <div>
                                    <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Nama Anggota <span class="text-red-500">*</span></label>
                                    <select id="anggota_sos" name="anggota_sos" onchange="syncAnggotaSosialisasi()"
                                        class="w-full bg-white border-2 border-teal-100 text-gray-800 text-sm rounded-xl focus:border-teal-400 block p-3 outline-none font-semibold cursor-pointer">
                                        <option value="" disabled selected>— Pilih Anggota —</option>
                                        @foreach($semuaAnggota as $anggota)
                                            <option value="{{ $anggota->name }}" data-divisi="{{ $anggota->devisi ?? '' }}">
                                                {{ $anggota->name }} @if(!empty($anggota->devisi)) ({{ $anggota->devisi }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- 3. Departemen / Devisi & 4. Jabatan --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Departemen / Devisi <span class="text-red-500">*</span></label>
                                        <input type="text" id="divisi_sos" name="divisi_sos" list="list_devisi_sos" placeholder="Pilih atau ketik devisi..."
                                            class="w-full bg-white border-2 border-teal-100 text-gray-700 text-sm rounded-xl p-3 outline-none font-semibold focus:border-teal-400 transition-colors">
                                        <datalist id="list_devisi_sos">
                                            @php
                                                $daftarDevisi = isset($devisis) ? $devisis : \App\Models\Devisi::all();
                                            @endphp
                                            @foreach($daftarDevisi as $dev)
                                                <option value="{{ $dev->nama_devisi }}">{{ $dev->nama_devisi }}</option>
                                            @endforeach
                                            <option value="Kesekretariatan">Kesekretariatan</option>
                                        </datalist>
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Jabatan <span class="text-red-500">*</span></label>
                                        <select id="jabatan_sos" name="jabatan_sos"
                                            class="w-full bg-white border-2 border-teal-100 text-gray-800 text-sm rounded-xl focus:border-teal-400 block p-3 outline-none font-semibold cursor-pointer">
                                            <option value="Ketua Kelompok">Ketua Kelompok</option>
                                            <option value="Sekretaris Kelompok">Sekretaris Kelompok</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ====== SURAT IZIN KEGIATAN ====== --}}
                    <div id="form-izin" class="hidden">
                        <div class="bg-purple-50/60 border-2 border-purple-100 rounded-2xl overflow-hidden">
                            <div class="bg-purple-500 px-5 py-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <h4 class="text-sm font-extrabold text-white">Data Surat Izin Kegiatan (SIK)</h4>
                            </div>
                            <div class="p-5 space-y-4">
                                @if(isset($kegiatans) && $kegiatans->count() > 0)
                                <div class="bg-white border-2 border-purple-200 rounded-xl p-3 shadow-sm">
                                    <label class="block text-[11px] font-black text-purple-600 uppercase tracking-wider mb-2">Pilih Data Kegiatan (Otomatis)</label>
                                    <select id="pilih_kegiatan_izin" class="w-full bg-purple-50 border border-purple-100 text-gray-800 text-sm rounded-lg focus:border-purple-500 block p-2.5 outline-none font-semibold cursor-pointer" onchange="fillIzinKegiatanData()">
                                        <option value="" selected>— Isi Manual Saja —</option>
                                        @foreach($kegiatans as $k)
                                            <option value="{{ $k->id }}" 
                                                data-nama="{{ $k->nama_kegiatan }}"
                                                data-tanggal="{{ \Carbon\Carbon::parse($k->tanggal)->format('Y-m-d') }}"
                                                data-waktu="{{ \Carbon\Carbon::parse($k->waktu)->format('H:i') }}"
                                                data-tempat="{{ $k->tempat }}"
                                                data-devisi="{{ $k->devisi }}">
                                                {{ $k->nama_kegiatan }} — {{ \Carbon\Carbon::parse($k->tanggal)->locale('id')->isoFormat('D MMM YYYY') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-400">
                                    <div class="flex-1 h-px bg-gray-200"></div><span>atau isi manual</span><div class="flex-1 h-px bg-gray-200"></div>
                                </div>
                                @endif
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Kepada Yth. (Nama/Jabatan yang Diundang)</label>
                                        <input type="text" name="kepada_izin" id="kepada_izin" placeholder="Contoh: Rektor USN Kolaka"
                                            class="w-full bg-white border-2 border-purple-100 text-gray-700 text-sm rounded-xl focus:border-purple-400 block p-3 outline-none font-semibold">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Nama Kegiatan</label>
                                        <input type="text" name="nama_kegiatan_izin" id="nama_kegiatan_izin" placeholder="Nama kegiatan"
                                            class="w-full bg-white border-2 border-purple-100 text-gray-700 text-sm rounded-xl focus:border-purple-400 block p-3 outline-none font-semibold" oninput="document.getElementById('ns_nama_kegiatan').value = this.value.replace(/\s+/g, '-').toUpperCase(); updateNomorSurat();">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Status Anggota (Mahasiswa/Anak)</label>
                                        <select name="status_anggota_izin" id="status_anggota_izin"
                                            class="w-full bg-white border-2 border-purple-100 text-gray-700 text-sm rounded-xl focus:border-purple-400 block p-3 outline-none font-semibold cursor-pointer">
                                            <option value="Mahasiswa">Mahasiswa</option>
                                            <option value="Anak">Anak</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Hari / Tanggal</label>
                                        <input type="date" name="tanggal_kegiatan_izin" id="tanggal_kegiatan_izin"
                                            class="w-full bg-white border-2 border-purple-100 text-gray-700 text-sm rounded-xl focus:border-purple-400 block p-3 outline-none font-semibold">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Waktu</label>
                                        <input type="time" name="waktu_kegiatan_izin" id="waktu_kegiatan_izin"
                                            class="w-full bg-white border-2 border-purple-100 text-gray-700 text-sm rounded-xl focus:border-purple-400 block p-3 outline-none font-semibold">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[11px] font-black text-gray-600 uppercase tracking-wider mb-1.5">Tempat</label>
                                        <input type="text" name="tempat_kegiatan_izin" id="tempat_kegiatan_izin" placeholder="Nama tempat/lokasi"
                                            class="w-full bg-white border-2 border-purple-100 text-gray-700 text-sm rounded-xl focus:border-purple-400 block p-3 outline-none font-semibold">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>

                {{-- Tombol Aksi (Footer) --}}
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3 flex-shrink-0 z-10">
                    <button type="button" onclick="tutupModal()" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 font-bold rounded-xl text-sm transition-colors">Batal</button>
                    <button type="button" id="submitBtnSurat" onclick="document.getElementById('formSurat').submit()" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl text-sm hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/30 transition-all">
                        💾 Simpan & Generate Surat
                    </button>
                </div>
            </div>
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
                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus surat ini? Tindakan ini tidak dapat dibatalkan dan data surat akan hilang permanen.</p>
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

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }
        
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.75rem; border: 2px solid #f3f4f6; padding: 0.35rem 0.75rem; font-size: 0.8rem; outline: none; transition: border-color 0.2s;
        }
        .dataTables_wrapper .dataTables_filter input { margin-left: 0.5rem; }
        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus { border-color: #3b82f6; }
        .dataTables_wrapper .dataTables_info { font-size: 0.78rem; color: #9ca3af; margin-top: 1.25rem; }
        .dataTables_wrapper .dataTables_paginate { margin-top: 1rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 0.5rem !important; padding: 0.3rem 0.75rem !important; font-size: 0.78rem !important; font-weight: 700 !important; border: none !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #3b82f6 !important; color: white !important; }
        table.dataTable.no-footer { border-bottom: 2px solid #f3f4f6; }
        table.dataTable thead th, table.dataTable tbody td { padding-top: 0; padding-bottom: 0; }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                language: {
                    emptyTable: "Belum ada data surat internal. Klik 'Tambah Surat' untuk membuat surat baru.",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ – _END_ dari _TOTAL_ surat",
                    infoEmpty: "Tidak ada data",
                    paginate: { first: "«", last: "»", next: "›", previous: "‹" }
                }
            });
        });

        function tutupModal() {
            document.getElementById('modalTambahSurat').classList.add('hidden');
        }

        function showFormSection() {
            const jenis = document.getElementById('jenis_surat').value;
            ['form-peringatan', 'form-undangan', 'form-tugas', 'form-tugas-sosialisasi', 'form-izin'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('hidden');
            });
            
            const nomorSuratDiv = document.getElementById('form-nomor-surat');
            if (nomorSuratDiv) nomorSuratDiv.classList.remove('hidden');
            ['ns_no', 'ns_bulan', 'ns_tahun'].forEach(id => {
                const el = document.getElementById(id);
                if(el) el.required = true;
            });

            if (jenis === 'Surat Peringatan') {
                document.getElementById('form-peringatan').classList.remove('hidden');
            } else if (jenis === 'Surat Undangan') {
                document.getElementById('form-undangan').classList.remove('hidden');
            } else if (jenis === 'Surat Tugas') {
                document.getElementById('form-tugas').classList.remove('hidden');
            } else if (jenis === 'Surat Tugas Sosialisasi') {
                document.getElementById('form-tugas-sosialisasi').classList.remove('hidden');
            } else if (jenis === 'Surat Izin Kegiatan') {
                document.getElementById('form-izin').classList.remove('hidden');
            }

            updateNomorSuratFormLayout();
        }

        function mapDivisiAbbrev(devisi) {
            if (!devisi) return 'SEK';
            const d = devisi.toLowerCase();
            if (d.includes('pendidikan') || devisi.toUpperCase() === 'DIKBUD') return 'DIKBUD';
            if (d.includes('lingkungan') || devisi.toUpperCase() === 'LINGDUP') return 'LINGDUP';
            if (d.includes('pengabdian') || devisi.toUpperCase() === 'PENGMAS') return 'PENGMAS';
            if (d.includes('kewirausahaan') || devisi.toUpperCase() === 'KWU') return 'KWU';
            if (d.includes('publikasi') || d.includes('dekorasi') || devisi.toUpperCase() === 'PDD') return 'PDD';
            if (d.includes('kesekretariatan') || devisi.toUpperCase() === 'SEK') return 'SEK';
            if (devisi.toUpperCase() === 'ALL') return 'ALL';
            return 'SEK';
        }

        function updateNomorSuratFormLayout() {
            const jenis = document.getElementById('jenis_surat').value;
            const levelSP = document.getElementById('nama_sp') ? document.getElementById('nama_sp').value : '';
            const uploadFields = document.getElementById('sp-fields-upload');
            const inputBerkas = document.getElementById('berkas_sp');
            const isEditMode = document.getElementById('formMethod') !== null;
            const teksKoms = document.getElementById('teks_koms');
            const nsJenis = document.getElementById('ns_jenis');
            const wrapperKodeA = document.getElementById('wrapper_kode_a');
            const wrapperKegiatanDevisi = document.getElementById('wrapper_kegiatan_devisi');

            if (jenis === 'Surat Peringatan') {
                if (wrapperKodeA) wrapperKodeA.classList.add('hidden');
                if (wrapperKegiatanDevisi) wrapperKegiatanDevisi.classList.add('hidden');

                const isSP2 = levelSP.includes('2') || levelSP.includes('Kedua');

                if (uploadFields) {
                    if (isSP2) {
                        uploadFields.classList.remove('hidden');
                        if (inputBerkas) inputBerkas.required = !isEditMode;
                    } else {
                        uploadFields.classList.add('hidden');
                        if (inputBerkas) inputBerkas.required = false;
                    }
                }
                if (nsJenis) {
                    nsJenis.value = isSP2 ? 'SP-2' : 'SP-1';
                }
                if (teksKoms) {
                    teksKoms.innerText = isSP2 ? 'GENBI-SULTRA' : 'GENBI-KOMS-USN';
                }
            } else {
                if (wrapperKodeA) wrapperKodeA.classList.remove('hidden');
                if (wrapperKegiatanDevisi) wrapperKegiatanDevisi.classList.add('hidden');

                if (uploadFields) uploadFields.classList.add('hidden');
                if (inputBerkas) inputBerkas.required = false;
                
                if (teksKoms) teksKoms.innerText = 'GENBI-KOMS-USN';

                if (nsJenis) {
                    if (jenis === 'Surat Undangan') nsJenis.value = 'UND';
                    else if (jenis === 'Surat Tugas') nsJenis.value = 'TGS';
                    else if (jenis === 'Surat Tugas Sosialisasi') nsJenis.value = 'TS';
                    else if (jenis === 'Surat Izin Kegiatan') nsJenis.value = 'PERM';
                }
            }

            updateNomorSurat();
        }

        function toggleUploadBerkasSP() {
            updateNomorSuratFormLayout();
        }

        function openAddModal() {
            const modal = document.getElementById('modalTambahSurat');
            modal.classList.remove('hidden');
            
            modal.querySelector('h3').innerText = 'Buat Surat Internal Baru';
            modal.querySelector('h3').nextElementSibling.innerText = 'Pilih jenis surat, isi semua data, lalu simpan.';
            document.getElementById('submitBtnSurat').innerHTML = '<svg class="w-4 h-4 inline-block -mt-1 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg> Simpan & Generate Surat';
            
            const form = document.getElementById('formSurat');
            form.action = "{{ route('surat.internal.store') }}";
            form.reset();

            // Set nomor urut otomatis ke nomor urut berikutnya
            const nextNo = "{{ $nextNo }}";
            if (document.getElementById('ns_no')) {
                document.getElementById('ns_no').value = nextNo;
            }
            
            const methodInput = document.getElementById('formMethod');
            if(methodInput) methodInput.remove();

            // Reset type of date inputs back to date
            if (document.getElementById('tanggal_kegiatan')) document.getElementById('tanggal_kegiatan').type = 'date';
            if (document.getElementById('tanggal_kegiatan_st')) document.getElementById('tanggal_kegiatan_st').type = 'date';
            if (document.getElementById('tanggal_kegiatan_izin')) document.getElementById('tanggal_kegiatan_izin').type = 'date';
            
            // Reset readonly state manually
            document.querySelectorAll('#formSurat input, #formSurat select').forEach(el => {
                if(el.id !== 'ns_kode' && el.id !== 'ns_jenis' && el.id !== 'ns_jenis_divisi' && el.id !== 'nama_sp' && el.id !== 'divisi_sos') {
                   if(el.hasAttribute('readonly')) {
                      el.readOnly = false;
                      el.classList.remove('bg-gray-100', 'text-gray-500', 'pointer-events-none');
                      el.classList.add('bg-white', 'text-gray-700');
                   }
                }
            });

            if(document.getElementById('ns_nama_kegiatan')) document.getElementById('ns_nama_kegiatan').value = '';
            if(document.getElementById('ns_divisi')) document.getElementById('ns_divisi').value = 'SEK';
            if(document.getElementById('teks_koms')) document.getElementById('teks_koms').innerText = 'GENBI-KOMS-USN';
            if(document.getElementById('kegiatan_sos')) document.getElementById('kegiatan_sos').value = '';
            if(document.getElementById('anggota_sos')) document.getElementById('anggota_sos').value = '';
            if(document.getElementById('divisi_sos')) document.getElementById('divisi_sos').value = '';
            if(document.getElementById('jabatan_sos')) document.getElementById('jabatan_sos').value = 'Ketua Kelompok';
            if(document.getElementById('nama_sp')) document.getElementById('nama_sp').value = 'Pertama (SP 1)';

            document.getElementById('jenis_surat').dispatchEvent(new Event('change'));
            updateNomorSurat();
        }

        function formatToDateInput(val) {
            if (!val) return '';
            if (/^\d{4}-\d{2}-\d{2}$/.test(val)) return val;
            
            const months = {
                'januari': '01', 'februari': '02', 'maret': '03', 'april': '04',
                'mei': '05', 'juni': '06', 'juli': '07', 'agustus': '08',
                'september': '09', 'oktober': '10', 'november': '11', 'desember': '12',
                'jan': '01', 'feb': '02', 'mar': '03', 'apr': '04',
                'jun': '06', 'jul': '07', 'agu': '08', 'ags': '08',
                'sep': '09', 'okt': '10', 'nov': '11', 'des': '12'
            };
            const match = val.match(/(\d{1,2})\s+([a-zA-Z]+)\s+(\d{4})/);
            if (match) {
                const day = match[1].padStart(2, '0');
                const monthKey = match[2].toLowerCase();
                const year = match[3];
                if (months[monthKey]) {
                    return `${year}-${months[monthKey]}-${day}`;
                }
            }
            return '';
        }

        function formatToTimeInput(val) {
            if (!val) return '';
            const match = val.match(/(\d{1,2})[:.](\d{2})/);
            if (match) {
                return `${match[1].padStart(2, '0')}:${match[2]}`;
            }
            return val.replace('.', ':');
        }

        function openEditModal(surat) {
            const modal = document.getElementById('modalTambahSurat');
            modal.classList.remove('hidden');

            modal.querySelector('h3').innerText = 'Edit Surat Internal';
            modal.querySelector('h3').nextElementSibling.innerText = 'Silakan ubah data surat yang diperlukan lalu simpan.';
            document.getElementById('submitBtnSurat').innerHTML = 'Simpan Perubahan';

            const form = document.getElementById('formSurat');
            form.action = `/surat-internal/update/${surat.id}`;
            let methodInput = document.getElementById('formMethod');
            if(!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.id = 'formMethod';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            // Reset Pilihan Select Otomatis
            if(document.getElementById('pilih_poin')) document.getElementById('pilih_poin').value = '';
            if(document.getElementById('pilih_kegiatan')) document.getElementById('pilih_kegiatan').value = '';
            if(document.getElementById('pilih_anggota_st')) document.getElementById('pilih_anggota_st').value = '';
            if(document.getElementById('pilih_kegiatan_st')) document.getElementById('pilih_kegiatan_st').value = '';
            if(document.getElementById('pilih_kegiatan_izin')) document.getElementById('pilih_kegiatan_izin').value = '';
            if(document.getElementById('pilih_anggota_sos')) document.getElementById('pilih_anggota_sos').value = '';
            
            // Buka kembali form agar bisa diisi
            document.querySelectorAll('#formSurat input, #formSurat select, #formSurat textarea').forEach(el => {
                if(el.id !== 'ns_kode' && el.id !== 'ns_jenis' && el.id !== 'ns_jenis_divisi' && el.id !== 'nama_sp') {
                   if(el.hasAttribute('readonly')) {
                      el.readOnly = false;
                      el.classList.remove('bg-gray-100', 'text-gray-500', 'pointer-events-none');
                      el.classList.add('bg-white', 'text-gray-700');
                   }
                }
            });

            if (document.getElementById('ns_no')) document.getElementById('ns_no').value = surat.no_urut || '';
            if (document.getElementById('ns_kode')) document.getElementById('ns_kode').value = surat.kode_surat || 'A';
            if (document.getElementById('ns_bulan')) document.getElementById('ns_bulan').value = surat.bulan || '';
            if (document.getElementById('ns_tahun')) document.getElementById('ns_tahun').value = surat.tahun || '';
            
            const jenisSelect = document.getElementById('jenis_surat');
            if (jenisSelect) {
                jenisSelect.value = surat.jenis_surat;
                jenisSelect.dispatchEvent(new Event('change'));
            }

            // Parsing nomor surat universal (7 segmen: no / kode / jenis / namaKeg-divisi / koms / bulan / tahun)
            const validDivisi = ['SEK', 'DIKBUD', 'PENGMAS', 'LINGDUP', 'KWU', 'PDD', 'ALL'];
            const fullNomor = surat.nomor_surat_full || '';
            let parsedKeg = '';
            let parsedDiv = 'SEK';

            if (fullNomor.includes('/')) {
                const parts = fullNomor.split('/').map(s => s.trim());
                if (surat.jenis_surat === 'Surat Peringatan') {
                    if (parts.length === 5) {
                        if (document.getElementById('ns_no')) document.getElementById('ns_no').value = parts[0] || surat.no_urut || '';
                        if (document.getElementById('ns_jenis')) document.getElementById('ns_jenis').value = parts[1] || '';
                        if (parts[2] && document.getElementById('teks_koms')) {
                            document.getElementById('teks_koms').innerText = parts[2];
                        }
                        if (document.getElementById('ns_bulan')) document.getElementById('ns_bulan').value = parts[3] || surat.bulan || '';
                        if (document.getElementById('ns_tahun')) document.getElementById('ns_tahun').value = parts[4] || surat.tahun || '';
                    } else if (parts.length >= 7) {
                        if (document.getElementById('ns_no')) document.getElementById('ns_no').value = parts[0] || surat.no_urut || '';
                        if (document.getElementById('ns_kode')) document.getElementById('ns_kode').value = parts[1] || 'A';
                        if (document.getElementById('ns_jenis')) document.getElementById('ns_jenis').value = parts[2] || '';
                        if (parts[4] && document.getElementById('teks_koms')) {
                            document.getElementById('teks_koms').innerText = parts[4];
                        }
                        if (document.getElementById('ns_bulan')) document.getElementById('ns_bulan').value = parts[5] || surat.bulan || '';
                        if (document.getElementById('ns_tahun')) document.getElementById('ns_tahun').value = parts[6] || surat.tahun || '';
                    }
                } else if (parts.length === 6) {
                    if (document.getElementById('ns_no')) document.getElementById('ns_no').value = parts[0] || surat.no_urut || '';
                    if (document.getElementById('ns_kode')) document.getElementById('ns_kode').value = parts[1] || 'A';
                    if (document.getElementById('ns_jenis')) document.getElementById('ns_jenis').value = parts[2] || '';
                    if (parts[3] && document.getElementById('teks_koms')) {
                        document.getElementById('teks_koms').innerText = parts[3];
                    }
                    if (document.getElementById('ns_bulan')) document.getElementById('ns_bulan').value = parts[4] || surat.bulan || '';
                    if (document.getElementById('ns_tahun')) document.getElementById('ns_tahun').value = parts[5] || surat.tahun || '';
                } else if (parts.length >= 7) {
                    if (document.getElementById('ns_no')) document.getElementById('ns_no').value = parts[0] || surat.no_urut || '';
                    if (document.getElementById('ns_kode')) document.getElementById('ns_kode').value = parts[1] || 'A';
                    if (document.getElementById('ns_jenis')) document.getElementById('ns_jenis').value = parts[2] || '';
                    
                    const kegDiv = parts[3] || '';
                    const dashParts = kegDiv.split('-');
                    const last = dashParts[dashParts.length - 1];
                    if (validDivisi.includes(last)) {
                        parsedDiv = last;
                        parsedKeg = dashParts.slice(0, dashParts.length - 1).join('-');
                    } else {
                        parsedKeg = kegDiv;
                    }

                    if (parts[4] && document.getElementById('teks_koms')) {
                        document.getElementById('teks_koms').innerText = parts[4];
                    }
                    if (document.getElementById('ns_bulan')) document.getElementById('ns_bulan').value = parts[5] || surat.bulan || '';
                    if (document.getElementById('ns_tahun')) document.getElementById('ns_tahun').value = parts[6] || surat.tahun || '';
                }
            }

            if (!parsedKeg) {
                if (surat.jenis_surat === 'Surat Undangan') {
                    parsedKeg = (surat.nama_undangan || '').replace(/\s+/g, '-').toUpperCase();
                } else if (surat.jenis_surat === 'Surat Tugas') {
                    parsedKeg = (surat.kegiatan_st || '').replace(/\s+/g, '-').toUpperCase();
                    parsedDiv = mapDivisiAbbrev(surat.divisi_st);
                } else if (surat.jenis_surat === 'Surat Tugas Sosialisasi') {
                    parsedKeg = (surat.kegiatan_st || '').replace(/\s+/g, '-').toUpperCase();
                    parsedDiv = mapDivisiAbbrev(surat.divisi_st);
                } else if (surat.jenis_surat === 'Surat Izin Kegiatan') {
                    parsedKeg = (surat.nama_kegiatan_izin || '').replace(/\s+/g, '-').toUpperCase();
                }
            }

            if (document.getElementById('ns_nama_kegiatan')) document.getElementById('ns_nama_kegiatan').value = parsedKeg;
            if (document.getElementById('ns_divisi')) document.getElementById('ns_divisi').value = parsedDiv;

            // Isi Data Spesifik Berdasarkan Jenis Surat
            if (surat.jenis_surat === 'Surat Peringatan') {
                if (document.getElementById('anggota_sp')) document.getElementById('anggota_sp').value = surat.anggota_sp || '';
                if (document.getElementById('divisi_sp')) document.getElementById('divisi_sp').value = surat.divisi_sp || '';
                const namaSpInput = document.getElementById('nama_sp');
                if (namaSpInput) namaSpInput.value = surat.nama_sp || 'Pertama (SP 1)';
                if (document.getElementById('ns_nama_kegiatan')) document.getElementById('ns_nama_kegiatan').value = '';
                toggleUploadBerkasSP();

                // Cocokkan pilihan dropdown jika ada
                const selPoin = document.getElementById('pilih_poin');
                if (selPoin && surat.anggota_sp) {
                    for (let i = 0; i < selPoin.options.length; i++) {
                        if (selPoin.options[i].dataset.nama === surat.anggota_sp) {
                            selPoin.selectedIndex = i;
                            break;
                        }
                    }
                }
            } else if (surat.jenis_surat === 'Surat Undangan') {
                if (document.getElementById('nama_undangan')) document.getElementById('nama_undangan').value = surat.nama_undangan || '';
                
                const dateEl = document.getElementById('tanggal_kegiatan');
                if (dateEl) {
                    const isoDate = formatToDateInput(surat.tanggal_kegiatan);
                    if (isoDate) {
                        dateEl.type = 'date';
                        dateEl.value = isoDate;
                    } else {
                        dateEl.type = 'text';
                        dateEl.value = surat.tanggal_kegiatan || '';
                    }
                }

                if (document.getElementById('waktu_kegiatan')) {
                    document.getElementById('waktu_kegiatan').value = formatToTimeInput(surat.waktu_kegiatan);
                }
                if (document.getElementById('tempat_kegiatan')) {
                    document.getElementById('tempat_kegiatan').value = surat.tempat_kegiatan || '';
                }

                // Cocokkan dropdown kegiatan jika ada
                const selKeg = document.getElementById('pilih_kegiatan');
                if (selKeg && surat.nama_undangan) {
                    for (let i = 0; i < selKeg.options.length; i++) {
                        if (selKeg.options[i].dataset.nama === surat.nama_undangan) {
                            selKeg.selectedIndex = i;
                            break;
                        }
                    }
                }
            } else if (surat.jenis_surat === 'Surat Tugas') {
                if (document.getElementById('kegiatan_st')) document.getElementById('kegiatan_st').value = surat.kegiatan_st || '';
                if (document.getElementById('tema_st')) document.getElementById('tema_st').value = surat.tema_st || '';
                
                const dateElSt = document.getElementById('tanggal_kegiatan_st');
                if (dateElSt) {
                    const isoDate = formatToDateInput(surat.tanggal_kegiatan_st);
                    if (isoDate) {
                        dateElSt.type = 'date';
                        dateElSt.value = isoDate;
                    } else {
                        dateElSt.type = 'text';
                        dateElSt.value = surat.tanggal_kegiatan_st || '';
                    }
                }

                if (document.getElementById('waktu_kegiatan_st')) {
                    document.getElementById('waktu_kegiatan_st').value = formatToTimeInput(surat.waktu_kegiatan_st);
                }
                if (document.getElementById('tempat_kegiatan_st')) {
                    document.getElementById('tempat_kegiatan_st').value = surat.tempat_kegiatan_st || '';
                }
                if (document.getElementById('anggota_st')) {
                    document.getElementById('anggota_st').value = surat.anggota_st || '';
                }
                if (document.getElementById('jabatan_st')) {
                    document.getElementById('jabatan_st').value = surat.jabatan_st || 'Ketua Panitia';
                    toggleStempelTugas();
                }
                if (document.getElementById('divisi_st')) {
                    document.getElementById('divisi_st').value = surat.divisi_st || '';
                }

                // Cocokkan dropdown kegiatan jika ada
                const selKegSt = document.getElementById('pilih_kegiatan_st');
                if (selKegSt && surat.kegiatan_st) {
                    for (let i = 0; i < selKegSt.options.length; i++) {
                        if (selKegSt.options[i].dataset.nama === surat.kegiatan_st) {
                            selKegSt.selectedIndex = i;
                            break;
                        }
                    }
                }

                // Cocokkan dropdown anggota jika ada
                const selAnggotaSt = document.getElementById('pilih_anggota_st');
                if (selAnggotaSt && surat.anggota_st) {
                    for (let i = 0; i < selAnggotaSt.options.length; i++) {
                        if (selAnggotaSt.options[i].dataset.nama === surat.anggota_st) {
                            selAnggotaSt.selectedIndex = i;
                            break;
                        }
                    }
                }
            } else if (surat.jenis_surat === 'Surat Tugas Sosialisasi') {
                if (document.getElementById('kegiatan_sos')) document.getElementById('kegiatan_sos').value = surat.kegiatan_st || '';
                if (document.getElementById('anggota_sos')) {
                    const selAnggota = document.getElementById('anggota_sos');
                    selAnggota.value = surat.anggota_st || '';
                    if (!selAnggota.value && surat.anggota_st) {
                        const opt = document.createElement('option');
                        opt.value = surat.anggota_st;
                        opt.innerText = surat.anggota_st;
                        opt.dataset.divisi = surat.divisi_st || '';
                        selAnggota.appendChild(opt);
                        selAnggota.value = surat.anggota_st;
                    }
                }
                if (document.getElementById('divisi_sos')) document.getElementById('divisi_sos').value = surat.divisi_st || '';
                if (document.getElementById('jabatan_sos')) document.getElementById('jabatan_sos').value = surat.jabatan_st || 'Ketua Kelompok';
            } else if (surat.jenis_surat === 'Surat Izin Kegiatan') {
                if (document.getElementById('kepada_izin')) document.getElementById('kepada_izin').value = surat.kepada_izin || '';
                if (document.getElementById('nama_kegiatan_izin')) document.getElementById('nama_kegiatan_izin').value = surat.nama_kegiatan_izin || '';
                if (document.getElementById('status_anggota_izin')) document.getElementById('status_anggota_izin').value = surat.status_anggota_izin || 'Mahasiswa';
                
                const dateElIzin = document.getElementById('tanggal_kegiatan_izin');
                if (dateElIzin) {
                    const isoDate = formatToDateInput(surat.tanggal_kegiatan_izin);
                    if (isoDate) {
                        dateElIzin.type = 'date';
                        dateElIzin.value = isoDate;
                    } else {
                        dateElIzin.type = 'text';
                        dateElIzin.value = surat.tanggal_kegiatan_izin || '';
                    }
                }

                if (document.getElementById('waktu_kegiatan_izin')) {
                    document.getElementById('waktu_kegiatan_izin').value = formatToTimeInput(surat.waktu_kegiatan_izin);
                }
                if (document.getElementById('tempat_kegiatan_izin')) {
                    document.getElementById('tempat_kegiatan_izin').value = surat.tempat_kegiatan_izin || '';
                }

                // Cocokkan dropdown kegiatan izin jika ada
                const selKegIzin = document.getElementById('pilih_kegiatan_izin');
                if (selKegIzin && surat.nama_kegiatan_izin) {
                    for (let i = 0; i < selKegIzin.options.length; i++) {
                        if (selKegIzin.options[i].dataset.nama === surat.nama_kegiatan_izin) {
                            selKegIzin.selectedIndex = i;
                            break;
                        }
                    }
                }
            }

            updateNomorSuratFormLayout();
            updateNomorSurat();
        }

        function fillPeringatanData() {
            const sel = document.getElementById('pilih_poin');
            const opt = sel.options[sel.selectedIndex];
            
            const inputs = ['anggota_sp', 'divisi_sp'];
            const inputSP = document.getElementById('nama_sp');
            
            if (!opt.value) {
                inputs.forEach(id => {
                    const el = document.getElementById(id);
                    el.value = '';
                    el.readOnly = false;
                    el.classList.remove('bg-gray-100', 'text-gray-500');
                    el.classList.add('bg-white', 'text-gray-700');
                });
                inputSP.value = 'Pertama (SP 1)';
                document.getElementById('ns_nama_kegiatan').value = '';
                toggleUploadBerkasSP();
                return;
            }

            document.getElementById('anggota_sp').value = opt.dataset.nama;
            document.getElementById('divisi_sp').value  = opt.dataset.divisi;
            
            const spVal = (opt.dataset.sp || '').toUpperCase().trim();
            const isSP2 = spVal.includes('2');
            inputSP.value = isSP2 ? 'Kedua (SP 2)' : 'Pertama (SP 1)';

            inputs.forEach(id => {
                const el = document.getElementById(id);
                el.readOnly = true;
                el.classList.remove('bg-white', 'text-gray-700');
                el.classList.add('bg-gray-100', 'text-gray-500');
            });
            
            document.getElementById('ns_nama_kegiatan').value = '';

            toggleUploadBerkasSP();
        }

        function fillUndanganData() {
            const sel = document.getElementById('pilih_kegiatan');
            const opt = sel.options[sel.selectedIndex];
            
            const inputs = ['nama_undangan', 'tanggal_kegiatan', 'waktu_kegiatan', 'tempat_kegiatan'];
            
            if (!opt.value) {
                inputs.forEach(id => {
                    const el = document.getElementById(id);
                    el.value = '';
                    el.readOnly = false;
                    el.classList.remove('bg-gray-100', 'text-gray-500');
                    el.classList.add('bg-white', 'text-gray-700');
                });
                document.getElementById('ns_nama_kegiatan').value = '';
                document.getElementById('ns_divisi').value = 'SEK';
                updateNomorSurat();
                return;
            }
            
            document.getElementById('nama_undangan').value     = opt.dataset.nama;
            document.getElementById('tanggal_kegiatan').value  = opt.dataset.tanggal;
            document.getElementById('waktu_kegiatan').value    = opt.dataset.waktu;
            document.getElementById('tempat_kegiatan').value   = opt.dataset.tempat;

            inputs.forEach(id => {
                const el = document.getElementById(id);
                el.readOnly = true;
                el.classList.remove('bg-white', 'text-gray-700');
                el.classList.add('bg-gray-100', 'text-gray-500');
            });

            document.getElementById('ns_nama_kegiatan').value = opt.dataset.nama.replace(/\s+/g, '-').toUpperCase();
            document.getElementById('ns_divisi').value = mapDivisiAbbrev(opt.dataset.devisi);
            updateNomorSurat();
        }

        function fillTugasAnggotaData() {
            const sel = document.getElementById('pilih_anggota_st');
            const opt = sel.options[sel.selectedIndex];
            
            const inputs = ['anggota_st', 'divisi_st'];
            
            if (!opt.value) {
                inputs.forEach(id => {
                    const el = document.getElementById(id);
                    el.value = '';
                    el.readOnly = false;
                    el.classList.remove('bg-gray-100', 'text-gray-500');
                    el.classList.add('bg-white', 'text-gray-700');
                });
                return;
            }
            
            document.getElementById('anggota_st').value = opt.dataset.nama;
            document.getElementById('divisi_st').value  = opt.dataset.divisi;

            inputs.forEach(id => {
                const el = document.getElementById(id);
                el.readOnly = true;
                el.classList.remove('bg-white', 'text-gray-700');
                el.classList.add('bg-gray-100', 'text-gray-500');
            });

            if (opt.dataset.divisi) {
                document.getElementById('ns_divisi').value = mapDivisiAbbrev(opt.dataset.divisi);
                updateNomorSurat();
            }
        }

        function toggleStempelTugas() {
            const jabatan = document.getElementById('jabatan_st').value;
            const container = document.getElementById('stempel_container');
            if (jabatan === 'Sekretaris Panitia') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
                document.getElementById('stempel_kepanitiaan').value = '';
            }
        }

        function fillTugasKegiatanData() {
            const sel = document.getElementById('pilih_kegiatan_st');
            const opt = sel.options[sel.selectedIndex];
            
            const inputs = ['kegiatan_st', 'tanggal_kegiatan_st', 'waktu_kegiatan_st', 'tempat_kegiatan_st'];
            
            if (!opt.value) {
                inputs.forEach(id => {
                    const el = document.getElementById(id);
                    el.value = '';
                    el.readOnly = false;
                    el.classList.remove('bg-gray-100', 'text-gray-500');
                    el.classList.add('bg-white', 'text-gray-700');
                });
                document.getElementById('ns_nama_kegiatan').value = '';
                updateNomorSurat();
                return;
            }
            
            document.getElementById('kegiatan_st').value         = opt.dataset.nama;
            document.getElementById('tanggal_kegiatan_st').value = opt.dataset.tanggal;
            document.getElementById('waktu_kegiatan_st').value   = opt.dataset.waktu;
            document.getElementById('tempat_kegiatan_st').value  = opt.dataset.tempat;

            inputs.forEach(id => {
                const el = document.getElementById(id);
                el.readOnly = true;
                el.classList.remove('bg-white', 'text-gray-700');
                el.classList.add('bg-gray-100', 'text-gray-500');
            });

            document.getElementById('ns_nama_kegiatan').value = opt.dataset.nama.replace(/\s+/g, '-').toUpperCase();
            if (opt.dataset.devisi) {
                document.getElementById('ns_divisi').value = mapDivisiAbbrev(opt.dataset.devisi);
            }
            updateNomorSurat();
        }

        function fillIzinKegiatanData() {
            const sel = document.getElementById('pilih_kegiatan_izin');
            const opt = sel.options[sel.selectedIndex];
            
            const inputs = ['nama_kegiatan_izin', 'tanggal_kegiatan_izin', 'waktu_kegiatan_izin', 'tempat_kegiatan_izin'];
            
            if (!opt.value) {
                inputs.forEach(id => {
                    const el = document.getElementById(id);
                    el.value = '';
                    el.readOnly = false;
                    el.classList.remove('bg-gray-100', 'text-gray-500');
                    el.classList.add('bg-white', 'text-gray-700');
                });
                document.getElementById('ns_nama_kegiatan').value = '';
                document.getElementById('ns_divisi').value = 'SEK';
                updateNomorSurat();
                return;
            }
            
            document.getElementById('nama_kegiatan_izin').value    = opt.dataset.nama;
            document.getElementById('tanggal_kegiatan_izin').value = opt.dataset.tanggal;
            document.getElementById('waktu_kegiatan_izin').value   = opt.dataset.waktu;
            document.getElementById('tempat_kegiatan_izin').value  = opt.dataset.tempat;
            
            document.getElementById('ns_nama_kegiatan').value = opt.dataset.nama.replace(/\s+/g, '-').toUpperCase();
            document.getElementById('ns_divisi').value = mapDivisiAbbrev(opt.dataset.devisi);

            updateNomorSurat();

            inputs.forEach(id => {
                const el = document.getElementById(id);
                el.readOnly = true;
                el.classList.remove('bg-white', 'text-gray-700');
                el.classList.add('bg-gray-100', 'text-gray-500');
            });
        }
        
        function syncKegiatanSosialisasi() {
            const el = document.getElementById('kegiatan_sos');
            if (el && el.value) {
                document.getElementById('ns_nama_kegiatan').value = el.value.replace(/\s+/g, '-').toUpperCase();
                updateNomorSurat();
            }
        }

        function syncAnggotaSosialisasi() {
            const sel = document.getElementById('anggota_sos');
            const opt = sel.options[sel.selectedIndex];
            const divisiInput = document.getElementById('divisi_sos');
            if (opt && opt.dataset.divisi) {
                divisiInput.value = opt.dataset.divisi;
            }
            updateNomorSurat();
        }

        function updateNomorSurat() {
            const jenisSurat = document.getElementById('jenis_surat') ? document.getElementById('jenis_surat').value : '';
            const no = (document.getElementById('ns_no').value || '').trim() || '___';
            const bulan = (document.getElementById('ns_bulan').value || '').trim() || '___';
            const tahun = (document.getElementById('ns_tahun').value || '').trim() || '___';

            let fullNomor = '';
            let hiddenNomor = '';

            if (jenisSurat === 'Surat Peringatan') {
                const levelSP = document.getElementById('nama_sp') ? document.getElementById('nama_sp').value : '';
                const isSP2 = levelSP.includes('2') || levelSP.includes('Kedua');
                const spKode = isSP2 ? 'SP-2' : 'SP-1';
                const spKoms = isSP2 ? 'GENBI-SULTRA' : 'GENBI-KOMS-USN';

                fullNomor = `${no} / ${spKode} / ${spKoms} / ${bulan} / ${tahun}`;
                hiddenNomor = `${no}/${spKode}/${spKoms}/${bulan}/${tahun}`;

                const jdHidden = document.getElementById('ns_jenis_divisi');
                if (jdHidden) {
                    jdHidden.value = spKode;
                }
            } else {
                const kode = (document.getElementById('ns_kode').value || '').trim() || 'A';
                let jenis = (document.getElementById('ns_jenis').value || '').trim() || '___';
                if (jenisSurat === 'Surat Tugas') jenis = 'TGS';
                else if (jenisSurat === 'Surat Tugas Sosialisasi') jenis = 'TS';
                else if (jenisSurat === 'Surat Izin Kegiatan') jenis = 'PERM';
                else if (jenisSurat === 'Surat Undangan') jenis = 'UND';

                const koms = (document.getElementById('teks_koms').innerText || '').trim() || 'GENBI-KOMS-USN';

                fullNomor = `${no} / ${kode} / ${jenis} / ${koms} / ${bulan} / ${tahun}`;
                hiddenNomor = `${no}/${kode}/${jenis}/${koms}/${bulan}/${tahun}`;
                
                const jdHidden = document.getElementById('ns_jenis_divisi');
                if (jdHidden) {
                    jdHidden.value = jenis;
                }
            }

            if (document.getElementById('preview_nomor')) {
                document.getElementById('preview_nomor').innerText = fullNomor;
            }
            if (document.getElementById('nomor_surat_full')) {
                document.getElementById('nomor_surat_full').value = hiddenNomor;
            }
        }

        function setDefaultDivisiKode() {
            updateNomorSuratFormLayout();
        }
        
        // Inisialisasi saat load
        document.addEventListener("DOMContentLoaded", function() {
            updateNomorSurat();
        });

        // Hapus Modal functions
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
    </script>
@endsection
