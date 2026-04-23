<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Pembimbing Masuk') }}
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

            {{-- ============================================================ --}}
            {{-- PENGAJUAN PEMBIMBING 1                                        --}}
            {{-- ============================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <span class="bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-full mr-3">P1</span>
                        <h3 class="text-lg font-bold">Pengajuan Pembimbing 1 — Menunggu Keputusan Anda</h3>
                    </div>

                    @if(count($pengajuanP1) == 0)
                        <p class="text-gray-500 italic">Tidak ada pengajuan Pembimbing 1 yang tertunda saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mahasiswa</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul Skripsi</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Proposal</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pengajuanP1 as $req)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-gray-800">{{ $req->mahasiswa->user->name }}</p>
                                            <p class="text-sm font-mono text-gray-500">{{ $req->mahasiswa->nim }}</p>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 max-w-xs">
                                            {{ $req->judul ?? '<span class="italic text-gray-400">Belum ada judul</span>' }}
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($req->file_proposal)
                                                <a href="{{ route('skripsi.proposal', $req->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-md hover:bg-indigo-200 transition">
                                                    📄 Unduh Proposal
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic text-sm">Tidak ada file</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('skripsi.responP1', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="terima">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                                        ✓ Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('skripsi.responP1', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="tolak">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                                        ✗ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ============================================================ --}}
            {{-- PENGAJUAN PEMBIMBING 2                                        --}}
            {{-- ============================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <span class="bg-purple-600 text-white text-xs font-bold px-2.5 py-1 rounded-full mr-3">P2</span>
                        <h3 class="text-lg font-bold">Pengajuan Pembimbing 2 — Menunggu Keputusan Anda</h3>
                    </div>

                    @if(count($pengajuanP2) == 0)
                        <p class="text-gray-500 italic">Tidak ada pengajuan Pembimbing 2 yang tertunda saat ini.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-purple-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mahasiswa</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Judul Skripsi</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Proposal</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pembimbing 1</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pengajuanP2 as $req)
                                    <tr class="hover:bg-purple-50 transition">
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-gray-800">{{ $req->mahasiswa->user->name }}</p>
                                            <p class="text-sm font-mono text-gray-500">{{ $req->mahasiswa->nim }}</p>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-700 max-w-xs">
                                            {{ $req->judul ?? '<span class="italic text-gray-400">Belum ada judul</span>' }}
                                        </td>
                                        <td class="px-4 py-4">
                                            @if($req->file_proposal)
                                                <a href="{{ route('skripsi.proposal', $req->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-md hover:bg-indigo-200 transition">
                                                    📄 Unduh Proposal
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic text-sm">Tidak ada file</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600">
                                            {{ $req->pembimbing1->user->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <div class="flex space-x-2">
                                                <form action="{{ route('skripsi.responP2', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="terima">
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                                        ✓ Terima
                                                    </button>
                                                </form>
                                                <form action="{{ route('skripsi.responP2', $req->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="action" value="tolak">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
                                                        ✗ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
