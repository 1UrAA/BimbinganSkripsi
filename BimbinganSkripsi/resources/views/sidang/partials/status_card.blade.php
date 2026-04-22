@if($sidangModel->status === 'diajukan')
    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 flex items-start">
        <i class="fas fa-clock text-yellow-500 mt-1 mr-3 text-lg"></i>
        <div>
            <p class="font-bold text-yellow-800">Menunggu Jadwal dari Prodi</p>
            <p class="text-sm text-yellow-600 mt-1">Berkas sedang diproses oleh Admin Prodi, menantikan plotting ruangan dan Dosen Penguji.</p>
        </div>
    </div>
@elseif($sidangModel->status === 'terjadwal')
    <div class="bg-blue-50 p-5 rounded-lg border border-blue-200">
        <div class="flex items-center justify-between mb-4 pb-4 border-b border-blue-100">
            <div>
                <p class="text-blue-800 font-bold uppercase"><i class="fas fa-calendar-check mr-2"></i> Jadwal Resmi Keluar</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-blue-900">{{ \Carbon\Carbon::parse($sidangModel->tanggal)->format('d M Y') }}</p>
                <p class="text-sm text-blue-700">{{ \Carbon\Carbon::parse($sidangModel->jam)->format('H:i') }} WIB</p>
            </div>
        </div>
        <div class="mb-4">
            <p class="text-xs text-blue-400 uppercase font-bold">Lokasi / Ruangan</p>
            <p class="font-bold text-gray-800"><i class="fas fa-map-marker-alt text-red-500 mr-2"></i> {{ $sidangModel->ruangan->nama_ruangan }}</p>
            <p class="text-sm text-gray-500 ml-5">{{ $sidangModel->ruangan->lokasi }}</p>
        </div>
        <div>
            <p class="text-xs text-blue-400 uppercase font-bold mb-2">Dewan Penguji Ujian Ini</p>
            <ul class="space-y-2">
                @foreach($sidangModel->pengujis as $idx => $peng)
                <li class="flex items-center text-sm font-medium text-gray-700">
                    <span class="bg-indigo-200 text-indigo-800 w-6 h-6 rounded-full flex items-center justify-center mr-2 text-xs font-bold">P{{ $idx+1 }}</span>
                    {{ $peng->dosen->user->name }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@elseif($sidangModel->status === 'selesai')
    @php
        $adaRevisi = $sidangModel->nilai->where('status', 'revisi')->count() > 0;
        $rataNilai = $sidangModel->nilai->avg('nilai');
    @endphp
    <div class="{{ $adaRevisi ? 'bg-orange-50 border-orange-200' : 'bg-green-50 border-green-200' }} p-6 rounded-lg border text-center">
        <div class="text-5xl mb-3 {{$adaRevisi ? 'text-orange-500' : 'text-green-500'}}">
            <i class="fas {{ $adaRevisi ? 'fa-tasks' : 'fa-check-double' }}"></i>
        </div>
        <h3 class="text-xl font-bold {{$adaRevisi ? 'text-orange-800' : 'text-green-800'}}">Evaluasi Dosen Penguji Selesai</h3>
        <p class="mt-2 text-sm text-gray-600">Rata-rata Skor: <strong class="text-lg">{{ number_format($rataNilai, 1) }}</strong></p>
        
        <div class="mt-4 inline-block px-4 py-2 rounded-full font-bold text-white shadow-sm {{ $adaRevisi ? 'bg-orange-500' : 'bg-green-500' }}">
            PUTUSAN: {{ $adaRevisi ? 'DITERIMA DENGAN REVISI' : 'TUNTAS TANPA CELA' }}
        </div>
    </div>
    
    <div class="mt-4 text-left">
        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Berita Acara / Catatan Penguji:</h4>
        <ul class="space-y-3">
            @foreach($sidangModel->nilai as $nil)
            <li class="bg-white p-3 rounded-lg border text-sm shadow-sm">
                <p class="font-bold text-gray-700">{{ $nil->dosen->user->name }} 
                    <span class="italic text-gray-400 font-normal">(Skor Asli: {{ $nil->nilai }})</span>
                    <span class="float-right text-xs {{ $nil->status=='revisi' ? 'text-red-500 bg-red-100 px-2 py-0.5 rounded' : 'text-green-500 bg-green-100 px-2 py-0.5 rounded' }} font-bolduppercase">{{ strtoupper($nil->status) }}</span>
                </p>
                <div class="mt-2 p-2 bg-gray-50 rounded italic text-gray-600 text-xs border border-gray-100">
                    "{!! nl2br(e($nil->catatan)) ?: 'Tidak ada catatan tertulis.' !!}"
                </div>
            </li>
            @endforeach
        </ul>
    </div>
@elseif($sidangModel->status === 'ditolak')
    @php
        $rataNilai = $sidangModel->nilai->avg('nilai');
    @endphp
    <div class="bg-red-50 border border-red-300 p-6 rounded-lg text-center shadow-inner relative overflow-hidden">
        <div class="absolute -right-4 -top-4 opacity-10 text-red-500 text-9xl">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="text-6xl mb-4 text-red-600 relative z-10">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 class="text-2xl font-black text-red-800 uppercase tracking-wider relative z-10">STATUS UJIAN: TIDAK LULUS</h3>
        <p class="mt-2 text-sm text-red-700 font-bold relative z-10">Keputusan Dewan Penguji: <strong class="text-lg bg-red-200 px-2 py-1 rounded">TIDAK LULUS</strong></p>
        
        <div class="mt-6 text-left bg-white p-4 rounded-lg shadow-sm relative z-10 border border-red-100">
            <h4 class="text-xs font-bold text-red-500 uppercase tracking-wider mb-2">Evaluasi Dewan Penguji:</h4>
            <ul class="space-y-3">
                @foreach($sidangModel->nilai as $nil)
                <li class="border-b border-red-50 pb-2 last:border-0 last:pb-0">
                    <p class="font-bold text-gray-800 text-sm">{{ $nil->dosen->user->name }} 
                        <span class="float-right text-xs {{ $nil->status=='mengulang' ? 'text-white bg-red-600 px-2 flex items-center rounded' : ($nil->status=='revisi' ? 'text-yellow-600' : 'text-green-600') }} font-bold uppercase">{{ strtoupper($nil->status) }}</span>
                    </p>
                    <div class="mt-1 text-xs text-gray-600 italic">"{{ $nil->catatan }}"</div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
