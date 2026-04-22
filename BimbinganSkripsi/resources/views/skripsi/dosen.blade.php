<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persutujuan Pembimbing 2') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Daftar Pengajuan Masuk</h3>
                    
                    @if(count($pengajuan) == 0)
                        <p class="text-gray-500 italic">Tidak ada pengajuan mahasiswa yang tertunda saat ini.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 mt-4">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left">NIM Mahasiswa</th>
                                    <th class="px-6 py-3 text-left">Nama Lengkap</th>
                                    <th class="px-6 py-3 text-left">Aksi Persetujuan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pengajuan as $req)
                                <tr>
                                    <td class="px-6 py-4 font-mono">{{ $req->mahasiswa->nim }}</td>
                                    <td class="px-6 py-4 font-bold">{{ $req->mahasiswa->user->name }}</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <form action="{{ route('skripsi.responP2', $req->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="terima">
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">Terima</button>
                                        </form>
                                        <form action="{{ route('skripsi.responP2', $req->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="action" value="tolak">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
