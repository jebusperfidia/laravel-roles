<div style="text-align: center; margin-bottom: 20px;">
    <h2 class="section-header" style="border: none; text-align: center; font-size: 14px;">REPORTE FOTOGRÁFICO</h2>
    <span style="font-size: 10px; color: #666;">Folio: {{ $valuation->folio ?? '--------' }}</span>
</div>

<table style="width: 100%;">
    @foreach($photos as $index => $photo)
    @if($index % 2 == 0) <tr> @endif

        <td class="photo-cell">
            <div class="photo-frame">
                @php $path = public_path('storage/' . $photo->file_path); @endphp
                @if(file_exists($path))
                <img src="{{ $path }}" class="photo-img-inner">
                @else
                <div style="padding-top: 80px; color: red; font-size: 10px;">IMG NO DISPONIBLE</div>
                @endif
            </div>
            <div class="photo-caption uppercase">
                {{ $photo->description ?: $photo->category }}
            </div>
        </td>

        @if($index % 2 == 1)
    </tr> @endif
    @endforeach

    {{-- Cierre de celda vacía si es impar --}}
    @if(count($photos) % 2 != 0)
    <td></td>
    </tr>
    @endif
</table>
