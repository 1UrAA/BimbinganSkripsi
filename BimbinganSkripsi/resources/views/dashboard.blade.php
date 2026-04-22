<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Sistem Skripsi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Bimbingan -->
                <a href="/bimbingan" class="bg-blue-500 text-white p-6 rounded-lg shadow hover:bg-blue-600">
                    <h3 class="text-lg font-bold">Bimbingan</h3>
                    <p>Kelola bimbingan skripsi</p>
                </a>

                <!-- Sidang -->
                <a href="/sidang" class="bg-green-500 text-white p-6 rounded-lg shadow hover:bg-green-600">
                    <h3 class="text-lg font-bold">Sidang</h3>
                    <p>Daftar & lihat jadwal sidang</p>
                </a>

                <!-- Admin -->
                <a href="#" class="bg-purple-500 text-white p-6 rounded-lg shadow hover:bg-purple-600">
                    <h3 class="text-lg font-bold">Admin Panel</h3>
                    <p>Kelola jadwal & ruangan</p>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>