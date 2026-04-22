<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ujian Sidang Skripsi Berjenjang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- CEK SYARAT DASAR (Punya 2 Pembimbing) -->
            @if(!$skripsi || $skripsi->status_pembimbing_2 !== 'diterima')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8 text-center">
                        <div class="text-gray-300 text-6xl mb-4"><i class="fas fa-lock"></i></div>
                        <h3 class="text-xl font-bold text-gray-700">Tahap Ujian Terkunci</h3>
                        <p class="text-gray-500 mt-2">Anda belum memenuhi syarat dasar. Pastikan Anda telah memiliki 2 Dosen Pembimbing yang disetujui secara sah oleh Admin Prodi melalui modul Skripsi.</p>
                    </div>
                </div>
            @else
                
                @php
                    $accSemproSelesai = $skripsi->acc_sempro_p1 && $skripsi->acc_sempro_p2;
                    $accAkhirSelesai = $skripsi->acc_akhir_p1 && $skripsi->acc_akhir_p2;
                    
                    // Logic kelulusan Sempro: Sidang Sempro berstatus 'selesai' dan tidak semuanya 'revisi' fatal (disimplifikasi: sudah diujikan 2 dosen).
                    $semproLulus = false;
                    if ($sidangSempro && $sidangSempro->status == 'selesai') {
                        // Jika sudah ada 2 nilai, kita anggap lulus untuk melaju (asumsi riil akademik: dikasih revisi tetap lanjut asal revisi dikerjakan)
                        if($sidangSempro->nilai->count() == 2) {
                            $semproLulus = true;
                        }
                    }
                @endphp

                <!-- 1. KOTAK UJIAN SEMINAR PROPOSAL -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-bold text-gray-800">Tahap 1: Seminar Proposal (Sempro)</h3>
                    </div>
                    <div class="p-6 bg-gray-50/30">
                        @if(!$sidangSempro || $sidangSempro->status == 'ditolak')
                            
                            @if($sidangSempro && $sidangSempro->status == 'ditolak')
                                <div class="mb-8">
                                    <h4 class="text-xs text-red-600 font-bold uppercase tracking-wider mb-3">Status Pengajuan Sempro Terdahulu</h4>
                                    @include('sidang.partials.status_card', ['sidangModel' => $sidangSempro])
                                </div>
                                <hr class="my-6 border-red-200">
                                <div class="bg-red-50 text-red-800 p-4 rounded-lg mb-6 text-sm font-bold border border-red-200 shadow-sm">
                                    <i class="fas fa-undo-alt mr-2"></i> Dinyatakan Tidak Lulus pada Seminar Proposal. Silakan temui Dosen Pembimbing untuk melakukan bimbingan ulang dan mengajukan persetujuan Pendaftaran Sempro kembali.
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                <div>
                                    <h4 class="font-bold text-gray-700 mb-2">Pendaftaran Ujian Sempro</h4>
                                    <p class="text-sm text-gray-500 mb-4">Pastikan draf awal rancangan penelitian Anda telah disetujui (di-ACC) oleh kedua Pembimbing untuk dapat mendaftar Sempro.</p>
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center text-sm {{ $skripsi->acc_sempro_p1 ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                                            <i class="fas {{ $skripsi->acc_sempro_p1 ? 'fa-check-circle' : 'fa-times-circle' }} mr-2 w-4 text-center"></i> Izin Seminar dari P1
                                        </div>
                                        <div class="flex items-center text-sm {{ $skripsi->acc_sempro_p2 ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                                            <i class="fas {{ $skripsi->acc_sempro_p2 ? 'fa-check-circle' : 'fa-times-circle' }} mr-2 w-4 text-center"></i> Izin Seminar dari P2
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white p-5 rounded-lg border shadow-sm relative overflow-hidden">
                                    @if(!$accSemproSelesai)
                                        <!-- Overlay Gelap (Disabled) -->
                                        <div class="absolute inset-0 bg-gray-900 bg-opacity-70 flex flex-col items-center justify-center z-10 backdrop-blur-[1px]">
                                            <i class="fas fa-ban text-red-500 text-3xl mb-2"></i>
                                            <p class="text-white font-bold text-sm text-center px-4">Pendaftaran Belum Dapat Dilakukan<br><span class="text-xs font-normal">Harap selesaikan proses bimbingan terlebih dahulu.</span></p>
                                        </div>
                                    @endif
                                    <form action="{{ route('sidang.daftar') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jenis" value="proposal">
                                        <div class="mb-4">
                                            <label class="block text-sm font-bold text-gray-700 mb-1">Judul Proposal</label>
                                            <textarea name="judul" rows="2" class="w-full border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 text-sm" required {{ !$accSemproSelesai ? 'disabled' : '' }} placeholder="Ketik judul proposal..."></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded shadow transition hover:bg-indigo-700" {{ !$accSemproSelesai ? 'disabled' : '' }}>
                                            Daftar Seminar Proposal
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- STATUS SEMPRO -->
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-1 bg-white p-5 rounded-lg border shadow-sm">
                                    <h4 class="text-xs text-indigo-500 font-bold uppercase tracking-wider mb-3">Status Pengajuan Sempro</h4>
                                    @include('sidang.partials.status_card', ['sidangModel' => $sidangSempro])
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 2. KOTAK SIDANG AKHIR (Tergembok sampai Sempro Lulus) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6 border-l-4 {{ $semproLulus ? 'border-green-500' : 'border-gray-300 opacity-60' }}">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h3 class="text-lg font-bold {{ $semproLulus ? 'text-gray-800' : 'text-gray-400' }}">Tahap 2: Sidang Akhir Skripsi</h3>
                        @if(!$semproLulus)
                            <span class="text-xs font-bold text-gray-400 border border-gray-300 px-2 py-1 rounded"><i class="fas fa-lock mr-1"></i> Tersegel</span>
                        @else
                            <span class="text-xs font-bold text-green-700 bg-green-100 border border-green-300 px-2 py-1 rounded"><i class="fas fa-unlock mr-1"></i> Terbuka Terakses</span>
                        @endif
                    </div>
                    <div class="p-6 bg-gray-50/30 relative">
                        <!-- Jika Sempro belum lulus, kunci total satu kontainer ini -->
                        @if(!$semproLulus)
                            <div class="absolute inset-0 z-10 cursor-not-allowed"></div>
                            <div class="text-center py-6">
                                <p class="text-gray-400 font-medium">Buktikan bahwa Anda lulus di Seminar Proposal terlebih dahulu untuk membuka akses ujian pamungkas ini.</p>
                            </div>
                        @else
                            <!-- Sempro sudah lulus, jalankan logika pendaftaran sidang akhir -->
                            @if(!$sidangAkhir || $sidangAkhir->status == 'ditolak')
                                
                                @if($sidangAkhir && $sidangAkhir->status == 'ditolak')
                                    <div class="mb-8">
                                        <h4 class="text-xs text-red-600 font-bold uppercase tracking-wider mb-3">Status Pengajuan Sidang Akhir Terdahulu</h4>
                                        @include('sidang.partials.status_card', ['sidangModel' => $sidangAkhir])
                                    </div>
                                    <hr class="my-6 border-red-200">
                                    <div class="bg-red-50 text-red-800 p-4 rounded-lg mb-6 text-sm font-bold border border-red-200 shadow-sm">
                                        <i class="fas fa-undo-alt mr-2"></i> Dinyatakan Tidak Lulus pada Sidang Akhir. Silakan temui Dosen Pembimbing untuk melakukan perbaikan naskah dan meminta ACC Sidang Akhir kembali.
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                                    <div>
                                        <h4 class="font-bold text-gray-700 mb-2">Pendaftaran Sidang Akhir</h4>
                                        <p class="text-sm text-gray-500 mb-4">Pastikan seluruh penyusunan dari Bab 1 hingga Bab Penutup telah usai dan direstui (ACC Sidang Akhir) oleh Pembimbing Anda secara utuh.</p>
                                        
                                        <div class="space-y-2 mb-4">
                                            <div class="flex items-center text-sm {{ $skripsi->acc_akhir_p1 ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                                                <i class="fas {{ $skripsi->acc_akhir_p1 ? 'fa-check-circle' : 'fa-times-circle' }} mr-2 w-4 text-center"></i> Izin Sidang Akhir P1
                                            </div>
                                            <div class="flex items-center text-sm {{ $skripsi->acc_akhir_p2 ? 'text-green-600 font-bold' : 'text-gray-400' }}">
                                                <i class="fas {{ $skripsi->acc_akhir_p2 ? 'fa-check-circle' : 'fa-times-circle' }} mr-2 w-4 text-center"></i> Izin Sidang Akhir P2
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-white p-5 rounded-lg border shadow-sm relative overflow-hidden">
                                        @if(!$accAkhirSelesai)
                                            <!-- Overlay Gelap (Disabled) -->
                                            <div class="absolute inset-0 bg-gray-900 bg-opacity-70 flex flex-col items-center justify-center z-10 backdrop-blur-[1px]">
                                                <i class="fas fa-ban text-red-500 text-3xl mb-2"></i>
                                                <p class="text-white font-bold text-sm text-center px-4">Akses Pendaftaran Terkunci<br><span class="text-xs font-normal">Dapatkan persetujuan dari kedua Dosen Pembimbing.</span></p>
                                            </div>
                                        @endif
                                        <form action="{{ route('sidang.daftar') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="jenis" value="akhir">
                                            <div class="mb-4">
                                                <label class="block text-sm font-bold text-gray-700 mb-1">Judul Akhir Skripsi (Siap Uji)</label>
                                                <textarea name="judul" rows="2" class="w-full border-gray-300 rounded focus:ring-green-500 focus:border-green-500 text-sm font-medium" required {{ !$accAkhirSelesai ? 'disabled' : '' }}>{{ $sidangSempro->judul }}</textarea>
                                                <p class="text-xs text-gray-400 mt-1">Anda bisa memperbarui ketikan judul jika ada revisi pasca sempro.</p>
                                            </div>
                                            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded shadow transition hover:bg-green-700" {{ !$accAkhirSelesai ? 'disabled' : '' }}>
                                                Daftar Sidang Akhir Komprehensif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <!-- STATUS SIDANG AKHIR -->
                                <div class="flex flex-col md:flex-row gap-6">
                                    <div class="flex-1 bg-white p-5 rounded-lg border shadow-sm">
                                        <h4 class="text-xs text-green-600 font-bold uppercase tracking-wider mb-3">Status Pengajuan Sidang Akhir</h4>
                                        @include('sidang.partials.status_card', ['sidangModel' => $sidangAkhir])
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>
