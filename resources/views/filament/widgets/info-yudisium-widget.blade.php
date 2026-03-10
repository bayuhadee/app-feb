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
        <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 12px; align-items: flex-start;">

          {{-- Tombol 1: Biodata Wisudawan (Merah #dc2626) --}}
          <a href="{{ route('export.biodata-wisudawan') }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; column-gap: 8px; padding: 8px 16px; font-size: 14px; font-weight: 500; color: #ffffff; background-color: #dc2626; border-radius: 8px; text-decoration: none; border: none;">

            {{-- Ikon: Pastikan width/height diatur di sini --}}
            <div style="width: 20px; height: 20px; display: flex; align-items: center;">
              <x-heroicon-o-printer style="width: 100%; height: 100%;" />
            </div>
            <span>Biodata Wisudawan</span>
          </a>

          {{-- Tombol 2: Biodata Alumni (Biru #2563eb) --}}
          <a href="{{ route('export.biodata-alumni') }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; column-gap: 8px; padding: 8px 16px; font-size: 14px; font-weight: 500; color: #ffffff; background-color: #2563eb; border-radius: 8px; text-decoration: none; border: none;">

            <div style="width: 20px; height: 20px; display: flex; align-items: center;">
              <x-heroicon-o-printer style="width: 100%; height: 100%;" />
            </div>
            <span>Biodata Alumni</span>
          </a>

          {{-- Tombol 3: Biodata Vandel (Kuning/Amber #f59e0b) --}}
          <a href="{{ route('export.biodata-vandel') }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; column-gap: 8px; padding: 8px 16px; font-size: 14px; font-weight: 500; color: #ffffff; background-color: #d97706; border-radius: 8px; text-decoration: none; border: none;">

            <div style="width: 20px; height: 20px; display: flex; align-items: center;">
              <x-heroicon-o-printer style="width: 100%; height: 100%;" />
            </div>
            <span>Biodata Vandel</span>
          </a>

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
