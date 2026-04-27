<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.progress.index') }}" class="text-blue-600 hover:text-blue-800 font-bold text-sm">
                ← Kembali ke Daftar Progress
            </a>
            <span class="text-gray-400">/</span>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Bimbingan: {{ $mahasiswa->user->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info Mahasiswa & Skripsi --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">Informasi Mahasiswa</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">NIM</p>
                        <p class="font-bold text-gray-900 mt-1">{{ $mahasiswa->nim }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Nama</p>
                        <p class="font-bold text-gray-900 mt-1">{{ $mahasiswa->user->name }}</p>
                    </div>
                    @if($mahasiswa->skripsi)
                    <div class="md:col-span-2">
                        <p class="text-gray-500">Judul Skripsi</p>
                        <p class="font-semibold text-gray-800 mt-1">{{ $mahasiswa->skripsi->judul ?? '-' }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tahapan Bimbingan --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="bg-gray-50 border-b px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 text-lg border-l-4 border-indigo-500 pl-3">
                        Tahapan Status Dosen Pembimbing
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Pembimbing 1 --}}
                    <div class="border rounded-xl p-4 {{ $mahasiswa->skripsi && $mahasiswa->skripsi->status_pembimbing_1 === 'diterima' ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <p class="text-xs text-gray-500 font-bold uppercase mb-2">Pembimbing 1</p>
                        @if(!$mahasiswa->skripsi || !$mahasiswa->skripsi->pembimbing_1_id)
                            <span class="text-gray-500 text-sm italic">Belum mengajukan</span>
                        @elseif($mahasiswa->skripsi->status_pembimbing_1 === 'menunggu')
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full mb-2">⏳ Pengajuan Dosen Pembimbing (Menunggu)</span>
                            <p class="text-sm text-gray-700 mt-1">Pengajuan ke: <strong>{{ $mahasiswa->skripsi->pembimbing1->user->name ?? '-' }}</strong></p>
                        @elseif($mahasiswa->skripsi->status_pembimbing_1 === 'diterima')
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-2">✅ Diterima</span>
                            <p class="text-sm text-indigo-700 font-bold mt-1">{{ $mahasiswa->skripsi->pembimbing1->user->name ?? '-' }}</p>
                        @elseif($mahasiswa->skripsi->status_pembimbing_1 === 'ditolak')
                            <span class="inline-block px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full mb-2">❌ Ditolak</span>
                            <p class="text-sm text-gray-600 mt-1">Diajukan ke: {{ $mahasiswa->skripsi->pembimbing1->user->name ?? '-' }}</p>
                        @endif
                    </div>
                    {{-- Pembimbing 2 --}}
                    <div class="border rounded-xl p-4 {{ $mahasiswa->skripsi && $mahasiswa->skripsi->status_pembimbing_2 === 'diterima' ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <p class="text-xs text-gray-500 font-bold uppercase mb-2">Pembimbing 2</p>
                        @if(!$mahasiswa->skripsi || !$mahasiswa->skripsi->pembimbing_2_id || $mahasiswa->skripsi->status_pembimbing_2 === 'none')
                            <span class="text-gray-500 text-sm italic">Belum mengajukan</span>
                        @elseif($mahasiswa->skripsi->status_pembimbing_2 === 'menunggu')
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full mb-2">⏳ Pengajuan Dosen Pembimbing (Menunggu)</span>
                            <p class="text-sm text-gray-700 mt-1">Pengajuan ke: <strong>{{ $mahasiswa->skripsi->pembimbing2->user->name ?? '-' }}</strong></p>
                        @elseif($mahasiswa->skripsi->status_pembimbing_2 === 'diterima')
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full mb-2">✅ Diterima</span>
                            <p class="text-sm text-indigo-700 font-bold mt-1">{{ $mahasiswa->skripsi->pembimbing2->user->name ?? '-' }}</p>
                        @elseif($mahasiswa->skripsi->status_pembimbing_2 === 'ditolak')
                            <span class="inline-block px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full mb-2">❌ Ditolak</span>
                            <p class="text-sm text-gray-600 mt-1">Diajukan ke: {{ $mahasiswa->skripsi->pembimbing2->user->name ?? '-' }}</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Statistik Bimbingan --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-blue-500">
                    <p class="text-4xl font-black text-blue-600">{{ $bimbingans->count() }}</p>
                    <p class="text-sm text-gray-500 font-semibold mt-1">Total Sesi Bimbingan</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-indigo-500">
                    <p class="text-4xl font-black text-indigo-600">{{ $totalP1 }}</p>
                    <p class="text-sm text-gray-500 font-semibold mt-1">Bimbingan ke Pembimbing 1</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center border-t-4 border-purple-500">
                    <p class="text-4xl font-black text-purple-600">{{ $totalP2 }}</p>
                    <p class="text-sm text-gray-500 font-semibold mt-1">Bimbingan ke Pembimbing 2</p>
                </div>
            </div>

            {{-- Riwayat Bimbingan (Read-only) --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="bg-gray-50 border-b px-6 py-4">
                    <h3 class="font-bold text-gray-800 text-lg border-l-4 border-purple-500 pl-3">
                        Riwayat Sesi Bimbingan
                    </h3>
                </div>
                <div class="p-6">
                    @if($bimbingans->isEmpty())
                        <p class="text-gray-500 italic text-center py-8">Mahasiswa ini belum memiliki riwayat bimbingan.</p>
                    @else
                    <div class="space-y-3">
                        @foreach($bimbingans as $index => $b)
                        <div class="flex items-start space-x-4 p-4 rounded-lg border
                            {{ $b->status === 'acc' ? 'bg-green-50 border-green-200' : ($b->status === 'revisi' ? 'bg-red-50 border-red-200' : 'bg-yellow-50 border-yellow-200') }}">
                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shadow
                                {{ $b->tipe_bimbingan === 'pembimbing_1' ? 'bg-indigo-600 text-white' : 'bg-purple-600 text-white' }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                        {{ $b->tipe_bimbingan === 'pembimbing_1' ? 'bg-indigo-100 text-indigo-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $b->tipe_bimbingan === 'pembimbing_1' ? 'P1' : 'P2' }}
                                    </span>
                                    <span class="text-sm font-bold text-gray-800">{{ $b->dosen->user->name ?? '-' }}</span>
                                    <span class="text-xs text-gray-400 ml-auto">{{ $b->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center space-x-3 mt-2 flex-wrap gap-y-1">
                                    <a href="{{ asset('uploads/' . $b->file) }}" target="_blank"
                                       class="text-xs text-indigo-600 font-semibold underline hover:text-indigo-800">
                                        📄 Lihat Dokumen Mahasiswa
                                    </a>
                                    @if($b->file_koreksi)
                                    <a href="{{ asset('uploads/' . $b->file_koreksi) }}" target="_blank"
                                       class="text-xs text-orange-600 font-semibold underline hover:text-orange-800">
                                        📝 Lihat File Koreksi Dosen
                                    </a>
                                    @endif
                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                        {{ $b->status === 'acc' ? 'bg-green-100 text-green-700' : ($b->status === 'revisi' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ $b->status === 'acc' ? '✅ ACC' : ($b->status === 'revisi' ? '🔴 Revisi' : '⏳ Menunggu') }}
                                    </span>
                                </div>
                                @if($b->komentar)
                                <p class="text-xs text-gray-600 italic mt-1 bg-white/60 rounded px-2 py-1">
                                    💬 {{ $b->komentar }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
