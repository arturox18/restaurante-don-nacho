<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - {{ $mesa->nombre }}</title>
    <style>
        /* --- ESTILOS BASE --- */
        * {
            box-sizing: border-box; 
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            max-width: 280px; 
            margin: 0 auto;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        .flex { display: flex; justify-content: space-between; align-items: center; }
        .mb-2 { margin-bottom: 5px; }
        .mt-1 { margin-top: 2px; }

        /* --- MAGIA PARA LA TABLA --- */
        table { 
            width: 100%; 
            text-align: left; 
            border-collapse: collapse; 
            table-layout: fixed; /* Obliga a no salirse del ancho */
        }
        th, td {
            word-wrap: break-word; 
            overflow-wrap: break-word;
            padding: 3px 0;
        }

        /* --- ESTILOS ESTRICTOS PARA POS-58 --- */
        @media print {
            @page {
                margin: 0; 
            }
            html, body {
                height: auto !important; 
                margin: 0 !important;
                padding: 0 !important;
                width: 48mm !important; /* El área real imprimible */
                max-width: 48mm !important; 
                overflow: hidden; 
            }
            table {
                width: 48mm !important;
                max-width: 48mm !important;
            }
            body {
                font-size: 12px; /* Letra un poco más chica para el cliente */
            }
            .no-print { 
                display: none !important; 
            }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 class="bold" style="margin: 0; font-size: 18px;">EL MESÓN DE DON NACHO</h2>
        <p style="margin: 5px 0;">Escuinapa, Sinaloa</p>
        <p style="margin: 5px 0;">{{ date('d/m/Y h:i A') }}</p>
    </div>

    <div class="line"></div>

    <div class="mb-2 text-center" style="font-size: 16px;">
        <span class="bold">MESA: {{ mb_strtoupper($mesa->nombre) }}</span>
    </div>
    
    <div class="mb-2" style="font-size: 12px;">
        <span class="bold">Atendió:</span> {{ Auth::user()->name }}<br>
        <span class="bold">Folio:</span> #{{ $orden->id }}
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th style="width: 18%; text-align: center; border-bottom: 1px solid #000; padding-bottom: 4px; white-space: nowrap;">CANT</th>
                <th style="width: 52%; text-align: left; border-bottom: 1px solid #000; padding-bottom: 4px;">PLAT</th>
                <th style="width: 30%; text-align: right; border-bottom: 1px solid #000; padding-bottom: 4px;">IMPORTE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->detalles as $detalle)
            <tr>
                <td style="vertical-align: top; text-align: center; font-weight: bold;">
                    {{ $detalle->cantidad }}
                </td>
                <td style="vertical-align: top;">
                    {{ mb_strtoupper($detalle->producto->nombre) }}
                    @if($detalle->notas)
                        <br><small style="font-style: italic; color: #333;">*{{ $detalle->notas }}*</small>
                    @endif
                </td>
                <td style="text-align: right; vertical-align: top;">
                    ${{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>

    @php
        $totalFinal = $orden->total;
        $subtotal = $totalFinal / 1.16;
        $iva = $totalFinal - $subtotal;
    @endphp

    <div style="font-size: 12px; margin: 10px 0;">
        <div class="flex mt-1 text-right">
            <span>Subtotal:</span>
            <span>${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex mt-1 text-right">
            <span>IVA (16%):</span>
            <span>${{ number_format($iva, 2) }}</span>
        </div>
    </div>

    <div class="line"></div>

    <div class="flex bold" style="font-size: 16px; margin: 10px 0;">
        <span>TOTAL:</span>
        <span>${{ number_format($totalFinal, 2) }}</span>
    </div>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 15px;">
        <p style="margin: 5px 0;">¡Gracias por su preferencia!</p>
        <p style="margin: 5px 0;">**** Vuelva pronto ****</p>
    </div>

    <div class="text-center no-print" style="margin-top: 40px;">
        <button onclick="window.print()" style="width: 100%; padding: 12px; font-size: 16px; cursor: pointer; font-weight: bold; background: #4CAF50; color: white; border: none; border-radius: 8px; margin-bottom: 15px;">
            🖨️ Imprimir Ticket
        </button>
        <button onclick="window.close()" style="width: 100%; padding: 10px; font-size: 16px; cursor: pointer; border: 2px solid #ccc; background: white; border-radius: 8px;">
            Cerrar Pestaña
        </button>
    </div>

    <script>
        // Imprimir automáticamente al cargar
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>