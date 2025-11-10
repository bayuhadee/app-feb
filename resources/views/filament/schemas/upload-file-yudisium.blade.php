<x-filament::section>
  <div class="max-w-5xl mx-auto">

    <h2 class="text-xl font-semibold mb-4">Persyaratan Yudisium</h2>

    <div class="overflow-x-auto rounded-lg border border-gray-300">
      <table class="min-w-max w-full text-sm border-collapse">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="border-b border-r border-gray-300 p-2 w-10 text-center">No</th>
            <th class="border-b border-r border-gray-300 p-2">Persyaratan</th>
            <th class="border-b border-r border-gray-300 p-2 w-48 text-center">Upload File</th>
            <th class="border-b border-gray-300 p-2 w-40 text-center">Tampilkan File</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($requirements as $i => $item)
            @php
              $isLast = $i === count($requirements) - 1;
              $rowBorder = $isLast ? '' : 'border-b';
            @endphp
            <tr>
              <td class="{{ $rowBorder }} border-r border-gray-300 p-2 text-center">{{ $i + 1 }}</td>
              <td class="{{ $rowBorder }} border-r border-gray-300 p-2 text-wrap">{{ $item['label'] }}
                @isset($item['note'])
                  <br />
                  <span class="text-xs text-gray-500">{{ $item['note'] }}</span>
                @endisset
                @isset($item['contoh'])
                  <br />
                  {{ ($this->showContoh)([
                      'field' => $item['contoh'],
                      'label' => $item['label'],
                  ]) }}
                @endisset
              </td>

              <td class="{{ $rowBorder }} border-r border-gray-300 p-2 text-center">
                {{ ($this->uploadFile)([
                    'field' => $item['field'],
                    'label' => $item['label'],
                    'accept' => $item['accept'],
                ]) }}
              </td>

              <td class="{{ $rowBorder }} border-gray-300 p-2 text-center">
                @if ($yudisium && $yudisium[$item['field']])
                  {{ ($this->showFile)([
                      'field' => $item['field'],
                      'label' => $item['label'],
                  ]) }}
                @else
                  <span class="text-gray-400 text-xs italic">Belum ada</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</x-filament::section>
