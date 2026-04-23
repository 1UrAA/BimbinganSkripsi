<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Skripsi Saya & Pengajuan Pembimbing') }}
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

            {{-- ============================================================ --}}
            {{-- PANEL PEMBIMBING 1                                            --}}
            {{-- ============================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <span class="bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-full mr-3">P1</span>
                        <h3 class="text-lg font-bold">Dosen Pembimbing 1</h3>
                    </div>

                    @if($skripsi && $skripsi->status_pembimbing_1 === 'diterima')
                        {{-- Status: DITERIMA --}}
                        <div class="flex items-center space-x-4 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex-shrink-0 bg-green-500 rounded-full p-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-lg text-green-700 font-bold">{{ $skripsi->pembimbing1->user->name ?? '-' }}</p>
                                <p class="text-sm text-green-600">NIDN: {{ $skripsi->pembimbing1->nidn ?? '-' }} &bull; <span class="font-semibold">✓ Diterima secara resmi</span></p>
                            </div>
                        </div>
                        <div class="mt-3 bg-gray-50 border rounded p-3 text-sm text-gray-600">
                            <p><strong>Judul:</strong> {{ $skripsi->judul }}</p>
                            @if($skripsi->file_proposal)
                            <p class="mt-1"><strong>Proposal:</strong> <a href="{{ route('skripsi.proposal', $skripsi->id) }}" class="text-indigo-600 underline hover:text-indigo-800">📄 Lihat Proposal</a></p>
                            @endif
                        </div>

                    @elseif($skripsi && $skripsi->status_pembimbing_1 === 'menunggu')
                        {{-- Status: MENUNGGU --}}
                        <div class="flex items-center space-x-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex-shrink-0 bg-yellow-400 rounded-full p-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-lg text-yellow-700 font-bold">{{ $skripsi->pembimbing1->user->name ?? '-' }}</p>
                                <p class="text-sm text-yellow-600">⏳ Menunggu persetujuan dosen bersangkutan.</p>
                            </div>
                        </div>
                        <div class="mt-3 bg-gray-50 border rounded p-3 text-sm text-gray-600">
                            <p><strong>Judul yang diajukan:</strong> {{ $skripsi->judul }}</p>
                            @if($skripsi->file_proposal)
                            <p class="mt-1"><strong>Proposal:</strong> <a href="{{ route('skripsi.proposal', $skripsi->id) }}" class="text-indigo-600 underline hover:text-indigo-800">📄 Lihat Proposal</a></p>
                            @endif
                        </div>

                    @else
                        {{-- Status: BELUM ADA / DITOLAK → Tampilkan Form --}}
                        @if($skripsi && $skripsi->status_pembimbing_1 === 'ditolak')
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>Pengajuan sebelumnya ditolak.</strong> Silakan pilih dosen lain dan ajukan kembali.
                        </div>
                        @endif

                        <form action="{{ route('skripsi.ajukanP1') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Skripsi <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" value="{{ old('judul', $skripsi->judul ?? '') }}"
                                    class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Masukkan judul skripsi Anda..." required>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Proposal (PDF/Word) <span class="text-red-500">*</span></label>
                                    <input type="file" name="file_proposal" accept=".pdf,.doc,.docx"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                                    <p class="text-xs text-gray-500 mt-1">Dosen akan melihat proposal ini sebagai pertimbangan.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Calon Dosen Pembimbing 1 <span class="text-red-500">*</span></label>
                                    <select name="pembimbing_1_id" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="">-- Pilih Dosen --</option>
                                        @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('pembimbing_1_id') == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->user->name }} (NIDN: {{ $dosen->nidn }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-semibold">
                                Kirim Pengajuan Pembimbing 1
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- PANEL PEMBIMBING 2                                            --}}
            {{-- ============================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <span class="bg-purple-600 text-white text-xs font-bold px-2.5 py-1 rounded-full mr-3">P2</span>
                        <h3 class="text-lg font-bold">Dosen Pembimbing 2</h3>
                    </div>

                    @if(!$skripsi || $skripsi->status_pembimbing_1 !== 'diterima')
                        {{-- P1 belum diterima --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-500 italic">
                            <svg class="w-5 h-5 inline mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pengajuan Pembimbing 2 baru bisa dilakukan setelah Pembimbing 1 menyetujui pengajuan Anda.
                        </div>

                    @elseif($skripsi->status_pembimbing_2 === 'diterima')
                        {{-- Status: DITERIMA --}}
                        <div class="flex items-center space-x-4 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex-shrink-0 bg-green-500 rounded-full p-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-lg text-green-700 font-bold">{{ $skripsi->pembimbing2->user->name ?? '-' }}</p>
                                <p class="text-sm text-green-600">NIDN: {{ $skripsi->pembimbing2->nidn ?? '-' }} &bull; <span class="font-semibold">✓ Diterima secara resmi</span></p>
                            </div>
                        </div>

                    @elseif($skripsi->status_pembimbing_2 === 'menunggu')
                        {{-- Status: MENUNGGU --}}
                        <div class="flex items-center space-x-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex-shrink-0 bg-yellow-400 rounded-full p-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-lg text-yellow-700 font-bold">{{ $skripsi->pembimbing2->user->name ?? '-' }}</p>
                                <p class="text-sm text-yellow-600">⏳ Menunggu persetujuan dosen bersangkutan.</p>
                            </div>
                        </div>

                    @else
                        {{-- Status: BELUM ADA / DITOLAK → Tampilkan Form --}}
                        @if($skripsi->status_pembimbing_2 === 'ditolak')
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>Pengajuan sebelumnya ditolak.</strong> Silakan pilih dosen lain dan ajukan kembali.
                        </div>
                        @endif

                        <form action="{{ route('skripsi.ajukanP2') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Skripsi <span class="text-red-500">*</span></label>
                                <input type="text" name="judul" value="{{ old('judul', $skripsi->judul ?? '') }}"
                                    class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    placeholder="Masukkan judul skripsi Anda..." required>
                                <p class="text-xs text-gray-500 mt-1">Judul bisa diperbarui jika ada revisi sebelum pengajuan ini.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Proposal (PDF/Word)</label>
                                    <input type="file" name="file_proposal" accept=".pdf,.doc,.docx"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                    @if($skripsi->file_proposal)
                                    <p class="text-xs text-gray-500 mt-1">Proposal saat ini: <a href="{{ asset('uploads/'.$skripsi->file_proposal) }}" target="_blank" class="text-indigo-600 underline">Lihat</a>. Kosongkan jika tidak ingin mengganti.</p>
                                    @else
                                    <p class="text-xs text-gray-500 mt-1">Upload proposal baru (opsional jika sudah ada di P1).</p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Calon Dosen Pembimbing 2 <span class="text-red-500">*</span></label>
                                    <select name="pembimbing_2_id" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                        <option value="">-- Pilih Dosen --</option>
                                        @foreach($dosens as $dosen)
                                            @if($dosen->id != $skripsi->pembimbing_1_id)
                                            <option value="{{ $dosen->id }}" {{ old('pembimbing_2_id') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->user->name }} (NIDN: {{ $dosen->nidn }})
                                            </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 font-semibold">
                                Kirim Pengajuan Pembimbing 2
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
