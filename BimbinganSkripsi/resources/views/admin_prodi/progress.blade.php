<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Progress Bimbingan Skripsi Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-800 border-l-4 border-blue-500 pl-3 mb-6">
                        Daftar Progres Mahasiswa
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border rounded-lg overflow-hidden">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-blue-800">NIM</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-blue-800">Nama Mahasiswa</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-blue-800">Status Dosen Pembimbing 1</th>
                                    <th class="px-4 py-3 text-left text-sm font-bold text-blue-800">Status Dosen Pembimbing 2</th>
                                    <th class="px-4 py-3 text-center text-sm font-bold text-blue-800">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($mahasiswas as $mhs)
                                @php
                                    $skripsi = $mhs->skripsi;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-4 text-sm font-mono text-gray-700">{{ $mhs->nim }}</td>
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-gray-900 text-sm">{{ $mhs->user->name }}</div>
                                    </td>
                                    {{-- Status Pembimbing 1 --}}
                                    <td class="px-4 py-4">
                                        @if(!$skripsi || !$skripsi->pembimbing_1_id)
                                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-500 rounded-full">
                                                Belum Mengajukan
                                            </span>
                                        @elseif($skripsi->status_pembimbing_1 === 'menunggu')
                                            <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                                ⏳ Menunggu Persetujuan
                                            </span>
                                        @elseif($skripsi->status_pembimbing_1 === 'diterima')
                                            <div>
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                                    ✅ Diterima
                                                </span>
                                                <p class="text-xs text-indigo-600 font-bold mt-1">
                                                    {{ $skripsi->pembimbing1->user->name ?? '-' }}
                                                </p>
                                            </div>
                                        @elseif($skripsi->status_pembimbing_1 === 'ditolak')
                                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-600 rounded-full">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    {{-- Status Pembimbing 2 --}}
                                    <td class="px-4 py-4">
                                        @if(!$skripsi || !$skripsi->pembimbing_2_id || $skripsi->status_pembimbing_2 === 'none')
                                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-500 rounded-full">
                                                Belum Mengajukan
                                            </span>
                                        @elseif($skripsi->status_pembimbing_2 === 'menunggu')
                                            <span class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                                ⏳ Menunggu Persetujuan
                                            </span>
                                        @elseif($skripsi->status_pembimbing_2 === 'diterima')
                                            <div>
                                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                                    ✅ Diterima
                                                </span>
                                                <p class="text-xs text-indigo-600 font-bold mt-1">
                                                    {{ $skripsi->pembimbing2->user->name ?? '-' }}
                                                </p>
                                            </div>
                                        @elseif($skripsi->status_pembimbing_2 === 'ditolak')
                                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-600 rounded-full">
                                                ❌ Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('admin.progress.detail', $mhs->id) }}"
                                           class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-blue-700 shadow-sm transition">
                                            <i class="fas fa-eye mr-2"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                        Belum ada data mahasiswa.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
