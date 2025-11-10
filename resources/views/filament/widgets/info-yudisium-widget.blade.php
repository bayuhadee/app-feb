<x-filament-widgets::widget>
  <x-filament::section icon="heroicon-o-academic-cap" collapsible>
    <x-slot name="heading">
      Info Yudisium
    </x-slot>

    {{-- Content --}}
    <div class="mb-3">
      @if ($yudisium && intval($yudisium->status_verifikasi) === 3)
        <span class="text-gray-500">{{ $yudisium->keterangan }}</span>
      @elseif ($yudisium && intval($yudisium->status_verifikasi) === 2)
        <span class="text-gray-500">File yang telah anda lampirkan telah disetujui. Silahkan cetak berkas dibawah ini untuk dibawa ke panitia yudisium.</span>
        <div class="flex space-x-2 mt-3">
          <x-filament::button color="danger" icon="heroicon-o-printer" href="{{ route('export.biodata-wisudawan') }}" tag="a" target="_blank">
            Biodata Wisudawan
          </x-filament::button>
          <x-filament::button color="primary" icon="heroicon-o-printer" href="{{ route('export.biodata-alumni') }}" tag="a" target="_blank">
            Biodata Alumni
          </x-filament::button>
          <x-filament::button color="warning" icon="heroicon-o-printer" href="{{ route('export.biodata-vandel') }}" tag="a" target="_blank">
            Biodata Vandel
          </x-filament::button>
        </div>
      @elseif ($yudisium && intval($yudisium->status_verifikasi) === 1)
        <span class="text-gray-500">File akan diverifikasi terlebih dahulu. informasi selanjutnya akan dikirim melalui Whatsapp atau silahkan akses halaman ini secara berkala.</span>
      @else
        <span class="text-gray-500">Periksa kembali semua file dan pastikan semua file berhasi terupload sebelum mengirim permintaan validasi.</span>
      @endif
    </div>
    @if ($yudisium && intval($yudisium->status_verifikasi) !== 2)
      <x-filament::button color="primary" icon="heroicon-o-academic-cap" href="{{ route('filament.admin.pages.daftar-yudisium') }}" tag="a">
        Yudisium
      </x-filament::button>
    @endif
  </x-filament::section>
</x-filament-widgets::widget>
