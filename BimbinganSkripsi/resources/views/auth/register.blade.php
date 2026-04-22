<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" x-data="{ role: 'mahasiswa' }">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Account Role')" />
            <select id="role" name="role" x-model="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Prodi -->
        <div class="mt-4">
            <x-input-label for="prodi_id" :value="__('Program Studi')" />
            <select id="prodi_id" name="prodi_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">-- Pilih Prodi --</option>
                @foreach ($prodis ?? [] as $prodi)
                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('prodi_id')" class="mt-2" />
        </div>

        <!-- Identitas (NIM/NIDN) -->
        <div class="mt-4">
            <x-input-label for="identitas" x-text="role === 'mahasiswa' ? 'NIM' : 'NIDN'" />
            <x-text-input id="identitas" class="block mt-1 w-full" type="text" name="identitas" :value="old('identitas')" required />
            <x-input-error :messages="$errors->get('identitas')" class="mt-2" />
        </div>

        <!-- Alamat -->
        <div class="mt-4">
            <x-input-label for="alamat" :value="__('Address')" />
            <textarea id="alamat" name="alamat" rows="2" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('alamat') }}</textarea>
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
