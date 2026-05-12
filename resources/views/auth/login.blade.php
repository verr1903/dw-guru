<x-layout-auth title="Login — SMA Cendana Pekanbaru">

    <div class="w-full max-w-md card-enter">

        {{-- Heading --}}
        <div class="mb-6 text-center">
            <h1 class="font-display text-3xl tracking-tight text-slate-800">
                SMA CENDANA PEKANBARU
            </h1>
            <p class="mt-1 text-sm text-slate-500">Silahkan masuk ke akun Anda</p>
        </div>

        {{-- Card --}}
        <div class="glass-card overflow-hidden rounded-2xl shadow-xl ring-1 ring-slate-200/70">

            {{-- Shimmer bar --}}
            <div class="card-top-bar h-[3px] w-full"></div>

            <div class="px-8 py-12">

                {{-- Error --}}
                @if ($errors->any())
                <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                        class="mt-0.5 h-5 w-5 shrink-0 text-red-500">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75
                             0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Status --}}
                @if (session('status'))
                <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-[#8b6b1f]">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="mb-1.5 block text-sm font-medium text-slate-700">
                            Nama Pengguna
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                    <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957
                                             9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002
                                             7.002 0 0 0-13.074.003Z" />
                                </svg>
                            </span>
                            <input id="username" name="username" type="text"
                                value="{{ old('username') }}"
                                autocomplete="username" required
                                placeholder="Masukkan nama pengguna"
                                class="input-field w-full rounded-xl border border-slate-200 bg-white/70 py-3 pl-11 pr-4
                                       text-sm text-slate-800 placeholder-slate-400
                                       @error('username') border-red-400 bg-red-50 @enderror">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3.5 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                    <path fill-rule="evenodd" d="M8 7a5 5 0 0 1 9.192-2.706l1.6 1.6a.75.75 0 0 1 0 1.06l-1.414
                                             1.414a.75.75 0 0 1-1.06 0l-1.6-1.6A3.5 3.5 0 0 0 9.5 10a.75.75 0 0 1-.75.75H7a.75.75
                                             0 0 1-.75-.75V9h-.5a.75.75 0 0 1-.75-.75V7H4a.75.75 0 0 1-.75-.75V5.25C3.25 4.56 3.81
                                             4 4.5 4h1.586a.75.75 0 0 1 .53.22L8 6.086V7Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input id="password" name="password" type="password"
                                autocomplete="current-password" required
                                placeholder="Masukkan kata sandi"
                                class="input-field w-full rounded-xl border border-slate-200 bg-white/70 py-3 pl-11 pr-12
                                       text-sm text-slate-800 placeholder-slate-400
                                       @error('password') border-red-400 bg-red-50 @enderror">

                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257
                                             0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257
                                             0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                                </svg>
                                <svg id="eyeClose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-5 w-5 hidden">
                                    <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0
                                         1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004
                                         10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5
                                         2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                                    <path d="M10.748 13.93l2.523 2.523a10.285 10.285 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651
                                             1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex cursor-pointer items-center gap-2 select-none">
                            <input type="checkbox" name="remember" id="remember"
                                class="h-4 w-4 rounded border-slate-300 text-[#b68b2c] focus:ring-[#b68b2c] focus:ring-offset-0">
                            <span class="text-sm text-slate-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm font-medium text-black hover:text-[#8b6b1f] transition-colors">
                            Lupa kata sandi?
                        </a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="mt-2 flex w-full items-center justify-center gap-2 rounded-xl
                               bg-black py-3 text-sm font-semibold text-white
                               shadow-md shadow-black/20 transition-all
                               hover:bg-[#4b1b17f8] active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0
                                 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0
                                 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-1.08a.75.75 0 1 0-1.04-1.08l-2.5
                                 2.57a.75.75 0 0 0 0 1.08l2.5 2.57a.75.75 0 1 0 1.04-1.08l-1.047-1.08H18.25A.75.75 0 0 0 19 10Z"
                                clip-rule="evenodd" />
                        </svg>
                        Masuk
                    </button>
                </form>

            </div>
        </div>

        <p class="mt-5 text-center text-xs text-slate-400">
            Untuk bantuan login, hubungi tata usaha sekolah.
        </p>
    </div>

</x-layout-auth>

@push('scripts')

@endpush