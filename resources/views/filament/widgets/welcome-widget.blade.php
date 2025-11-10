<x-filament-widgets::widget>
  <div class="w-full mb-2">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
      <div class="flex flex-col md:flex-row items-end">
        <div class="w-full md:w-2/3">
          <div class="p-6">
            <p class="text-sm text-gray-500 dark:text-gray-200 mb-3">
              Pendaftaran Yudisium FE Universitas Warmadewa
            </p>
            <h5 class="text-xl font-semibold mb-3 text-black dark:text-white">
              Selamat datang, {{ auth()->user()->name }}
            </h5>
            <p class="text-gray-500 dark:text-gray-200 text-sm leading-relaxed">
              Dashboard ini digunakan untuk melakukan dan memantau status pendaftaran yudisium Anda. Mohon periksa kembali data akademik sebelum melanjutkan.
            </p>

            <div class="flex space-x-2 mt-4">
              @if (!Auth::user()?->mahasiswa?->yudisium)
                <x-filament::button color="primary" icon="heroicon-o-book-open" href="{{ route('filament.admin.pages.daftar-yudisium') }}" tag="a">
                  Daftar Yudisium
                </x-filament::button>
              @endif

              <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                @csrf
                <x-filament::button color="gray" icon="heroicon-o-arrow-left-start-on-rectangle" type="submit">
                  Keluar
                </x-filament::button>
              </form>
            </div>
          </div>
        </div>
        <div class="w-full md:w-1/3 justify-center md:justify-end hidden md:flex">
          <img src="{{ asset('assets/images/Frame 61.png') }}" alt="pura" class="h-[200px] w-auto object-contain" />
        </div>
      </div>
    </div>
  </div>
</x-filament-widgets::widget>
