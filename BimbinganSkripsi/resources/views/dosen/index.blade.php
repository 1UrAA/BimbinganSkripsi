<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('dosen.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Dosen</a>
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">NIDN</th>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">Prodi</th>
                                <th class="px-6 py-3 text-left">Email</th>
                                <th class="px-6 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data as $item)
                            <tr>
                                <td class="px-6 py-4">{{ $item->nidn }}</td>
                                <td class="px-6 py-4">{{ $item->user->name ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->user->prodi->nama_prodi ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $item->user->email ?? '-' }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('dosen.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('dosen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
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