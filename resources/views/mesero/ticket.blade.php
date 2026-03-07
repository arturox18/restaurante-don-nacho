<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket - {{ $mesa->nombre }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            max-width: 300px; /* Ancho típico de impresora térmica */
            margin: 0 auto;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        .flex { display: flex; justify-content: space-between; }
        .mb-2 { margin-bottom: 5px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 class="bold" style="margin: 0;">EL MESÓN DE DON NACHO</h2>
        <p>Escuinapa, Sinaloa</p>
        <p>{{ date('d/m/Y h:i A') }}</p>
    </div>

    <div class="line"></div>

    <div class="mb-2">
        <span class="bold">Mesa:</span> {{ $mesa->nombre }}<br>
        <span class="bold">Atendió:</span> {{ Auth::user()->name }}<br>
        <span class="bold">Folio:</span> #{{ $orden->id }}
    </div>

    <div class="line"></div>

    <table style="width: 100%; text-align: left;">
        <thead>
            <tr>
                <th style="width: 15%">Cant</th>
                <th style="width: 55%">Desc</th>
                <th style="width: 30%; text-align: right;">Importe</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->detalles as $detalle)
            <tr>
                <td style="vertical-align: top;">{{ $detalle->cantidad }}</td>
                <td>
                    {{ $detalle->producto->nombre }}
                    @if($detalle->costo_extra > 0)
                        <br><small>(Extras: +${{ $detalle->costo_extra }})</small>
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

    <div class="flex bold" style="font-size: 18px;">
        <span>TOTAL:</span>
        <span>${{ number_format($orden->detalles->sum(fn($d) => $d->precio_unitario * $d->cantidad), 2) }}</span>
    </div>

    <div class="line"></div>

    <div class="text-center" style="margin-top: 20px;">
        <p>¡Gracias por su preferencia!</p>
        <p>**** Vuelva pronto ****</p>
    </div>

    <div class="text-center no-print" style="margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">🖨️ Imprimir otra vez</button>
        <br><br>
        <a href="{{ route('mesero.dashboard') }}" style="text-decoration: none; color: blue; font-weight: bold;">&larr; Volver al Inicio</a>
    </div>

    <script>
        // Imprimir automáticamente al cargar
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>