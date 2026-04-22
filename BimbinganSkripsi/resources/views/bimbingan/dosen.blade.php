<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bimbingan & Otorisasi Sidang Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'dokumen' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Navigation Tabs -->
                <div class="border-b border-gray-200 bg-gray-50 flex">
                    <button @click="tab = 'dokumen'" :class="tab == 'dokumen' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-4 border-b-2 font-bold text-sm flex items-center transition">
                        <i class="fas fa-folder-open mr-2"></i> Riviu Dokumen Bimbingan Masuk 
                    </button>
                    <button @click="tab = 'otorisasi'" :class="tab == 'otorisasi' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-4 border-b-2 font-bold text-sm flex items-center transition">
                        <i class="fas fa-key mr-2"></i> Panel Otorisasi ACC Ujian (Tiket Sidang)
                    </button>
                </div>

                <div class="p-6">
                    
                    <!-- TAB 1: Dokumen -->
                    <div x-show="tab == 'dokumen'">
                        <h3 class="text-lg font-bold text-gray-800 border-l-4 border-blue-500 pl-3 mb-4">Daftar Berkas Mahasiswa</h3>
                        <table class="min-w-full divide-y divide-gray-200 border rounded-lg overflow-hidden">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-bold text-blue-800 text-sm">Mahasiswa Pengirim</th>
                                    <th class="px-6 py-3 text-left font-bold text-blue-800 text-sm">Posisi Anda</th>
                                    <th class="px-6 py-3 text-left font-bold text-blue-800 text-sm">Dokumen File</th>
                                    <th class="px-6 py-3 text-left font-bold text-blue-800 text-sm">Berikan Feedback / Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $b)
                                <tr>
                                    <td class="px-6 py-4 border-l border-r">
                                        <div class="text-sm font-bold text-gray-900">{{ $b->mahasiswa->user->name }}</div>
                                        <div class="text-sm text-indigo-600">NIM: {{ $b->mahasiswa->nim }}</div>
                                        <div class="text-xs text-gray-400 mt-1"><i class="fas fa-clock"></i> {{ $b->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 border-r text-center">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm {{ $b->tipe_bimbingan == 'pembimbing_1' ? 'bg-indigo-100 text-indigo-800 border border-indigo-400' : 'bg-purple-100 text-purple-800 border border-purple-400' }}">
                                            {{ $b->tipe_bimbingan == 'pembimbing_1' ? 'Pembimbing Utama (P1)' : 'Pembimbing Ke-2 (P2)' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border-r text-center">
                                        <a href="{{ asset('uploads/' . $b->file) }}" target="_blank" class="text-white bg-indigo-500 px-4 py-2 rounded-md hover:bg-indigo-600 underline-none inline-flex items-center text-sm font-bold shadow-sm transition">
                                            <i class="fas fa-file-pdf mr-2"></i> Buka Draft
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('bimbingan.review', $b->id) }}" method="POST" class="space-y-3">
                                            @csrf
                                            <select name="status" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm font-semibold {{ $b->status == 'menunggu' ? 'bg-yellow-50 text-yellow-800 border-yellow-300' : ($b->status == 'revisi' ? 'bg-red-50 text-red-800 border-red-300' : 'bg-green-50 text-green-800 border-green-300') }}">
                                                <option value="menunggu" {{ $b->status == 'menunggu' ? 'selected' : '' }}>Menunggu Diperiksa</option>
                                                <option value="revisi" {{ $b->status == 'revisi' ? 'selected' : '' }}>Masih Perlu Banyak Revisi</option>
                                                <option value="acc" {{ $b->status == 'acc' ? 'selected' : '' }}>Draft Cukup Bagus (ACC Draft)</option>
                                            </select>
                                            <textarea name="komentar" rows="3" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Tuliskan coretan revisi/catatan perbaikan di sini (mereka akan membacanya)...">{{ $b->komentar }}</textarea>
                                            <button type="submit" class="w-full bg-blue-600 text-white px-3 py-2 rounded-md hover:bg-blue-700 text-sm transition shadow-sm font-bold">Simpan Review Draft Ini</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center">
                                        <div class="text-5xl text-gray-300 mb-4"><i class="fas fa-inbox"></i></div>
                                        <p class="text-gray-500 text-lg font-bold">Seluruh Dokumen Bimbingan Telah Diperiksa</p>
                                        <p class="text-gray-400 text-sm mt-1">Belum ada dokumen revisi terbaru yang dikirimkan oleh mahasiswa bimbingan Anda.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


                    <!-- TAB 2: Otorisasi ACC Kunci Sidang -->
                    <div x-show="tab == 'otorisasi'" style="display: none;">
                        <h3 class="text-lg font-bold text-gray-800 border-l-4 border-yellow-500 pl-3 mb-4">Gerbang Validasi Tiket Ujian Mahasiswa</h3>
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg text-sm mb-6 flex">
                            <i class="fas fa-exclamation-triangle text-2xl mr-4 pt-1 opacity-70"></i>
                            <div>
                                <strong class="text-base mb-1 block">Perhatian Dosen Pembimbing:</strong>
                                Mahasiswa bimbingan Anda di bawah ini secara hukum <b>TIDAK AKAN BISA MENDAFTAR SIDANG (Tombol pendaftarannya dikunci oleh sistem)</b> sampai Anda secara eksplisit mencentangkan kotak hijau (Memberikan Hak ACC) pada tahap yang relevan. Jangan berikan Sempro jika draft belum layak, dan jangan berikan Sidang Akhir jika revisi Sempro belum dituntaskan.
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($mahasiswaBimbingan as $skripsi)
                                @php
                                    $isP1 = $skripsi->pembimbing_1_id == Auth::user()->dosen->id;
                                    $isP2 = $skripsi->pembimbing_2_id == Auth::user()->dosen->id;
                                    
                                    $accSempro = $isP1 ? $skripsi->acc_sempro_p1 : $skripsi->acc_sempro_p2;
                                    $accAkhir  = $isP1 ? $skripsi->acc_akhir_p1 : $skripsi->acc_akhir_p2;
                                @endphp
                                <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition overflow-hidden">
                                    <div class="p-4 border-b bg-gray-50 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="bg-gray-800 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold mr-3 shadow">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $skripsi->mahasiswa->user->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $skripsi->mahasiswa->nim }} | Anda sebagai: <span class="font-bold text-blue-600">{{ $isP1 ? 'P1' : 'P2' }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-5 font-medium text-gray-800 text-sm mb-4 bg-gray-50/50">
                                        "{{ Str::limit($skripsi->judul, 70) }}"
                                    </div>
                                    
                                    <div class="p-5 border-t space-y-4">
                                        <!-- Accordion Toggle Sempro -->
                                        <div class="flex items-center justify-between p-3 rounded-lg border {{ $accSempro ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                            <div>
                                                <p class="font-bold {{ $accSempro ? 'text-green-800' : 'text-gray-700' }}">Akses: Seminar Proposal</p>
                                                <p class="text-xs {{ $accSempro ? 'text-green-600' : 'text-gray-500' }} mt-1">Status: {{ $accSempro ? 'Sudah Diizinkan' : 'Terkunci (Belum Layak)' }}</p>
                                            </div>
                                            <form action="{{ route('bimbingan.acc', $skripsi->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="jenis" value="sempro">
                                                <input type="hidden" name="status" value="{{ $accSempro ? '0' : '1' }}">
                                                <button type="submit" class="px-4 py-2 font-bold text-xs rounded shadow transition {{ $accSempro ? 'bg-red-50 text-red-600 hover:bg-red-100 border border-red-200' : 'bg-green-500 text-white hover:bg-green-600' }}">
                                                    {{ $accSempro ? 'Cabut Akses (Batal Sempro)' : 'Buka Kunci (ACC Sempro)' }}
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Accordion Toggle Sidang Akhir -->
                                        <div class="flex items-center justify-between p-3 rounded-lg border {{ $accAkhir ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                                            <div>
                                                <p class="font-bold {{ $accAkhir ? 'text-blue-800' : 'text-gray-700' }}">Akses: Sidang Akhir Skripsi</p>
                                                <p class="text-xs {{ $accAkhir ? 'text-blue-600' : 'text-gray-500' }} mt-1">Status: {{ $accAkhir ? 'Sudah Diizinkan' : 'Terkunci (Belum Layak)' }}</p>
                                            </div>
                                            <form action="{{ route('bimbingan.acc', $skripsi->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="jenis" value="akhir">
                                                <input type="hidden" name="status" value="{{ $accAkhir ? '0' : '1' }}">
                                                <button type="submit" class="px-4 py-2 font-bold text-xs rounded shadow transition {{ $accAkhir ? 'bg-red-50 text-red-600 hover:bg-red-100 border border-red-200' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                                    {{ $accAkhir ? 'Cabut Akses (Batal Sidang)' : 'Buka Kunci (ACC Akhir)' }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-10 bg-gray-50 rounded-lg border">
                                    <p class="text-gray-500">Anda belum memiliki mahasiswa bimbingan yang resmi didaftarkan kepada Anda.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
