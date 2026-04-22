<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Sidang Ujian Skripsi') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ tab: 'antrean' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Tabs -->
                <div class="border-b border-gray-200 bg-gray-50 flex">
                    <button @click="tab = 'antrean'" :class="tab == 'antrean' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm flex items-center transition">
                        <i class="fas fa-list-ul mr-2"></i> Pengajuan Mahasiswa
                    </button>
                    <button @click="tab = 'ruangan'" :class="tab == 'ruangan' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="px-6 py-4 border-b-2 font-medium text-sm flex items-center transition">
                        <i class="fas fa-door-open mr-2"></i> Master Ruangan
                    </button>
                </div>

                <div class="p-6 text-gray-900">
                    
                    <!-- TAB 1: Antrean -->
                    <div x-show="tab == 'antrean'">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">Judul Skripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal & Ruangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-1/4">Plot Penguji / Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($sidangs as $s)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold mb-1 {{ $s->jenis_sidang == 'proposal' ? 'text-indigo-600' : 'text-green-600' }}">
                                            <i class="fas {{ $s->jenis_sidang == 'proposal' ? 'fa-book-reader' : 'fa-graduation-cap' }}"></i> TIKET {{ strtoupper($s->jenis_sidang == 'proposal' ? 'SEMINAR PROPOSAL' : 'SIDANG AKHIR') }}
                                        </div>
                                        <div class="text-sm font-bold text-gray-900">{{ $s->mahasiswa->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $s->mahasiswa->nim }}</div>
                                        @if($s->status == 'diajukan')
                                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Jadwal</span>
                                        @elseif($s->status == 'terjadwal')
                                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Sudah Terjadwal</span>
                                        @else
                                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 italic">
                                        "{{ Str::limit($s->judul, 60) }}"
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($s->status == 'diajukan')
                                            <p class="text-xs text-red-500 font-bold"><i class="fas fa-exclamation-triangle"></i> Belum Ditetapkan</p>
                                        @else
                                            <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($s->tanggal)->format('d/m/Y') }} <span class="text-gray-500 font-normal">pukul</span> {{ \Carbon\Carbon::parse($s->jam)->format('H:i') }}</p>
                                            <p class="text-xs text-gray-500 mt-1"><i class="fas fa-map-marker-alt"></i> {{ $s->ruangan->nama_ruangan }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div x-data="{ modalOpen: false }">
                                            @if($s->status == 'diajukan')
                                                <button @click="modalOpen = true" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded shadow">
                                                    Plot Jadwal & Penguji
                                                </button>
                                            @else
                                                <div class="text-xs space-y-1 mb-2">
                                                    @foreach($s->pengujis as $idx => $p)
                                                        <p><span class="font-bold text-blue-600">P{{$idx+1}}</span>: {{ $p->dosen->user->name }}</p>
                                                    @endforeach
                                                </div>
                                                @if($s->status != 'selesai')
                                                <button @click="modalOpen = true" class="text-indigo-600 hover:text-indigo-900 border border-indigo-200 bg-indigo-50 px-3 py-1 rounded text-xs font-bold">
                                                    Revisi Jadwal
                                                </button>
                                                @endif
                                            @endif

                                            <!-- Form Modal Overlay -->
                                            <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50 backdrop-blur-sm" style="display: none;">
                                                <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-auto p-6" @click.away="modalOpen = false">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-bold text-gray-900">Penjadwalan Sidang</h3>
                                                        <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times"></i></button>
                                                    </div>
                                                    
                                                    <div class="rounded-lg p-3 mb-4 {{ $s->jenis_sidang == 'proposal' ? 'bg-indigo-50 border border-indigo-200' : 'bg-green-50 border border-green-200' }}">
                                                        <p class="text-xs font-bold uppercase tracking-widest {{ $s->jenis_sidang == 'proposal' ? 'text-indigo-700' : 'text-green-700' }} mb-1">Target Penjadwalan: {{ $s->jenis_sidang == 'proposal' ? 'Seminar Proposal' : 'Sidang Akhir Skripsi' }}</p>
                                                        <p class="text-sm text-gray-700 cursor-default">Mahasiswa: <span class="font-bold text-gray-900">{{ $s->mahasiswa->user->name }}</span> ({{ $s->mahasiswa->nim }})</p>
                                                    </div>
                                                    
                                                    <form action="{{ route('admin.sidang.jadwal', $s->id) }}" method="POST">
                                                        @csrf
                                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal</label>
                                                                <input type="date" name="tanggal" value="{{ $s->tanggal }}" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-700 mb-1">Jam Belajar</label>
                                                                <input type="time" name="jam" value="{{ $s->jam }}" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mb-4">
                                                            <label class="block text-xs font-bold text-gray-700 mb-1">Ruangan Sidang</label>
                                                            <select name="ruangan_id" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                                                <option value="">-- Pilih Ruangan --</option>
                                                                @foreach($ruangans as $r)
                                                                    <option value="{{ $r->id }}" {{ $s->ruangan_id == $r->id ? 'selected' : '' }}>{{ $r->nama_ruangan }} ({{ $r->lokasi }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="space-y-4 mb-6 border-t pt-4">
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Dosen Penguji 1</label>
                                                                <select name="penguji_1_id" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                                                    <option value="">-- Dosen Penguji 1 --</option>
                                                                    @foreach($dosens as $d)
                                                                        <option value="{{ $d->id }}" {{ count($s->pengujis) > 0 && $s->pengujis[0]->dosen_id == $d->id ? 'selected' : '' }}>{{ $d->user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label class="block text-xs font-bold text-gray-700 mb-1">Pilih Dosen Penguji 2</label>
                                                                <select name="penguji_2_id" class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                                                    <option value="">-- Dosen Penguji 2 --</option>
                                                                    @foreach($dosens as $d)
                                                                        <option value="{{ $d->id }}" {{ count($s->pengujis) > 1 && $s->pengujis[1]->dosen_id == $d->id ? 'selected' : '' }}>{{ $d->user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end space-x-2">
                                                            <button type="button" @click="modalOpen = false" class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded">Batal</button>
                                                            <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 font-bold rounded shadow-sm">Simpan Jadwal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">Belum ada mahasiswa yang mengajukan sidang saat ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- TAB 2: Master Ruangan -->
                    <div x-show="tab == 'ruangan'" style="display: none;">
                        <div class="flex flex-col md:flex-row gap-6">
                            
                            <div class="w-full md:w-1/3">
                                <div class="bg-gray-50 p-4 border rounded-lg">
                                    <h4 class="font-bold text-gray-800 mb-4">Tambah Ruangan Baru</h4>
                                    <form action="{{ route('admin.sidang.ruangan') }}" method="POST" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Nama Ruangan</label>
                                            <input type="text" name="nama_ruangan" placeholder="Contoh: Lab 1 Komputer" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Lokasi / Gedung</label>
                                            <input type="text" name="lokasi" placeholder="Contoh: Gedung Fakultas Teknik Lt 3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                        <button type="submit" class="w-full justify-center flex items-center bg-gray-800 text-white font-bold py-2 px-4 rounded hover:bg-gray-900 transition">
                                            <i class="fas fa-plus mr-2"></i> Daftarkan Ruangan
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="w-full md:w-2/3">
                                <table class="min-w-full divide-y divide-gray-200 border rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Ruangan</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi / Gedung</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($ruangans as $r)
                                        <tr>
                                            <td class="px-6 py-4 font-bold text-gray-800">{{ $r->nama_ruangan }}</td>
                                            <td class="px-6 py-4 text-gray-600">{{ $r->lokasi }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data ruangan pendaftaran.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
