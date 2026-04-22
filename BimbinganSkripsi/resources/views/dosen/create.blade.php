<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('dosen.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">NIDN</label>
                            <input type="text" name="nidn" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password (min 6)</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Program Studi</label>
                            <select name="prodi_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                            <textarea name="alamat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
