<aside :class="sidebarOpen ? 'translate-x-0 lg:w-64 w-64' : '-translate-x-full lg:translate-x-0 lg:w-20 w-0'" class="absolute z-40 flex flex-col h-screen px-4 py-8 overflow-y-auto bg-gray-900 border-r dark:bg-gray-900 dark:border-gray-700 transition-all duration-300 inset-y-0 left-0 lg:static fixed shadow-2xl lg:shadow-none min-w-[5rem] overflow-hidden">
    <div class="flex items-center justify-center flex-shrink-0 relative">
        <h2 class="text-2xl font-bold text-white whitespace-nowrap overflow-hidden transition-all duration-300" x-show="sidebarOpen">SKRIPSI<span class="text-blue-500">PRO</span></h2>
        <!-- Simple icon when collapsed on desktop -->
        <h2 class="text-2xl font-extrabold text-blue-500 absolute" x-show="!sidebarOpen"><i class="fas fa-graduation-cap"></i></h2>
    </div>

    <div class="flex flex-col justify-between flex-1 mt-8">
        <nav class="space-y-3">
            
            <a class="flex items-center px-4 py-3 text-gray-200 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-md' : '' }}" href="{{ route('dashboard') }}" title="Dashboard">
                <i class="fas fa-home w-5 text-center text-lg"></i>
                <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Dashboard</span>
            </a>

            <!-- MAHASISWA & DOSEN MENU -->
            @if(Auth::user() && in_array(Auth::user()->role, ['mahasiswa', 'dosen']))
            <a class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('skripsi.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('skripsi.index') }}" title="Skripsi Saya">
                <i class="fas fa-book-open w-5 text-center text-lg"></i>
                <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Skripsi Saya</span>
            </a>
            <a class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('bimbingan.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('bimbingan.index') }}" title="Bimbingan">
                <i class="fas fa-comments w-5 text-center text-lg"></i>
                <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Bimbingan</span>
            </a>
            @endif

            <!-- ADMIN PRODI & SUPERADMIN MENU -->
            @if(Auth::user() && in_array(Auth::user()->role, ['superadmin', 'admin_prodi']))
            <div class="pt-4 mt-4 border-t border-gray-700">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap" x-show="sidebarOpen">Manajemen Data</p>
                <a class="flex items-center px-4 py-3 mt-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('mahasiswa.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('mahasiswa.index') }}" title="Mahasiswa">
                    <i class="fas fa-user-graduate w-5 text-center text-lg"></i>
                    <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Data Mahasiswa</span>
                </a>
                <a class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('dosen.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('dosen.index') }}" title="Dosen">
                    <i class="fas fa-chalkboard-teacher w-5 text-center text-lg"></i>
                    <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Data Dosen</span>
                </a>
            </div>
            @endif

            <!-- SIDANG MENU -->
            @if(Auth::user() && in_array(Auth::user()->role, ['mahasiswa', 'dosen', 'admin_prodi']))
            <div class="pt-4 mt-4 border-t border-gray-700">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap" x-show="sidebarOpen">Ujian Akhir</p>
                @if(in_array(Auth::user()->role, ['mahasiswa', 'dosen']))
                <a class="flex items-center px-4 py-3 mt-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('sidang.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('sidang.index') }}" title="Sidang Skripsi">
                    <i class="fas fa-gavel w-5 text-center text-lg"></i>
                    <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Sidang Skripsi</span>
                </a>
                @elseif(Auth::user()->role === 'admin_prodi')
                <a class="flex items-center px-4 py-3 mt-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('admin.sidang.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('admin.sidang.index') }}" title="Jadwal Sidang">
                    <i class="fas fa-gavel w-5 text-center text-lg"></i>
                    <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Plot Jadwal Sidang</span>
                </a>
                @endif
            </div>
            @endif

            <!-- EXCLUSIVE SUPERADMIN -->
            @if(Auth::user() && Auth::user()->role === 'superadmin')
            <div class="pt-4 mt-4 border-t border-gray-700">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap" x-show="sidebarOpen">Konfigurasi</p>
                <a class="flex items-center px-4 py-3 mt-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('prodi.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('prodi.index') }}" title="Program Studi">
                    <i class="fas fa-university w-5 text-center text-lg"></i>
                    <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Program Studi</span>
                </a>
                <a class="flex items-center px-4 py-3 text-gray-300 rounded-lg transition-colors hover:bg-gray-800 hover:text-white {{ request()->routeIs('akun_admin.*') ? 'bg-gray-800 text-white border-l-4 border-blue-500' : '' }}" href="{{ route('akun_admin.index') }}" title="Kelola Admin">
                    <i class="fas fa-user-shield w-5 text-center text-lg"></i>
                    <span class="mx-4 font-medium whitespace-nowrap transition-opacity duration-300" x-show="sidebarOpen">Kelola Admin</span>
                </a>
            </div>
            @endif
        </nav>
        
        <!-- Bottom Role Card -->
        <div class="mt-8 transition-opacity duration-300 flex-shrink-0" x-show="sidebarOpen">
            <div class="p-4 bg-gray-800 rounded-xl flex items-center shadow-inner">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white">
                    <i class="fas fa-user"></i>
                </div>
                <div class="ml-3">
                    <h2 class="text-sm font-bold text-white">{{ Auth::user()->name }}</h2>
                    <p class="text-xs text-indigo-300 uppercase tracking-wide font-semibold mt-1">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>
