<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SuratInternal;
use App\Models\Kegiatan;
use App\Models\Poin;

class SuratController extends Controller
{
    public function internal()
    {
        if (!auth()->user()->canAccessSurat()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman tersebut.');
        }

        $suratInternals = SuratInternal::orderBy('created_at', 'desc')->get();
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();
        $poins = Poin::whereNotNull('sp')->whereIn('sp', ['SP 1', 'SP 2', 'SP1', 'SP2', 'sp1', 'sp2'])->get();
        foreach ($poins as $poin) {
            $user = \App\Models\User::where('name', $poin->nama_lengkap)->first();
            if ($user && $user->devisi) {
                $poin->devisi = $user->devisi;
            } elseif (!$poin->devisi) {
                $poin->devisi = 'Belum Ada Divisi';
            }
        }
        $semuaAnggota = \App\Models\User::orderBy('name', 'asc')->get();
        $devisis = \App\Models\Devisi::all();

        // Hitung nomor urut berikutnya berdasarkan nomor urut tertinggi
        $maxNo = 0;
        foreach ($suratInternals as $s) {
            $num = 0;
            if (!empty($s->no_urut) && is_numeric($s->no_urut)) {
                $num = (int)$s->no_urut;
            } elseif (preg_match('/^(\d+)/', $s->nomor_surat_full ?? '', $m)) {
                $num = (int)$m[1];
            }
            if ($num > $maxNo) {
                $maxNo = $num;
            }
        }
        $nextNo = str_pad($maxNo + 1, 3, '0', STR_PAD_LEFT);

        return view('surat.internal.index', compact('suratInternals', 'kegiatans', 'poins', 'semuaAnggota', 'devisis', 'nextNo'));
    }

    public function storeInternal(Request $request)
    {
        $request->validate([
            'berkas_sp' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'ttd_kepanitiaan' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'stempel_kepanitiaan' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except(['_token']);
        
        $surat = new SuratInternal();
        $surat->jenis_surat = $request->jenis_surat;
        $surat->nomor_surat_full = $request->nomor_surat_full;
        
        // Simpan field struktur nomor surat agar tidak error
        $surat->no_urut = $request->ns_no;
        $surat->kode_surat = $request->ns_kode;
        $surat->kode_divisi = $request->ns_jenis_divisi;
        $surat->bulan = $request->ns_bulan;
        $surat->tahun = $request->ns_tahun;
        
        if ($request->jenis_surat == 'Surat Peringatan') {
            $surat->nama_sp = $request->nama_sp;
            $surat->anggota_sp = $request->anggota_sp;
            $surat->divisi_sp = $request->divisi_sp;

            if ($request->nama_sp == 'Kedua (SP 2)') {
                if ($request->hasFile('berkas_sp')) {
                    $file = $request->file('berkas_sp');
                    $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
                    $filename = time() . '_' . $cleanName;
                    $file->move(public_path('uploads/berkas_sp'), $filename);
                    $surat->berkas_sp = 'uploads/berkas_sp/' . $filename;
                }
                $surat->file_template = null;
            } else {
                $surat->berkas_sp = null;
                $surat->file_template = 'surat.internal.peringatan';
            }
        } elseif ($request->jenis_surat == 'Surat Undangan') {
            $surat->nama_undangan = $request->nama_undangan;
            
            try { $surat->tanggal_kegiatan = \Carbon\Carbon::parse($request->tanggal_kegiatan)->locale('id')->isoFormat('dddd, D MMMM YYYY'); } 
            catch (\Exception $e) { $surat->tanggal_kegiatan = $request->tanggal_kegiatan; }
            
            try { $surat->waktu_kegiatan = \Carbon\Carbon::parse($request->waktu_kegiatan)->format('H.i'); } 
            catch (\Exception $e) { $surat->waktu_kegiatan = $request->waktu_kegiatan; }
            
            $surat->tempat_kegiatan = $request->tempat_kegiatan;
            $surat->file_template = 'surat.internal.undangan';
        } elseif ($request->jenis_surat == 'Surat Tugas') {
            $surat->nama_ketua_st = $request->nama_ketua_st;
            $surat->anggota_st = $request->anggota_st;
            $surat->jabatan_st = $request->jabatan_st;
            $surat->divisi_st = $request->divisi_st;
            $surat->kegiatan_st = $request->kegiatan_st;
            $surat->tema_st = $request->tema_st;
            
            try { $surat->tanggal_kegiatan_st = \Carbon\Carbon::parse($request->tanggal_kegiatan_st)->locale('id')->isoFormat('dddd, D MMMM YYYY'); } 
            catch (\Exception $e) { $surat->tanggal_kegiatan_st = $request->tanggal_kegiatan_st; }
            
            try { $surat->waktu_kegiatan_st = \Carbon\Carbon::parse($request->waktu_kegiatan_st)->format('H.i'); } 
            catch (\Exception $e) { $surat->waktu_kegiatan_st = $request->waktu_kegiatan_st; }
            
            $surat->tempat_kegiatan_st = $request->tempat_kegiatan_st;
            if ($request->hasFile('ttd_kepanitiaan')) {
                $file = $request->file('ttd_kepanitiaan');
                $filename = time() . '_ttd.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/kepanitiaan'), $filename);
                $surat->ttd_kepanitiaan = 'uploads/kepanitiaan/' . $filename;
            }

            if ($request->hasFile('stempel_kepanitiaan')) {
                $file = $request->file('stempel_kepanitiaan');
                $filename = time() . '_stempel.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/kepanitiaan'), $filename);
                $surat->stempel_kepanitiaan = 'uploads/kepanitiaan/' . $filename;
            }

            $surat->file_template = 'surat.internal.tugas';
        } elseif ($request->jenis_surat == 'Surat Tugas Sosialisasi') {
            $surat->anggota_st = $request->anggota_sos ?? $request->anggota_st;
            $surat->jabatan_st = $request->jabatan_sos ?? $request->jabatan_st;
            $divisiVal = $request->divisi_sos ?? $request->divisi_st;
            if (empty($divisiVal)) {
                $u = \App\Models\User::where('name', $surat->anggota_st)->first();
                if ($u && !empty($u->devisi)) {
                    $divisiVal = $u->devisi;
                }
            }
            $surat->divisi_st = $divisiVal;
            $surat->kegiatan_st = $request->kegiatan_sos ?? $request->kegiatan_st;
            $surat->tema_st = $request->tema_sos ?? 'CBPR QRIS PeKA';
            $surat->file_template = 'surat.internal.tugas_sosialisasi';
        } elseif ($request->jenis_surat == 'Surat Izin Kegiatan') {
            $surat->nama_undangan_izin = $request->nama_undangan_izin;
            $surat->kepada_izin = $request->kepada_izin;
            $surat->nama_kegiatan_izin = $request->nama_kegiatan_izin;
            $surat->status_anggota_izin = $request->status_anggota_izin;
            
            try { $surat->tanggal_kegiatan_izin = \Carbon\Carbon::parse($request->tanggal_kegiatan_izin)->locale('id')->isoFormat('dddd, D MMMM YYYY'); } 
            catch (\Exception $e) { $surat->tanggal_kegiatan_izin = $request->tanggal_kegiatan_izin; }
            
            try { $surat->waktu_kegiatan_izin = \Carbon\Carbon::parse($request->waktu_kegiatan_izin)->format('H.i'); } 
            catch (\Exception $e) { $surat->waktu_kegiatan_izin = $request->waktu_kegiatan_izin; }
            
            $surat->tempat_kegiatan_izin = $request->tempat_kegiatan_izin;
            $surat->file_template = 'surat.internal.izin';
        }

        $surat->save();

        return redirect()->back()->with('success', 'Surat Internal berhasil ditambahkan.');
    }

    public function updateInternal(Request $request, $id)
    {
        $request->validate([
            'berkas_sp' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'ttd_kepanitiaan' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'stempel_kepanitiaan' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $surat = SuratInternal::findOrFail($id);
        $data = $request->except(['_token', '_method']);
        
        $surat->nomor_surat_full = $request->nomor_surat_full;
        $surat->jenis_surat = $request->jenis_surat;
        
        // Simpan field struktur nomor surat agar tidak error
        $surat->no_urut = $request->ns_no;
        $surat->kode_surat = $request->ns_kode;
        $surat->kode_divisi = $request->ns_jenis_divisi;
        $surat->bulan = $request->ns_bulan;
        $surat->tahun = $request->ns_tahun;
        
        if ($request->jenis_surat == 'Surat Peringatan') {
            $surat->nama_sp = $request->nama_sp;
            $surat->anggota_sp = $request->anggota_sp;
            $surat->divisi_sp = $request->divisi_sp;

            if ($request->nama_sp == 'Kedua (SP 2)') {
                if ($request->hasFile('berkas_sp')) {
                    // Hapus berkas lama jika ada
                    if ($surat->berkas_sp && file_exists(public_path($surat->berkas_sp))) {
                        unlink(public_path($surat->berkas_sp));
                    }
                    $file = $request->file('berkas_sp');
                    $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
                    $filename = time() . '_' . $cleanName;
                    $file->move(public_path('uploads/berkas_sp'), $filename);
                    $surat->berkas_sp = 'uploads/berkas_sp/' . $filename;
                }
                $surat->file_template = null;
            } else {
                // Bersihkan berkas jika diubah menjadi SP 1
                if ($surat->berkas_sp && file_exists(public_path($surat->berkas_sp))) {
                    unlink(public_path($surat->berkas_sp));
                }
                $surat->berkas_sp = null;
                $surat->file_template = 'surat.internal.peringatan';
            }
        } elseif ($request->jenis_surat == 'Surat Undangan') {
            $surat->nama_undangan = $request->nama_undangan;
            
            try { $surat->tanggal_kegiatan = \Carbon\Carbon::parse($request->tanggal_kegiatan)->locale('id')->isoFormat('dddd, D MMMM YYYY'); } 
            catch (\Exception $e) { $surat->tanggal_kegiatan = $request->tanggal_kegiatan; }
            
            try { $surat->waktu_kegiatan = \Carbon\Carbon::parse($request->waktu_kegiatan)->format('H.i'); } 
            catch (\Exception $e) { $surat->waktu_kegiatan = $request->waktu_kegiatan; }
            
            $surat->tempat_kegiatan = $request->tempat_kegiatan;
            $surat->file_template = 'surat.internal.undangan';
        } elseif ($request->jenis_surat == 'Surat Tugas') {
            $surat->nama_ketua_st = $request->nama_ketua_st;
            $surat->anggota_st = $request->anggota_st;
            $surat->jabatan_st = $request->jabatan_st;
            $surat->divisi_st = $request->divisi_st;
            $surat->kegiatan_st = $request->kegiatan_st;
            $surat->tema_st = $request->tema_st;
            
            try { $surat->tanggal_kegiatan_st = \Carbon\Carbon::parse($request->tanggal_kegiatan_st)->locale('id')->isoFormat('dddd, D MMMM YYYY'); } 
            catch (\Exception $e) { $surat->tanggal_kegiatan_st = $request->tanggal_kegiatan_st; }
            
            try { $surat->waktu_kegiatan_st = \Carbon\Carbon::parse($request->waktu_kegiatan_st)->format('H.i'); } 
            catch (\Exception $e) { $surat->waktu_kegiatan_st = $request->waktu_kegiatan_st; }
            
            $surat->tempat_kegiatan_st = $request->tempat_kegiatan_st;

            if ($request->hasFile('ttd_kepanitiaan')) {
                if ($surat->ttd_kepanitiaan && file_exists(public_path($surat->ttd_kepanitiaan))) {
                    unlink(public_path($surat->ttd_kepanitiaan));
                }
                $file = $request->file('ttd_kepanitiaan');
                $filename = time() . '_ttd.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/kepanitiaan'), $filename);
                $surat->ttd_kepanitiaan = 'uploads/kepanitiaan/' . $filename;
            }

            if ($request->hasFile('stempel_kepanitiaan')) {
                if ($surat->stempel_kepanitiaan && file_exists(public_path($surat->stempel_kepanitiaan))) {
                    unlink(public_path($surat->stempel_kepanitiaan));
                }
                $file = $request->file('stempel_kepanitiaan');
                $filename = time() . '_stempel.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/kepanitiaan'), $filename);
                $surat->stempel_kepanitiaan = 'uploads/kepanitiaan/' . $filename;
            }

            $surat->file_template = 'surat.internal.tugas';
        } elseif ($request->jenis_surat == 'Surat Tugas Sosialisasi') {
            $surat->anggota_st = $request->anggota_sos ?? $request->anggota_st;
            $surat->jabatan_st = $request->jabatan_sos ?? $request->jabatan_st;
            $divisiVal = $request->divisi_sos ?? $request->divisi_st;
            if (empty($divisiVal)) {
                $u = \App\Models\User::where('name', $surat->anggota_st)->first();
                if ($u && !empty($u->devisi)) {
                    $divisiVal = $u->devisi;
                }
            }
            $surat->divisi_st = $divisiVal;
            $surat->kegiatan_st = $request->kegiatan_sos ?? $request->kegiatan_st;
            $surat->tema_st = $request->tema_sos ?? 'CBPR QRIS PeKA';
            $surat->file_template = 'surat.internal.tugas_sosialisasi';
        } elseif ($request->jenis_surat == 'Surat Izin Kegiatan') {
            $surat->nama_undangan_izin = $request->nama_undangan_izin;
            $surat->kepada_izin = $request->kepada_izin;
            $surat->nama_kegiatan_izin = $request->nama_kegiatan_izin;
            $surat->status_anggota_izin = $request->status_anggota_izin;
            
            try { $surat->tanggal_kegiatan_izin = \Carbon\Carbon::parse($request->tanggal_kegiatan_izin)->locale('id')->isoFormat('dddd, D MMMM YYYY'); } 
            catch (\Exception $e) { $surat->tanggal_kegiatan_izin = $request->tanggal_kegiatan_izin; }
            
            try { $surat->waktu_kegiatan_izin = \Carbon\Carbon::parse($request->waktu_kegiatan_izin)->format('H.i'); } 
            catch (\Exception $e) { $surat->waktu_kegiatan_izin = $request->waktu_kegiatan_izin; }
            
            $surat->tempat_kegiatan_izin = $request->tempat_kegiatan_izin;
            $surat->file_template = 'surat.internal.izin';
        }

        $surat->save();

        return redirect()->back()->with('success', 'Surat Internal berhasil diperbarui.');
    }

    public function destroyInternal($id)
    {
        $surat = SuratInternal::findOrFail($id);
        
        if ($surat->berkas && file_exists(public_path($surat->berkas))) {
            unlink(public_path($surat->berkas));
        }
        if ($surat->ttd_kepanitiaan && file_exists(public_path($surat->ttd_kepanitiaan))) {
            unlink(public_path($surat->ttd_kepanitiaan));
        }
        if ($surat->stempel_kepanitiaan && file_exists(public_path($surat->stempel_kepanitiaan))) {
            unlink(public_path($surat->stempel_kepanitiaan));
        }

        $surat->delete();

        return redirect()->back()->with('success', 'Surat Internal berhasil dihapus.');
    }

    public function eksternal()
    {
        if (!auth()->user()->canAccessSurat()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman tersebut.');
        }

        $suratEksternals = \App\Models\SuratEksternal::orderBy('created_at', 'desc')->get();
        $poins = \App\Models\Poin::where('sp', 'SP 3')->get(); 
        $kegiatans = \App\Models\Kegiatan::orderBy('tanggal', 'desc')->get();
        $semuaAnggota = \App\Models\User::orderBy('name', 'asc')->get();
        
        $suratSP2 = \App\Models\SuratInternal::where('jenis_surat', 'Surat Peringatan')
                        ->where('nama_sp', 'Kedua (SP 2)')
                        ->get();
        
        $suratTugas = \App\Models\SuratInternal::where('jenis_surat', 'Surat Tugas')->get();

        // Hitung nomor urut berikutnya berdasarkan nomor urut tertinggi
        $maxNo = 0;
        foreach ($suratEksternals as $s) {
            $num = 0;
            if (!empty($s->no_urut) && is_numeric($s->no_urut)) {
                $num = (int)$s->no_urut;
            } elseif (preg_match('/^(\d+)/', $s->nomor_surat_full ?? '', $m)) {
                $num = (int)$m[1];
            }
            if ($num > $maxNo) {
                $maxNo = $num;
            }
        }
        $nextNo = str_pad($maxNo + 1, 3, '0', STR_PAD_LEFT);

        return view('surat.eksternal.index', compact('suratEksternals', 'poins', 'kegiatans', 'semuaAnggota', 'suratSP2', 'suratTugas', 'nextNo'));
    }

    public function storeEksternal(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required',
            'nomor_surat_full' => 'required',
        ]);

        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $currentMonthRoman = $romanMonths[date('n') - 1];

        $surat = new \App\Models\SuratEksternal();
        $surat->jenis_surat = $request->jenis_surat;
        $surat->no_urut = $request->ns_no;
        $surat->kode_surat = $request->jenis_surat == 'SP-3' ? 'SP-3' : ($request->ns_kode ?: '...');
        $surat->bulan = $request->ns_bulan ?: $currentMonthRoman;
        $surat->tahun = $request->ns_tahun ?: date('Y');
        
        if ($request->jenis_surat == 'SP-3') {
            $surat->nomor_surat_full = "{$surat->no_urut}/B/SP-3/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
        } else {
            $surat->nomor_surat_full = $request->nomor_surat_full ?: "{$surat->no_urut}/B/{$surat->kode_surat}/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
        }
        
        $surat->nama_tempat = $request->nama_tempat;
        $surat->nama_anggota = $request->nama_anggota;
        $surat->nim_anggota = $request->nim_anggota;
        $surat->jurusan_anggota = $request->jurusan_anggota;
        $surat->periode_pengurus = $request->periode_pengurus;
        
        if ($request->hasFile('file_sp2')) {
            $file = $request->file('file_sp2');
            $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $cleanName;
            $file->move(public_path('uploads/sp2'), $filename);
            $surat->file_sp2 = 'uploads/sp2/' . $filename;
            $surat->alasan_sp2 = 'uploads/sp2/' . $filename;
        } else {
            $surat->alasan_sp2 = $request->alasan_sp2;
        }
        
        $surat->nama_kegiatan = $request->nama_kegiatan;
        $surat->tema_kegiatan = $request->tema_kegiatan;
        $surat->tujuan_kegiatan = $request->tujuan_kegiatan;
        $surat->hari_tanggal = $request->hari_tanggal;
        $surat->waktu = $request->waktu;
        $surat->tempat_kegiatan = $request->tempat_kegiatan;
        $surat->nama_alat = $request->nama_alat;
        $surat->nama_materi = $request->nama_materi;

        // Auto-fill fallback jika ada nama kegiatan tapi jadwal kosong
        if (!empty($surat->nama_kegiatan)) {
            $keg = \App\Models\Kegiatan::where('nama_kegiatan', trim($surat->nama_kegiatan))->first();
            if ($keg) {
                if (empty($surat->hari_tanggal) && !empty($keg->tanggal)) {
                    try {
                        $surat->hari_tanggal = \Carbon\Carbon::parse($keg->tanggal)->locale('id')->translatedFormat('l, d F Y');
                    } catch (\Exception $e) {
                        $surat->hari_tanggal = $keg->tanggal;
                    }
                }
                if (empty($surat->waktu) && !empty($keg->waktu)) {
                    try {
                        $surat->waktu = \Carbon\Carbon::parse($keg->waktu)->format('H.i');
                    } catch (\Exception $e) {
                        $surat->waktu = $keg->waktu;
                    }
                }
                if (empty($surat->tempat_kegiatan) && !empty($keg->tempat)) {
                    $surat->tempat_kegiatan = $keg->tempat;
                }
            }
        }
        
        $barangArray = [];
        if($request->has('barang_nama') && is_array($request->barang_nama)) {
            foreach($request->barang_nama as $index => $nama) {
                if(!empty($nama)) {
                    $barangArray[] = [
                        'nama' => $nama,
                        'jumlah' => $request->barang_jumlah[$index] ?? ''
                    ];
                }
            }
        }
        $surat->barang_jumlah = json_encode($barangArray);
        
        $surat->nama_ketua_panitia = $request->nama_ketua_panitia;
        $surat->nama_sekretaris_panitia = $request->nama_sekretaris_panitia;

        // Set the corresponding template name
        $map = [
            'SP-3' => 'surat.eksternal.sp3',
            'Permohonan' => 'surat.eksternal.permohonan',
            'Peminjaman' => 'surat.eksternal.peminjaman',
            'Undangan Eksternal' => 'surat.eksternal.undangan',
            'Undangan Narasumber' => 'surat.eksternal.undangan_narasumber',
            'Kerjasama' => 'surat.eksternal.kerjasama',
            'Amplop' => 'surat.eksternal.amplop',
            'Daftar Hadir' => 'surat.eksternal.daftar_hadir',
        ];
        $surat->file_template = $map[$request->jenis_surat] ?? null;

        $surat->save();

        return redirect()->back()
            ->with('success', 'Surat Eksternal berhasil dibuat dan di-generate.')
            ->with('download_id', $surat->id);
    }

    public function downloadEksternal($id)
    {
        $surat = \App\Models\SuratEksternal::findOrFail($id);
        
        list($logoL, $logoR) = $this->getLogos();
        $logoBI = $this->imageToBase64(public_path('logo_bi.png'));

        $safeName = str_replace(['/', ' ', ':', '\\'], '_', $surat->nomor_surat_full ?? $surat->jenis_surat);
        $filename = 'Surat_Eksternal_' . $safeName . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];
        
        extract($this->getSuratSignatures($surat));

        $sp2Image = null;
        $sp2Path = $surat->file_sp2 ?? $surat->alasan_sp2;

        // Fallback jika belum ada file_sp2 tersimpan di surat_eksternal, cari berkas_sp dari SuratInternal anggota bersangkutan
        if ((!$sp2Path || !file_exists(public_path($sp2Path))) && !empty($surat->nama_anggota)) {
            $internalSP2 = \App\Models\SuratInternal::where('jenis_surat', 'Surat Peringatan')
                ->where('nama_sp', 'Kedua (SP 2)')
                ->where('anggota_sp', $surat->nama_anggota)
                ->whereNotNull('berkas_sp')
                ->latest()
                ->first();
            if ($internalSP2 && file_exists(public_path($internalSP2->berkas_sp))) {
                $sp2Path = $internalSP2->berkas_sp;
            }
        }

        if ($sp2Path && file_exists(public_path($sp2Path))) {
            $ext = strtolower(pathinfo($sp2Path, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                $sp2Image = $this->imageToBase64(public_path($sp2Path));
            }
        }

        return response()->view($surat->file_template, compact(
            'surat', 'logoL', 'logoR', 'logoBI', 'admin', 'sekretaris', 
            'ttdKetua', 'stempelKetua', 'ttdSekretaris', 'namaKetuaPanitia', 'namaSekretarisPanitia', 'ttdKetuaPanitia', 'ttdSekretarisPanitia', 'stempelPanitia', 'stempel', 'sp2Image'
        ))->withHeaders($headers);
    }

    public function downloadAmplopEksternal($id)
    {
        $surat = \App\Models\SuratEksternal::findOrFail($id);
        
        $amplopSurat = clone $surat;
        if ($surat->jenis_surat == 'SP-3') {
            $amplopSurat->nama_kegiatan = 'Pemberhentian ' . ($surat->nama_anggota ?? 'Anggota');
            $amplopSurat->nama_tempat = 'Biro Akademik USN Kolaka';
        } elseif ($surat->jenis_surat == 'Permohonan') {
            $amplopSurat->nama_kegiatan = 'Permohonan Izin Mengadakan ' . ($surat->nama_kegiatan ?? '');
        } elseif ($surat->jenis_surat == 'Peminjaman') {
            $amplopSurat->nama_kegiatan = 'Peminjaman ' . ($surat->nama_alat ?? '');
        } elseif ($surat->jenis_surat == 'Undangan Eksternal') {
            $amplopSurat->nama_kegiatan = 'Undangan Menghadiri Kegiatan';
        } elseif ($surat->jenis_surat == 'Undangan Narasumber') {
            $amplopSurat->nama_kegiatan = 'Undangan Narasumber';
        } elseif ($surat->jenis_surat == 'Kerjasama') {
            if ($surat->nama_kegiatan) {
                $keg = trim($surat->nama_kegiatan);
                if (stripos($keg, 'Kerjasama') !== false) {
                    $amplopSurat->nama_kegiatan = 'Permohonan ' . $keg;
                } else {
                    $amplopSurat->nama_kegiatan = 'Permohonan Kerjasama ' . $keg;
                }
            } else {
                $amplopSurat->nama_kegiatan = 'Permohonan Kerjasama';
            }
        }
        $amplopSurat->jenis_surat = 'Amplop';

        return $this->generateAmplopWord($amplopSurat);
    }

    public function downloadCustomAmplopEksternal(Request $request)
    {
        $request->validate([
            'nomor_surat_full' => 'required',
            'nama_tempat' => 'required',
            'nama_kegiatan' => 'required',
        ]);

        $amplopSurat = new \App\Models\SuratEksternal();
        $amplopSurat->nomor_surat_full = $request->nomor_surat_full;
        $amplopSurat->nama_tempat = $request->nama_tempat;
        $amplopSurat->nama_kegiatan = $request->nama_kegiatan;
        $amplopSurat->jenis_surat = 'Amplop';

        return $this->generateAmplopWord($amplopSurat);
    }

    private function generateAmplopWord($surat)
    {
        list($logoL, $logoR) = $this->getLogos();

        $safeName = str_replace(['/', ' ', ':', '\\'], '_', $surat->nomor_surat_full ?? 'Amplop');
        $filename = 'Amplop_' . $safeName . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        return response()->view('surat.eksternal.amplop', compact('surat', 'logoL', 'logoR'))->withHeaders($headers);
    }

    public function downloadDaftarHadirEksternal($id)
    {
        $surat = \App\Models\SuratEksternal::findOrFail($id);
        return $this->generateDaftarHadirWord($surat);
    }

    public function downloadCustomDaftarHadirEksternal(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
        ]);

        $surat = $request->surat_id ? \App\Models\SuratEksternal::find($request->surat_id) : new \App\Models\SuratEksternal();
        if (!$surat) {
            $surat = new \App\Models\SuratEksternal();
        }

        $daftarHadirSurat = clone $surat;
        $daftarHadirSurat->nama_kegiatan = $request->nama_kegiatan;
        $daftarHadirSurat->waktu = $request->waktu;
        $daftarHadirSurat->hari_tanggal = $request->hari_tanggal;
        $daftarHadirSurat->tempat_kegiatan = $request->tempat_kegiatan;
        $daftarHadirSurat->nama_tempat = $request->nama_tempat;
        $daftarHadirSurat->jenis_surat = 'Daftar Hadir';

        $jumlahBaris = $request->jumlah_baris ? (int)$request->jumlah_baris : 100;

        return $this->generateDaftarHadirWord($daftarHadirSurat, $jumlahBaris);
    }

    private function generateDaftarHadirWord($surat, $jumlahBaris = 100)
    {
        list($logoL, $logoR) = $this->getLogos();
        $logoBI = $this->imageToBase64(public_path('logo_bi.png'));

        $safeName = str_replace(['/', ' ', ':', '\\'], '_', $surat->nama_kegiatan ?? 'Kegiatan');
        $filename = 'Daftar_Hadir_' . $safeName . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        return response()->view('surat.eksternal.daftar_hadir', compact('surat', 'logoL', 'logoR', 'logoBI', 'jumlahBaris'))->withHeaders($headers);
    }

    public function updateEksternal(Request $request, $id)
    {
        $request->validate([
            'jenis_surat' => 'required',
            'nomor_surat_full' => 'required',
        ]);

        $romanMonths = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $currentMonthRoman = $romanMonths[date('n') - 1];

        $surat = \App\Models\SuratEksternal::findOrFail($id);
        $surat->jenis_surat = $request->jenis_surat;
        $surat->no_urut = $request->ns_no ?: $surat->no_urut;
        $surat->kode_surat = $request->jenis_surat == 'SP-3' ? 'SP-3' : ($request->ns_kode ?: $surat->kode_surat);
        $surat->bulan = $request->ns_bulan ?: ($surat->bulan ?: $currentMonthRoman);
        $surat->tahun = $request->ns_tahun ?: ($surat->tahun ?: date('Y'));
        
        if ($request->jenis_surat == 'SP-3') {
            $surat->nomor_surat_full = "{$surat->no_urut}/B/SP-3/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
        } else {
            $surat->nomor_surat_full = $request->nomor_surat_full ?: "{$surat->no_urut}/B/{$surat->kode_surat}/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
        }
        
        $surat->nama_tempat = $request->nama_tempat;
        $surat->nama_anggota = $request->nama_anggota;
        $surat->nim_anggota = $request->nim_anggota;
        $surat->jurusan_anggota = $request->jurusan_anggota;
        $surat->periode_pengurus = $request->periode_pengurus;
        
        if ($request->hasFile('file_sp2')) {
            if ($surat->file_sp2 && file_exists(public_path($surat->file_sp2))) {
                @unlink(public_path($surat->file_sp2));
            } elseif ($surat->alasan_sp2 && file_exists(public_path($surat->alasan_sp2))) {
                @unlink(public_path($surat->alasan_sp2));
            }
            $file = $request->file('file_sp2');
            $cleanName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            $filename = time() . '_' . $cleanName;
            $file->move(public_path('uploads/sp2'), $filename);
            $surat->file_sp2 = 'uploads/sp2/' . $filename;
            $surat->alasan_sp2 = 'uploads/sp2/' . $filename;
        } elseif ($request->filled('alasan_sp2')) {
            $surat->alasan_sp2 = $request->alasan_sp2;
        }
        
        $surat->nama_kegiatan = $request->nama_kegiatan;
        $surat->tema_kegiatan = $request->tema_kegiatan;
        $surat->tujuan_kegiatan = $request->tujuan_kegiatan;
        $surat->hari_tanggal = $request->hari_tanggal;
        $surat->waktu = $request->waktu;
        $surat->tempat_kegiatan = $request->tempat_kegiatan;
        $surat->nama_alat = $request->nama_alat;
        $surat->nama_materi = $request->nama_materi;

        // Auto-fill fallback jika ada nama kegiatan tapi jadwal kosong
        if (!empty($surat->nama_kegiatan)) {
            $keg = \App\Models\Kegiatan::where('nama_kegiatan', trim($surat->nama_kegiatan))->first();
            if ($keg) {
                if (empty($surat->hari_tanggal) && !empty($keg->tanggal)) {
                    try {
                        $surat->hari_tanggal = \Carbon\Carbon::parse($keg->tanggal)->locale('id')->translatedFormat('l, d F Y');
                    } catch (\Exception $e) {
                        $surat->hari_tanggal = $keg->tanggal;
                    }
                }
                if (empty($surat->waktu) && !empty($keg->waktu)) {
                    try {
                        $surat->waktu = \Carbon\Carbon::parse($keg->waktu)->format('H.i');
                    } catch (\Exception $e) {
                        $surat->waktu = $keg->waktu;
                    }
                }
                if (empty($surat->tempat_kegiatan) && !empty($keg->tempat)) {
                    $surat->tempat_kegiatan = $keg->tempat;
                }
            }
        }
        
        $barangArray = [];
        if($request->has('barang_nama') && is_array($request->barang_nama)) {
            foreach($request->barang_nama as $index => $nama) {
                if(!empty($nama)) {
                    $barangArray[] = [
                        'nama' => $nama,
                        'jumlah' => $request->barang_jumlah[$index] ?? ''
                    ];
                }
            }
        }
        $surat->barang_jumlah = json_encode($barangArray);
        
        $surat->nama_ketua_panitia = $request->nama_ketua_panitia;
        $surat->nama_sekretaris_panitia = $request->nama_sekretaris_panitia;

        $map = [
            'SP-3' => 'surat.eksternal.sp3',
            'Permohonan' => 'surat.eksternal.permohonan',
            'Peminjaman' => 'surat.eksternal.peminjaman',
            'Undangan Eksternal' => 'surat.eksternal.undangan',
            'Undangan Narasumber' => 'surat.eksternal.undangan_narasumber',
            'Kerjasama' => 'surat.eksternal.kerjasama',
            'Amplop' => 'surat.eksternal.amplop',
            'Daftar Hadir' => 'surat.eksternal.daftar_hadir',
        ];
        $surat->file_template = $map[$request->jenis_surat] ?? null;

        $surat->save();

        return redirect()->back()->with('success', 'Surat Eksternal berhasil diperbarui.');
    }

    public function destroyEksternal($id)
    {
        $surat = \App\Models\SuratEksternal::findOrFail($id);
        if ($surat->file_sp2 && file_exists(public_path($surat->file_sp2))) {
            @unlink(public_path($surat->file_sp2));
        } elseif ($surat->alasan_sp2 && file_exists(public_path($surat->alasan_sp2))) {
            @unlink(public_path($surat->alasan_sp2));
        }
        $surat->delete();
        return redirect()->back()->with('success', 'Surat Eksternal berhasil dihapus.');
    }

    public function sosialisasi()
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman sosialisasi.');
        }

        $suratSosialisasis = \App\Models\SuratSosialisasi::orderBy('created_at', 'desc')->get();
        $admin = \App\Models\User::where('role', 'admin')->first();
        $sekretaris = \App\Models\User::where('role', 'sekretaris')->first();

        // Hitung nomor urut berikutnya berdasarkan nomor urut tertinggi
        $maxNo = 0;
        foreach ($suratSosialisasis as $s) {
            $num = 0;
            if (!empty($s->no_urut) && is_numeric($s->no_urut)) {
                $num = (int)$s->no_urut;
            } elseif (preg_match('/^(\d+)/', $s->nomor_surat_full ?? '', $m)) {
                $num = (int)$m[1];
            }
            if ($num > $maxNo) {
                $maxNo = $num;
            }
        }
        $nextNo = str_pad($maxNo + 1, 3, '0', STR_PAD_LEFT);

        return view('surat.sosialisasi.index', compact('suratSosialisasis', 'admin', 'sekretaris', 'nextNo'));
    }

    public function storeSosialisasi(Request $request)
    {
        if (!auth()->user()->canManageSosialisasi()) {
            return redirect()->route('surat.sosialisasi')->with('error', 'Akses ditolak! Hanya Admin dan Sekretaris yang dapat menambah surat sosialisasi.');
        }

        $request->validate([
            'nomor_surat_full' => 'required',
            'nama_kebijakan'   => 'required',
            'nama_tempat'      => 'required',
            'hari'             => 'required',
            'tanggal'          => 'required',
            'waktu'            => 'required',
            'tempat_kegiatan'  => 'required',
        ]);

        $surat = new \App\Models\SuratSosialisasi();
        $surat->jenis_surat = 'Permohonan Sosialisasi';
        $surat->nomor_surat_full = $request->nomor_surat_full;
        $surat->no_urut = $request->ns_no;
        $surat->kode_surat = $request->ns_kode ?? 'PERM';
        $surat->bulan = $request->ns_bulan;
        $surat->tahun = $request->ns_tahun;
        $surat->nama_kebijakan = $request->nama_kebijakan;
        $surat->nama_tempat = $request->nama_tempat;
        $surat->hari = $request->hari;
        $surat->tanggal = $request->tanggal;

        if ($request->filled('tanggal')) {
            $tanggalIndo = \Carbon\Carbon::parse($request->tanggal)->locale('id')->isoFormat('D MMMM YYYY');
            $surat->hari_tanggal = ($request->hari ? $request->hari . ', ' : '') . $tanggalIndo;
        } else {
            $surat->hari_tanggal = $request->hari;
        }

        $surat->waktu = $request->waktu;
        $surat->tempat_kegiatan = $request->tempat_kegiatan;
        $surat->file_template = 'surat.sosialisasi.permohonan';
        $surat->save();

        return redirect()->back()->with('success', 'Surat Permohonan Sosialisasi berhasil dibuat.');
    }

    public function updateSosialisasi(Request $request, $id)
    {
        if (!auth()->user()->canManageSosialisasi()) {
            return redirect()->route('surat.sosialisasi')->with('error', 'Akses ditolak! Hanya Admin dan Sekretaris yang dapat mengubah surat sosialisasi.');
        }

        $request->validate([
            'nomor_surat_full' => 'required',
            'nama_kebijakan'   => 'required',
            'nama_tempat'      => 'required',
            'hari'             => 'required',
            'tanggal'          => 'required',
            'waktu'            => 'required',
            'tempat_kegiatan'  => 'required',
        ]);

        $surat = \App\Models\SuratSosialisasi::findOrFail($id);
        $surat->nomor_surat_full = $request->nomor_surat_full;
        if ($request->filled('ns_no')) $surat->no_urut = $request->ns_no;
        if ($request->filled('ns_kode')) $surat->kode_surat = $request->ns_kode;
        if ($request->filled('ns_bulan')) $surat->bulan = $request->ns_bulan;
        if ($request->filled('ns_tahun')) $surat->tahun = $request->ns_tahun;
        $surat->nama_kebijakan = $request->nama_kebijakan;
        $surat->nama_tempat = $request->nama_tempat;
        $surat->hari = $request->hari;
        $surat->tanggal = $request->tanggal;

        if ($request->filled('tanggal')) {
            $tanggalIndo = \Carbon\Carbon::parse($request->tanggal)->locale('id')->isoFormat('D MMMM YYYY');
            $surat->hari_tanggal = ($request->hari ? $request->hari . ', ' : '') . $tanggalIndo;
        } else {
            $surat->hari_tanggal = $request->hari;
        }

        $surat->waktu = $request->waktu;
        $surat->tempat_kegiatan = $request->tempat_kegiatan;
        $surat->save();

        return redirect()->back()->with('success', 'Surat Permohonan Sosialisasi berhasil diperbarui.');
    }

    public function destroySosialisasi($id)
    {
        if (!auth()->user()->canManageSosialisasi()) {
            return redirect()->route('surat.sosialisasi')->with('error', 'Akses ditolak! Hanya Admin dan Sekretaris yang dapat menghapus surat sosialisasi.');
        }

        $surat = \App\Models\SuratSosialisasi::findOrFail($id);
        $surat->delete();
        return redirect()->back()->with('success', 'Surat Permohonan Sosialisasi berhasil dihapus.');
    }

    public function downloadSosialisasi($id)
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengunduh dokumen ini.');
        }

        $surat = \App\Models\SuratSosialisasi::findOrFail($id);
        list($logoL, $logoR) = $this->getLogos();
        extract($this->getSuratSignatures($surat));

        $safeName = str_replace(['/', ' ', ':', '\\'], '_', $surat->nomor_surat_full ?? 'Sosialisasi');
        $filename = 'Surat_Permohonan_Sosialisasi_' . $safeName . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        return response()->view('surat.sosialisasi.permohonan', compact(
            'surat', 'logoL', 'logoR', 'admin', 'sekretaris', 'ttdKetua', 'stempelKetua', 'ttdSekretaris'
        ))->withHeaders($headers);
    }

    public function downloadTemplateSosialisasi()
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        list($logoL, $logoR) = $this->getLogos();

        $surat = new \App\Models\SuratSosialisasi([
            'nomor_surat_full' => '[Nomor Surat]',
            'nama_kebijakan'   => '[Nama Kebijakan]',
            'nama_tempat'      => '[Nama Tempat]',
            'hari_tanggal'     => '[Hari, Tanggal]',
            'waktu'            => '[Waktu]',
            'tempat_kegiatan'  => '[Tempat]',
        ]);

        extract($this->getSuratSignatures($surat));

        $filename = 'Template_Permohonan_Sosialisasi.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        return response()->view('surat.sosialisasi.permohonan', compact(
            'surat', 'logoL', 'logoR', 'admin', 'sekretaris', 'ttdKetua', 'stempelKetua', 'ttdSekretaris'
        ))->withHeaders($headers);
    }

    public function downloadAmplopSosialisasi($id)
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $surat = \App\Models\SuratSosialisasi::findOrFail($id);

        $amplopSurat = new \App\Models\SuratEksternal();
        $amplopSurat->nomor_surat_full = $surat->nomor_surat_full;
        $amplopSurat->nama_tempat = $surat->nama_tempat;
        $amplopSurat->nama_kegiatan = 'Permohonan Izin Mengadakan Sosialisasi ' . $surat->nama_kebijakan;
        $amplopSurat->jenis_surat = 'Amplop';

        return $this->generateAmplopWord($amplopSurat);
    }

    public function downloadCustomDaftarHadirSosialisasi(Request $request)
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'nama_kegiatan' => 'required',
        ]);

        $daftarHadirSurat = new \App\Models\SuratEksternal();
        $daftarHadirSurat->nama_kegiatan = $request->nama_kegiatan;
        $daftarHadirSurat->waktu = $request->waktu;
        $daftarHadirSurat->hari_tanggal = $request->hari_tanggal;
        $daftarHadirSurat->tempat_kegiatan = $request->tempat_kegiatan ?? $request->nama_tempat;
        $daftarHadirSurat->nama_tempat = $request->nama_tempat;
        $daftarHadirSurat->jenis_surat = 'Daftar Hadir';

        $jumlahBaris = $request->jumlah_baris ? (int)$request->jumlah_baris : 100;

        return $this->generateDaftarHadirWord($daftarHadirSurat, $jumlahBaris);
    }

    public function sertifikatSosialisasi($id)
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $surat = \App\Models\SuratSosialisasi::findOrFail($id);
        $admin = \App\Models\User::where('role', 'admin')->first();
        $sekretaris = \App\Models\User::where('role', 'sekretaris')->first();

        $nomor = $surat->nomor_surat_full ?? '-';
        $rawTempat = !empty($surat->nama_tempat) ? $surat->nama_tempat : ($surat->tempat_kegiatan ?? 'Tempat');
        $cleanTempat = trim($rawTempat);
        while (preg_match('/^(Kepala\s+Sekolah|Kepala|Sekolah|Rektor|Pimpinan|Ketua|Direktur)\s+/i', $cleanTempat, $matches)) {
            $cleanTempat = trim(substr($cleanTempat, strlen($matches[0])));
        }
        $tempat = !empty($cleanTempat) ? $cleanTempat : $rawTempat;

        $hari_tanggal = $surat->hari_tanggal ?? '-';
        $nama_ketua = $admin->name ?? 'Agung Pramadana';
        $nama_sekretaris = $sekretaris->name ?? 'Elsa Savira Putri';
        $nama_kebijakan = $surat->nama_kebijakan ?? 'CBPR QRIS PeKA';

        $bgPath = public_path('assets/sertifikat_bg.png');
        $bgBase64 = $this->imageToBase64($bgPath);

        $ttdKetua = ($admin && $admin->ttd) ? $this->imageToBase64(storage_path('app/public/' . $admin->ttd)) : null;
        $ttdSekretaris = ($sekretaris && $sekretaris->ttd) ? $this->imageToBase64(storage_path('app/public/' . $sekretaris->ttd)) : null;

        $stempelKetua = null;
        if ($admin && $admin->stempel) {
            if (file_exists(storage_path('app/public/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(storage_path('app/public/' . $admin->stempel));
            } elseif (file_exists(public_path('storage/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path('storage/' . $admin->stempel));
            } elseif (file_exists(public_path($admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path($admin->stempel));
            }
        }

        return view('surat.sosialisasi.sertifikat', compact(
            'surat', 'nomor', 'tempat', 'hari_tanggal', 'nama_ketua', 'nama_sekretaris', 'bgBase64', 'ttdKetua', 'ttdSekretaris', 'nama_kebijakan', 'stempelKetua'
        ));
    }

    public function customSertifikatSosialisasi(Request $request)
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $admin = \App\Models\User::where('role', 'admin')->first();
        $sekretaris = \App\Models\User::where('role', 'sekretaris')->first();

        $nomor = $request->nomor ?? '[Nomor Surat]';
        $surat = $request->surat_id ? \App\Models\SuratSosialisasi::find($request->surat_id) : null;

        $rawTempat = $request->tempat ?? ($surat->nama_tempat ?? ($surat->tempat_kegiatan ?? '[Nama Tempat]'));
        $cleanTempat = trim($rawTempat);
        while (preg_match('/^(Kepala\s+Sekolah|Kepala|Sekolah|Rektor|Pimpinan|Ketua|Direktur)\s+/i', $cleanTempat, $matches)) {
            $cleanTempat = trim(substr($cleanTempat, strlen($matches[0])));
        }
        $tempat = !empty($cleanTempat) ? $cleanTempat : $rawTempat;

        $hari_tanggal = $request->hari_tanggal ?? '[Hari, Tanggal]';
        $nama_ketua = $request->nama_ketua ?? ($admin->name ?? 'Agung Pramadana');
        $nama_sekretaris = $request->nama_sekretaris ?? ($sekretaris->name ?? 'Elsa Savira Putri');

        $nama_kebijakan = !empty($request->nama_kebijakan) ? $request->nama_kebijakan : ($surat->nama_kebijakan ?? 'CBPR QRIS PeKA');

        $bgPath = public_path('assets/sertifikat_bg.png');
        $bgBase64 = $this->imageToBase64($bgPath);

        $ttdKetua = ($admin && $admin->ttd) ? $this->imageToBase64(storage_path('app/public/' . $admin->ttd)) : null;
        $ttdSekretaris = ($sekretaris && $sekretaris->ttd) ? $this->imageToBase64(storage_path('app/public/' . $sekretaris->ttd)) : null;

        $stempelKetua = null;
        if ($admin && $admin->stempel) {
            if (file_exists(storage_path('app/public/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(storage_path('app/public/' . $admin->stempel));
            } elseif (file_exists(public_path('storage/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path('storage/' . $admin->stempel));
            } elseif (file_exists(public_path($admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path($admin->stempel));
            }
        }

        return view('surat.sosialisasi.sertifikat', compact(
            'surat', 'nomor', 'tempat', 'hari_tanggal', 'nama_ketua', 'nama_sekretaris', 'bgBase64', 'ttdKetua', 'ttdSekretaris', 'nama_kebijakan', 'stempelKetua'
        ));
    }

    public function downloadWordSertifikatSosialisasi(Request $request)
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $admin = \App\Models\User::where('role', 'admin')->first();
        $sekretaris = \App\Models\User::where('role', 'sekretaris')->first();

        $nomor = $request->nomor ?? '[Nomor]';
        $surat = $request->surat_id ? \App\Models\SuratSosialisasi::find($request->surat_id) : null;

        $rawTempat = $request->tempat ?? ($surat->nama_tempat ?? ($surat->tempat_kegiatan ?? '[Tempat]'));
        $cleanTempat = trim($rawTempat);
        while (preg_match('/^(Kepala\s+Sekolah|Kepala|Sekolah|Rektor|Pimpinan|Ketua|Direktur)\s+/i', $cleanTempat, $matches)) {
            $cleanTempat = trim(substr($cleanTempat, strlen($matches[0])));
        }
        $tempat = !empty($cleanTempat) ? $cleanTempat : $rawTempat;
        $hari_tanggal = $request->hari_tanggal ?? '[Hari, Tanggal]';
        $nama_ketua = $request->nama_ketua ?? ($admin->name ?? '[Nama Ketua]');
        $nama_sekretaris = $request->nama_sekretaris ?? ($sekretaris->name ?? '[Nama Sekretaris]');

        $nama_kebijakan = !empty($request->nama_kebijakan) ? $request->nama_kebijakan : ($surat->nama_kebijakan ?? 'CBPR QRIS PeKA');

        $safeName = str_replace(['/', ' ', ':', '\\'], '_', $tempat);
        $filename = 'Sertifikat_Sosialisasi_' . $safeName . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        $ttdKetua = ($admin && $admin->ttd) ? $this->imageToBase64(storage_path('app/public/' . $admin->ttd)) : null;
        $ttdSekretaris = ($sekretaris && $sekretaris->ttd) ? $this->imageToBase64(storage_path('app/public/' . $sekretaris->ttd)) : null;
        $stempelKetua = null;
        if ($admin && $admin->stempel) {
            if (file_exists(storage_path('app/public/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(storage_path('app/public/' . $admin->stempel));
            } elseif (file_exists(public_path('storage/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path('storage/' . $admin->stempel));
            } elseif (file_exists(public_path($admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path($admin->stempel));
            }
        }

        return response()->view('surat.sosialisasi.sertifikat_word', compact(
            'nomor', 'tempat', 'hari_tanggal', 'nama_ketua', 'nama_sekretaris', 'nama_kebijakan', 'ttdKetua', 'ttdSekretaris', 'stempelKetua'
        ))->withHeaders($headers);
    }

    public function downloadTemplateSertifikatSosialisasi()
    {
        if (!auth()->user()->hasAksesSosialisasi()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        $admin = \App\Models\User::where('role', 'admin')->first();
        $sekretaris = \App\Models\User::where('role', 'sekretaris')->first();

        $nomor = '[Nomor Surat]';
        $tempat = '[Nama Tempat / Sekolah / Instansi]';
        $hari_tanggal = '[Hari, Tanggal/Bulan/Tahun]';
        $nama_ketua = $admin->name ?? '[Nama Ketua]';
        $nama_sekretaris = $sekretaris->name ?? '[Nama Sekretaris]';
        $nama_kebijakan = 'CBPR QRIS PeKA';

        $ttdKetua = ($admin && $admin->ttd) ? $this->imageToBase64(storage_path('app/public/' . $admin->ttd)) : null;
        $ttdSekretaris = ($sekretaris && $sekretaris->ttd) ? $this->imageToBase64(storage_path('app/public/' . $sekretaris->ttd)) : null;
        $stempelKetua = null;
        if ($admin && $admin->stempel) {
            if (file_exists(storage_path('app/public/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(storage_path('app/public/' . $admin->stempel));
            } elseif (file_exists(public_path('storage/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path('storage/' . $admin->stempel));
            } elseif (file_exists(public_path($admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path($admin->stempel));
            }
        }

        $filename = 'Template_Sertifikat_Penghargaan_Sosialisasi.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];

        return response()->view('surat.sosialisasi.sertifikat_word', compact(
            'nomor', 'tempat', 'hari_tanggal', 'nama_ketua', 'nama_sekretaris', 'nama_kebijakan', 'ttdKetua', 'ttdSekretaris', 'stempelKetua'
        ))->withHeaders($headers);
    }

    public function downloadTemplateEksternal($jenis)
    {
        $templateMap = [
            'sp3'                   => ['view' => 'surat.eksternal.sp3', 'label' => 'Template_Surat_SP3'],
            'permohonan'            => ['view' => 'surat.eksternal.permohonan', 'label' => 'Template_Surat_Permohonan'],
            'peminjaman'            => ['view' => 'surat.eksternal.peminjaman', 'label' => 'Template_Surat_Peminjaman'],
            'undangan'              => ['view' => 'surat.eksternal.undangan', 'label' => 'Template_Surat_Undangan_Eksternal'],
            'undangan_narasumber'   => ['view' => 'surat.eksternal.undangan_narasumber', 'label' => 'Template_Surat_Undangan_Narasumber'],
            'kerjasama'             => ['view' => 'surat.eksternal.kerjasama', 'label' => 'Template_Surat_Kerjasama'],
            'daftar_hadir'          => ['view' => 'surat.eksternal.daftar_hadir', 'label' => 'Template_Daftar_Hadir'],
            'amplop'                => ['view' => 'surat.eksternal.amplop', 'label' => 'Template_Amplop_Surat'],
        ];

        if (!isset($templateMap[$jenis])) {
            abort(404);
        }

        list($logoL, $logoR) = $this->getLogos();
        $logoBI = $this->imageToBase64(public_path('logo_bi.png')); // Just in case we added it

        // Buat objek dummy agar template tidak error
        $surat = new \App\Models\SuratEksternal([
            'nomor_surat_full'        => '___/B/__/GENBI-KOMS-USN/__/2026',
            'jenis_surat'             => ucfirst(str_replace('_', ' ', $jenis)),
            'nama_tempat'             => '[Nama Tujuan/Instansi/Narasumber]',
            'nama_anggota'            => '[Nama Anggota yang Diberhentikan]',
            'nim_anggota'             => '[NIM Anggota]',
            'jurusan_anggota'         => '[Jurusan Anggota]',
            'periode_pengurus'        => '[Tahun Periode]',
            'alasan_sp2'              => '[Keterangan SP-2]',
            'nama_kegiatan'           => '[Nama Kegiatan]',
            'tema_kegiatan'           => '[Tema Kegiatan]',
            'tujuan_kegiatan'         => '[Tujuan Kegiatan]',
            'hari_tanggal'            => '[Hari, DD Bulan YYYY]',
            'waktu'                   => '[HH.MM]',
            'tempat_kegiatan'         => '[Tempat Pelaksanaan]',
            'nama_alat'               => '[Nama Alat]',
            'barang_jumlah'           => '[{"nama": "Barang 1", "jumlah": "1"}, {"nama": "Barang 2", "jumlah": "2"}]',
            'nama_materi'             => '[Judul Materi]',
            'nama_ketua_panitia'      => '[Nama Ketua Panitia]',
            'nama_sekretaris_panitia' => '[Nama Sekretaris Panitia]',
            'created_at'              => now(),
        ]);

        $filename = $templateMap[$jenis]['label'] . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];
        
        extract($this->getSuratSignatures($surat));
        $sp2Image = null;

        return response()->view($templateMap[$jenis]['view'], compact(
            'surat', 'logoL', 'logoR', 'logoBI', 'admin', 'sekretaris', 
            'ttdKetua', 'stempelKetua', 'ttdSekretaris', 'namaKetuaPanitia', 'namaSekretarisPanitia', 'ttdKetuaPanitia', 'ttdSekretarisPanitia', 'stempelPanitia', 'stempel', 'sp2Image'
        ))->withHeaders($headers);
    }

    public function downloadTemplate($jenis)
    {
        $templateMap = [
            'peringatan' => ['view' => 'surat.internal.peringatan', 'label' => 'Template_Surat_Peringatan'],
            'undangan'   => ['view' => 'surat.internal.undangan',   'label' => 'Template_Surat_Undangan'],
            'tugas'             => ['view' => 'surat.internal.tugas',             'label' => 'Template_Surat_Tugas'],
            'tugas_sosialisasi' => ['view' => 'surat.internal.tugas_sosialisasi', 'label' => 'Template_Surat_Tugas_Sosialisasi'],
            'izin'              => ['view' => 'surat.internal.izin',              'label' => 'Template_Surat_Izin_Kegiatan'],
        ];

        if (!isset($templateMap[$jenis])) {
            abort(404);
        }

        list($logoL, $logoR) = $this->getLogos();

        // Buat objek dummy agar template tidak error
        $dummyNomor = 'NOMOR / A / JENIS / GENBI-KOMS-USN / BULAN / TAHUN';
        if ($jenis === 'undangan') {
            $dummyNomor = 'NOMOR / A / UND / GENBI-KOMS-USN / BULAN / TAHUN';
        } elseif ($jenis === 'tugas') {
            $dummyNomor = 'NOMOR / A / TGS / GENBI-KOMS-USN / BULAN / TAHUN';
        } elseif ($jenis === 'tugas_sosialisasi') {
            $dummyNomor = 'NOMOR / A / TS / GENBI-KOMS-USN / BULAN / TAHUN';
        } elseif ($jenis === 'izin') {
            $dummyNomor = 'NOMOR / A / PERM / GENBI-KOMS-USN / BULAN / TAHUN';
        } elseif ($jenis === 'peringatan') {
            $dummyNomor = 'NOMOR / SP-1 / GENBI-KOMS-USN / BULAN / TAHUN';
        }

        $surat = new \App\Models\SuratInternal([
            'nomor_surat_full'    => $dummyNomor,
            'jenis_surat'         => ucfirst($jenis),
            'nama_sp'             => '[Pertama / SP 1]',
            'anggota_sp'          => '[Nama Anggota]',
            'divisi_sp'           => '[Nama Divisi]',
            'nama_undangan'       => '[Nama Kegiatan / Undangan]',
            'tanggal_kegiatan'    => '[Hari, DD Bulan YYYY]',
            'waktu_kegiatan'      => '[HH.MM]',
            'tempat_kegiatan'     => '[Nama Tempat]',
            'nama_ketua_st'       => '[Nama Ketua Umum]',
            'anggota_st'          => '[Nama Anggota Ditugaskan]',
            'jabatan_st'          => '[Jabatan]',
            'divisi_st'           => '[Nama Divisi]',
            'kegiatan_st'         => '[Nama Kegiatan]',
            'tema_st'             => 'Nama Tema',
            'tanggal_kegiatan_st' => '[Hari, DD Bulan YYYY]',
            'waktu_kegiatan_st'   => '[HH.MM]',
            'tempat_kegiatan_st'  => '[Nama Tempat]',
            'nama_undangan_izin'  => '[Nama Undangan]',
            'kepada_izin'         => '[Nama/Jabatan yang Diundang]',
            'nama_kegiatan_izin'  => '[Nama Kegiatan]',
            'status_anggota_izin' => ($jenis === 'izin') ? '[Status]' : '[Status Anggota]',
            'tanggal_kegiatan_izin'=> '[Hari, DD Bulan YYYY]',
            'waktu_kegiatan_izin' => '[HH.MM]',
            'tempat_kegiatan_izin'=> '[Nama Tempat]',
            'created_at'          => now(),
        ]);

        $filename = $templateMap[$jenis]['label'] . '.doc';
        $headers  = [
            'Content-type'        => 'application/vnd.ms-word',
            'Content-Disposition' => "attachment;Filename=$filename",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ];
        
        $semuaAnggota = \App\Models\User::orderBy('name', 'asc')->get();
        extract($this->getSuratSignatures($surat));

        return response()->view($templateMap[$jenis]['view'], compact('surat', 'logoL', 'logoR', 'sekretaris', 'admin', 'semuaAnggota', 'ttdKetua', 'stempelKetua', 'ttdSekretaris', 'stempel', 'namaKetuaPanitia', 'namaSekretarisPanitia', 'ttdKetuaPanitia', 'ttdSekretarisPanitia', 'stempelPanitia'))
            ->withHeaders($headers);
    }

    public function downloadInternal($id)
    {
        $surat = SuratInternal::findOrFail($id);
        
        if ($surat->jenis_surat == 'Surat Peringatan' && $surat->nama_sp == 'Kedua (SP 2)' && $surat->berkas_sp) {
            $filePath = public_path($surat->berkas_sp);
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }
            return redirect()->back()->with('error', 'Berkas Surat Peringatan tidak ditemukan.');
        }

        list($logoL, $logoR) = $this->getLogos();
        $semuaAnggota = \App\Models\User::orderBy('name', 'asc')->get();
        extract($this->getSuratSignatures($surat));

        // Normalisasi format nomor surat internal saat diunduh
        if ($surat->jenis_surat == 'Surat Tugas') {
            if ($surat->no_urut && $surat->bulan && $surat->tahun) {
                $surat->nomor_surat_full = "{$surat->no_urut}/A/TGS/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
            }
        } elseif ($surat->jenis_surat == 'Surat Tugas Sosialisasi') {
            if ($surat->no_urut && $surat->bulan && $surat->tahun) {
                $surat->nomor_surat_full = "{$surat->no_urut}/A/TS/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
            }
            if (empty($surat->divisi_st) || $surat->divisi_st === '[Kode Divisi]') {
                $u = \App\Models\User::where('name', $surat->anggota_st)->first();
                if ($u && !empty($u->devisi)) {
                    $surat->divisi_st = $u->devisi;
                }
            }
        } elseif ($surat->jenis_surat == 'Surat Izin Kegiatan') {
            if ($surat->no_urut && $surat->bulan && $surat->tahun) {
                $surat->nomor_surat_full = "{$surat->no_urut}/A/PERM/GENBI-KOMS-USN/{$surat->bulan}/{$surat->tahun}";
            }
        }

        $filename = "Surat_Internal_" . str_replace('/', '_', $surat->nomor_surat_full) . ".doc";
        $headers = [
            "Content-type" => "application/vnd.ms-word", 
            "Content-Disposition" => "attachment;Filename=$filename",
            "Cache-Control" => "no-cache, no-store, must-revalidate",
            "Pragma" => "no-cache",
            "Expires" => "0"
        ];
        
        return response()->view($surat->file_template, compact('surat', 'logoL', 'logoR', 'sekretaris', 'admin', 'semuaAnggota', 'ttdKetua', 'stempelKetua', 'ttdSekretaris', 'stempel', 'namaKetuaPanitia', 'namaSekretarisPanitia', 'ttdKetuaPanitia', 'ttdSekretarisPanitia', 'stempelPanitia'))
            ->withHeaders($headers);
    }

    private function getSuratSignatures($surat = null)
    {
        $admin = \App\Models\User::where('role', 'admin')->first();
        $sekretaris = \App\Models\User::where('role', 'sekretaris')->first();

        $ttdKetua = null;
        if ($admin && $admin->ttd) {
            if (file_exists(storage_path('app/public/' . $admin->ttd))) {
                $ttdKetua = $this->imageToBase64(storage_path('app/public/' . $admin->ttd));
            } elseif (file_exists(public_path('storage/' . $admin->ttd))) {
                $ttdKetua = $this->imageToBase64(public_path('storage/' . $admin->ttd));
            } elseif (file_exists(public_path($admin->ttd))) {
                $ttdKetua = $this->imageToBase64(public_path($admin->ttd));
            }
        }

        $stempelKetua = null;
        if ($admin && $admin->stempel) {
            if (file_exists(storage_path('app/public/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(storage_path('app/public/' . $admin->stempel));
            } elseif (file_exists(public_path('storage/' . $admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path('storage/' . $admin->stempel));
            } elseif (file_exists(public_path($admin->stempel))) {
                $stempelKetua = $this->imageToBase64(public_path($admin->stempel));
            }
        }

        $ttdSekretaris = null;
        if ($sekretaris && $sekretaris->ttd) {
            if (file_exists(storage_path('app/public/' . $sekretaris->ttd))) {
                $ttdSekretaris = $this->imageToBase64(storage_path('app/public/' . $sekretaris->ttd));
            } elseif (file_exists(public_path('storage/' . $sekretaris->ttd))) {
                $ttdSekretaris = $this->imageToBase64(public_path('storage/' . $sekretaris->ttd));
            } elseif (file_exists(public_path($sekretaris->ttd))) {
                $ttdSekretaris = $this->imageToBase64(public_path($sekretaris->ttd));
            }
        }

        $namaKetuaPanitia = $surat->nama_ketua_panitia ?? '[Nama Ketua Panitia]';
        $namaSekretarisPanitia = $surat->nama_sekretaris_panitia ?? '[Nama Sekretaris Panitia]';
        $ttdKetuaPanitia = null;
        $ttdSekretarisPanitia = null;
        $stempelPanitia = null;

        $kegiatanName = trim($surat->nama_kegiatan ?? ($surat->nama_kegiatan_izin ?? ($surat->kegiatan_st ?? '')));
        if (!empty($kegiatanName)) {
            $tugasKetuaQuery = \App\Models\SuratInternal::where('jenis_surat', 'Surat Tugas')
                ->where(function ($q) use ($kegiatanName) {
                    $q->where('kegiatan_st', $kegiatanName)
                      ->orWhere('kegiatan_st', 'LIKE', '%' . $kegiatanName . '%')
                      ->orWhereRaw('? LIKE CONCAT("%", kegiatan_st, "%")', [$kegiatanName]);
                })
                ->where(function ($q) {
                    $q->where('jabatan_st', 'Ketua Panitia')
                      ->orWhere('jabatan_st', 'LIKE', '%Ketua%');
                });
            if (!empty($surat->nama_ketua_panitia) && $surat->nama_ketua_panitia !== '[Nama Ketua Panitia]') {
                $tugasKetuaQuery->where('anggota_st', $surat->nama_ketua_panitia);
            }
            $tugasKetua = $tugasKetuaQuery->latest()->first();

            $tugasSekretarisQuery = \App\Models\SuratInternal::where('jenis_surat', 'Surat Tugas')
                ->where(function ($q) use ($kegiatanName) {
                    $q->where('kegiatan_st', $kegiatanName)
                      ->orWhere('kegiatan_st', 'LIKE', '%' . $kegiatanName . '%')
                      ->orWhereRaw('? LIKE CONCAT("%", kegiatan_st, "%")', [$kegiatanName]);
                })
                ->where(function ($q) {
                    $q->where('jabatan_st', 'Sekretaris Panitia')
                      ->orWhere('jabatan_st', 'LIKE', '%Sekretaris%');
                });
            if (!empty($surat->nama_sekretaris_panitia) && $surat->nama_sekretaris_panitia !== '[Nama Sekretaris Panitia]') {
                $tugasSekretarisQuery->where('anggota_st', $surat->nama_sekretaris_panitia);
            }
            $tugasSekretaris = $tugasSekretarisQuery->latest()->first();

            if ($tugasKetua) {
                if (empty($surat->nama_ketua_panitia) || $surat->nama_ketua_panitia === '[Nama Ketua Panitia]') {
                    $namaKetuaPanitia = $tugasKetua->anggota_st;
                }
                if (!empty($tugasKetua->ttd_kepanitiaan) && file_exists(public_path($tugasKetua->ttd_kepanitiaan))) {
                    $ttdKetuaPanitia = $this->imageToBase64(public_path($tugasKetua->ttd_kepanitiaan));
                }
                if (!empty($tugasKetua->stempel_kepanitiaan) && file_exists(public_path($tugasKetua->stempel_kepanitiaan))) {
                    $stempelPanitia = $this->imageToBase64(public_path($tugasKetua->stempel_kepanitiaan));
                }
            }

            if ($tugasSekretaris) {
                if (empty($surat->nama_sekretaris_panitia) || $surat->nama_sekretaris_panitia === '[Nama Sekretaris Panitia]') {
                    $namaSekretarisPanitia = $tugasSekretaris->anggota_st;
                }
                if (!empty($tugasSekretaris->ttd_kepanitiaan) && file_exists(public_path($tugasSekretaris->ttd_kepanitiaan))) {
                    $ttdSekretarisPanitia = $this->imageToBase64(public_path($tugasSekretaris->ttd_kepanitiaan));
                }
                if (empty($stempelPanitia) && !empty($tugasSekretaris->stempel_kepanitiaan) && file_exists(public_path($tugasSekretaris->stempel_kepanitiaan))) {
                    $stempelPanitia = $this->imageToBase64(public_path($tugasSekretaris->stempel_kepanitiaan));
                }
            }
        }

        $stempel = $stempelPanitia ?: $stempelKetua;

        return compact(
            'admin', 'sekretaris', 'ttdKetua', 'stempelKetua', 'ttdSekretaris',
            'namaKetuaPanitia', 'namaSekretarisPanitia', 'ttdKetuaPanitia', 'ttdSekretarisPanitia', 'stempelPanitia', 'stempel'
        );
    }

    private function getLogos()
    {
        return [
            $this->imageToBase64(public_path('logo_kiri.png')),
            $this->imageToBase64(public_path('logo_kanan.png'))
        ];
    }

    private function imageToBase64($path)
    {
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return null;
    }
}
