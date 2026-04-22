<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Skripsi Saya & Pembimbing') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Status Dosen Pembimbing</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Pembimbing 1 Panel -->
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <h4 class="font-bold text-gray-700 mb-2">Pembimbing 1</h4>
                            @if($skripsi && $skripsi->pembimbing_1_id)
                                <p class="text-lg text-indigo-600 font-semibold">{{ $skripsi->pembimbing1->user->name ?? '-' }}</p>
                                <p class="text-sm text-gray-500">NIDN: {{ $skripsi->pembimbing1->nidn ?? '-' }}</p>
                            @else
                                <p class="text-red-500 italic">Belum ditentukan. Silakan hubungi Admin Prodi.</p>
                            @endif
                        </div>

                        <!-- Pembimbing 2 Panel -->
                        <div class="border p-4 rounded-lg bg-gray-50">
                            <h4 class="font-bold text-gray-700 mb-2">Pembimbing 2</h4>
                            @if(!$skripsi || !$skripsi->pembimbing_1_id)
                                <p class="text-gray-500 italic">Tunggu Pembimbing 1 ditentukan untuk bisa mengajukan Pembimbing 2.</p>
                            
                            @elseif(!$skripsi->pembimbing_2_id || $skripsi->status_pembimbing_2 === 'ditolak')
                                @if($skripsi->status_pembimbing_2 === 'ditolak')
                                <p class="text-red-500 text-sm mb-2 font-bold">Pengajuan sebelumnya ditolak. Silakan ajukan ulang dosen lain.</p>
                                @endif
                                
                                <form action="{{ route('skripsi.ajukanP2') }}" method="POST">
                                    @csrf
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Dosen Pembimbing 2:</label>
                                    <div class="flex">
                                        <select name="pembimbing_2_id" class="shadow-sm border-gray-300 rounded-l-md w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                            <option value="">-- Pilih Dosen --</option>
                                            @foreach($dosens as $dosen)
                                                @if($dosen->id != $skripsi->pembimbing_1_id)
                                                <option value="{{ $dosen->id }}">{{ $dosen->user->name }} (NIDN: {{ $dosen->nidn }})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">Ajukan</button>
                                    </div>
                                </form>
                            @elseif($skripsi->status_pembimbing_2 === 'menunggu')
                                <p class="text-lg text-yellow-600 font-semibold">{{ $skripsi->pembimbing2->user->name ?? '-' }}</p>
                                <p class="text-sm text-yellow-500 mt-1"><i class="fas fa-clock"></i> Menunggu persetujuan Dosen bersangkutan.</p>
                            @elseif($skripsi->status_pembimbing_2 === 'diterima')
                                <p class="text-lg text-green-600 font-semibold">{{ $skripsi->pembimbing2->user->name ?? '-' }}</p>
                                <p class="text-sm text-green-500 mt-1 font-bold">✓ Diterima secara resmi.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
