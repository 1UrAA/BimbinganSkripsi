<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Admin Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('akun_admin.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Admin Baru</a>
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Tugas di Prodi</th>
                                <th class="px-6 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data as $item)
                            <tr>
                                <td class="px-6 py-4">{{ $item->name }}</td>
                                <td class="px-6 py-4">{{ $item->email }}</td>
                                <td class="px-6 py-4 font-bold">{{ $item->prodi->nama_prodi ?? 'Lupa Set' }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <form action="{{ route('akun_admin.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus Akun Admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
