<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Sidang & Evaluasi (Penguji)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-lg shadow-lg text-white p-6 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 text-3xl opacity-80"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold">Portal Penilaian Dosen</h3>
                        <p class="text-indigo-200 text-sm mt-1">Daftar ini adalah kumpulan Sidang Skripsi di mana Anda ditunjuk sebagai Dosen Dewan Penguji secara langsung oleh Institusi. Lakukan penjurian nilai pada tanggal yang tertera.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($pengujians as $peng)
                    @php
                        $sidang = $peng->sidang;
                        $mhs = $sidang->mahasiswa;
                        $nilaiAnda = $nilaiSudah->get($sidang->id);
                        
                        // Cerminan UI berdasar status
                        $isDinilai = !is_null($nilaiAnda);
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm border {{ $isDinilai ? 'border-green-300' : 'border-gray-200 hover:border-blue-400' }} transition overflow-hidden">
                        
                        <!-- Header Card -->
                        <div class="px-6 py-4 {{ $isDinilai ? 'bg-green-50' : 'bg-gray-50' }} border-b flex justify-between items-center">
                            <div>
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded uppercase tracking-wide mr-2 shadow-sm">{{ str_replace('_', ' ', $peng->peran) }}</span>
                                <span class="text-xs font-bold px-2.5 py-0.5 rounded border shadow-sm {{ $sidang->jenis_sidang == 'proposal' ? 'bg-indigo-100 text-indigo-800 border-indigo-300' : 'bg-green-100 text-green-800 border-green-300' }}">
                                    Ujian {{ strtoupper($sidang->jenis_sidang == 'proposal' ? 'Seminar Proposal' : 'Sidang Akhir') }}
                                </span>
                                @if($isDinilai)
                                    <span class="ml-2 bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded"><i class="fas fa-check-circle mr-1"></i>Sudah Mengevaluasi</span>
                                @endif
                            </div>
                            <span class="text-sm font-bold text-gray-500"><i class="fas fa-calendar-day mr-1"></i> {{ \Carbon\Carbon::parse($sidang->tanggal)->format('d M y') }}</span>
                        </div>

                        <!-- Info Mahasiswa -->
                        <div class="p-6">
                            <div class="flex items-start mb-4">
                                <div class="bg-gray-200 rounded-full h-12 w-12 flex items-center justify-center font-bold text-gray-500 text-lg flex-shrink-0">
                                    {{ substr($mhs->user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $mhs->user->name }}</h4>
                                    <p class="text-sm text-gray-500 font-mono">{{ $mhs->nim }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-5 p-3 bg-blue-50/50 rounded-lg border border-blue-100">
                                <p class="text-xs text-blue-500 font-bold uppercase mb-1">Judul Skripsi</p>
                                <p class="text-sm text-gray-800 italic font-medium leading-relaxed">"{{ $sidang->judul }}"</p>
                            </div>

                            <div class="flex items-center text-sm text-gray-600 mb-6 bg-gray-50 p-3 rounded">
                                <i class="fas fa-map-marker-alt text-red-500 w-5 text-center"></i>
                                <span class="font-medium mr-4">{{ $sidang->ruangan->nama_ruangan ?? '-' }}</span>
                                <i class="fas fa-clock text-yellow-600 w-5 text-center ml-2 border-l pl-4"></i>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($sidang->jam)->format('H:i') }} WIB</span>
                            </div>

                            <!-- Form / Hasil Nilai -->
                            @if(!$isDinilai)
                                <div x-data="{ openForm: false }">
                                    <button @click="openForm = !openForm" x-show="!openForm" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm flex items-center justify-center transition">
                                        <i class="fas fa-clipboard-check mr-2"></i> Berikan Evaluasi & Nilai
                                    </button>
                                    
                                    <div x-show="openForm" x-transition.duration.300ms class="border-t pt-4 mt-2">
                                        <form action="{{ route('sidang.evaluasi', $sidang->id) }}" method="POST">
                                            @csrf
                                            <div class="flex gap-4 mb-4">
                                                <div class="w-1/3">
                                                    <label class="block text-xs font-bold text-gray-700 mb-1">Skor/Nilai (0-100)</label>
                                                    <input type="number" name="nilai" min="0" max="100" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center font-bold text-xl py-2" required placeholder="85">
                                                </div>
                                                <div class="w-2/3">
                                                    <label class="block text-xs font-bold text-gray-700 mb-1">Putusan Kelulusan Sidang</label>
                                                    <select name="status" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 py-3 font-semibold text-sm" required>
                                                        <option value="">-- Tentukan Hasil --</option>
                                                        <option value="lulus" class="text-green-600 font-bold">LULUS MURNI (ACC)</option>
                                                        <option value="revisi" class="text-yellow-600 font-bold">LULUS BERSYARAT (Ada Revisi)</option>
                                                        <option value="mengulang" class="text-red-700 font-bold bg-red-50">❌ TIDAK LULUS (Sidang Gagal / Wajib Mengulang)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Ujian / Arahan Revisi Terakhir</label>
                                                <textarea name="catatan" rows="3" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Opsional namun disarankan. Tuliskan revisi akhir sebelum dijilid..."></textarea>
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" @click="openForm = false" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-sm transition">Batal</button>
                                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow text-sm transition"><i class="fas fa-save mr-1"></i> Simpan Penilaian Permanen</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <h4 class="text-sm font-bold text-green-800 uppercase mb-3 flex items-center"><i class="fas fa-shield-check mr-2 text-lg"></i> Skor Ujian Telah Tersimpan</h4>
                                    <div class="flex items-center justify-between mb-3 bg-white p-3 rounded-lg border border-green-100">
                                        <div class="text-gray-500 text-sm font-medium">Beban Skor Total</div>
                                        <div class="text-2xl font-black text-gray-800">{{ $nilaiAnda->nilai }}</div>
                                    </div>
                                    <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-green-100">
                                        <div class="text-gray-500 text-sm font-medium">Putusan Sidang</div>
                                        <div class="text-sm font-bold {{ $nilaiAnda->status == 'revisi' ? 'text-yellow-600' : ($nilaiAnda->status == 'lulus' ? 'text-green-600' : 'text-red-600') }} uppercase">{{ $nilaiAnda->status }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 py-10">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-10 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                                <i class="fas fa-bed text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-700">Waktu Lengang</h3>
                            <p class="text-gray-500 mt-2 max-w-md mx-auto">Saat ini Anda tidak memiliki jadwal tugas menguji sidang dari pihak Admin Prodi. Silakan bersantai.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            
        </div>
    </div>
</x-app-layout>
