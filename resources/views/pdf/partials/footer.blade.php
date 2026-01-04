<footer>
    {{-- 1. IMAGEN DE FONDO --}}
    <img src="{{ public_path('assets/img/pdf/logo_footer.png') }}" class="footer-bg">

    {{-- 2. BLOQUE IZQUIERDO (Folio y Teléfonos) --}}
    {{-- SUBIMOS A 30px para librar la barra verde --}}
    <div style="position: absolute; bottom: 30px; left: 20px; width: 40%;">

        {{-- Folio --}}
        <div style="font-size: 10px; color: #666; margin-bottom: 2px;">
            Avalúo {{ $valuation->folio ?? 'S/N' }}
        </div>

        {{-- Teléfonos --}}
        <div style="font-size: 14px; color: #555;">
            <span
                style="background-color: #25998b; color: white; border-radius: 3px; padding: 1px 4px; font-weight: bold; font-size: 8px; margin-right: 3px;">
                TEL
            </span>
            <span style="font-weight: bold; color: #666;">
                55 2904 0078 <span style="color: #25998b;">|</span> 777 404 6156
            </span>
        </div>
    </div>

    {{-- 3. BLOQUE CENTRAL (Paginación) --}}
    {{-- TAMBIÉN SUBIMOS A 30px para que quede alineado con los teléfonos --}}
    <div style="position: absolute; bottom: 30px; left: 0; width: 100%; text-align: center; pointer-events: none;">
        <div style="font-size: 14px; font-weight: bold; color: #666;">
            Página <span class="page-number"></span>
        </div>
    </div>
</footer>
