<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bimbingan Skripsi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    <h3 class="text-lg font-bold mb-4">Kirim Dokumen Bimbingan</h3>
                    
                    @if(!$skripsi || (!$skripsi->pembimbing_1_id && !$skripsi->pembimbing_2_id))
                        <p class="text-red-500 italic">Anda belum memiliki dosen pembimbing secara resmi. Silakan bereskan administrasi pembimbing di menu Skripsi Saya terlebih dahulu.</p>
                    @else
                    <form action="{{ route('bimbingan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Bimbingan (Kirim ke Siapa?)</label>
                                <select name="tipe_bimbingan" class="shadow-sm border-gray-300 rounded-md w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                    <option value="">-- Pilih Tujuan --</option>
                                    @if($skripsi->pembimbing_1_id)
                                    <option value="pembimbing_1">Pembimbing 1 ({{ $skripsi->pembimbing1->user->name }})</option>
                                    @endif
                                    @if($skripsi->pembimbing_2_id && $skripsi->status_pembimbing_2 === 'diterima')
                                    <option value="pembimbing_2">Pembimbing 2 ({{ $skripsi->pembimbing2->user->name }})</option>
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">File Dokumen (PDF/Word)</label>
                                <input type="file" name="file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Kirim Dokumen Bimbingan</button>
                    </form>
                    @endif
                </div>
                
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Riwayat Bimbingan</h3>
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-bold">Waktu</th>
                                <th class="px-6 py-3 text-left font-bold">Tujuan (Dosen)</th>
                                <th class="px-6 py-3 text-left font-bold">File Dokumen</th>
                                <th class="px-6 py-3 text-left font-bold">File Koreksi Dosen</th>
                                <th class="px-6 py-3 text-left font-bold">Status</th>
                                <th class="px-6 py-3 text-left font-bold">Komentar Dosen</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data as $b)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $b->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $b->tipe_bimbingan == 'pembimbing_1' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $b->tipe_bimbingan == 'pembimbing_1' ? 'P1' : 'P2' }}
                                    </span>
                                    <br>
                                    <span class="text-xs text-gray-500">{{ $b->dosen->user->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ asset('uploads/' . $b->file) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 underline flex items-center font-bold">
                                        Unduh Dokumen
                                    </a>
                                </td>
                                <td class="px-6 py-4 border-l">
                                    @if($b->file_koreksi)
                                        <a href="{{ asset('uploads/' . $b->file_koreksi) }}" target="_blank"
                                           class="inline-flex items-center bg-orange-100 text-orange-700 border border-orange-300 px-3 py-1.5 rounded-md text-sm font-bold hover:bg-orange-200 transition">
                                            <i class="fas fa-file-alt mr-2"></i> Unduh Koreksi Dosen
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum ada koreksi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-l">
                                    @if($b->status === 'menunggu')
                                        <span class="text-yellow-600 font-bold">Diajukan</span>
                                    @elseif($b->status === 'revisi')
                                        <span class="text-red-600 font-bold">Revisi</span>
                                    @elseif($b->status === 'acc')
                                        <span class="text-green-600 font-bold">Disetujui Lanjut (ACC)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 italic border-l">
                                    {{ $b->komentar ?? 'Belum ada komentar dari dosen.' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($data->isEmpty())
                        <p class="text-gray-500 italic mt-4 text-center">Belum ada riwayat bimbingan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
