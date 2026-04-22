<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('mahasiswa.update', $data->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">NIM</label>
                            <input type="text" name="nim" value="{{ $data->nim }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $data->user->name }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" value="{{ $data->user->email }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Program Studi</label>
                            <select name="prodi_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id }}" {{ $data->user->prodi_id == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Dosen Pembimbing 1</label>
                            <select name="pembimbing_1_id" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <option value="">-- Belum Ditentukan --</option>
                                @foreach($dosens as $d)
                                    <option value="{{ $d->id }}" {{ ($data->skripsi->pembimbing_1_id ?? null) == $d->id ? 'selected' : '' }}>{{ $d->user->name ?? '-' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                            <textarea name="alamat" class="shadow border rounded w-full py-2 px-3 text-gray-700">{{ $data->alamat }}</textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
