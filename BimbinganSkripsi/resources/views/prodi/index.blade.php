<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program Studi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('prodi.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Prodi</a>
                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Prodi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_prodi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                    <a href="{{ route('prodi.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('prodi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin?')">
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