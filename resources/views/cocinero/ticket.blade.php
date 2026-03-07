<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comanda - {{ $orden->mesa->nombre }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            max-width: 300px; /* Ancho impresora térmica */
            margin: 0 auto;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-bottom: 2px dashed #000; margin: 15px 0; }
        .mesa-title { font-size: 26px; border: 2px solid #000; padding: 5px; margin: 10px 0; }
        .nota { font-size: 15px; font-style: italic; margin-top: 3px; border: 1px dotted #000; padding: 3px; display: inline-block; }
        
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 class="bold" style="margin: 0; font-size: 22px;">PEDIDO COCINA</h2>
        <p style="margin: 5px 0;">{{ date('d/m/Y h:i A') }}</p>
    </div>

    <div class="text-center mesa-title bold">
        {{ mb_strtoupper($orden->mesa->nombre) }}
    </div>

    <div style="font-size: 15px;">
        <span class="bold">Mesero:</span> {{ $orden->usuario->name }}<br>
        <span class="bold">Folio:</span> #{{ $orden->id }}
    </div>

    <div class="line"></div>

    <table style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="width: 20%; font-size: 18px; border-bottom: 1px solid #000;">CANT</th>
                <th style="width: 80%; font-size: 18px; border-bottom: 1px solid #000;">PLATILLO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orden->detalles as $detalle)
            <tr>
                <td style="vertical-align: top; font-weight: bold; font-size: 24px; padding-top: 10px;">
                    {{ $detalle->cantidad }}
                </td>
                <td style="padding-top: 10px; padding-bottom: 10px;">
                    <span style="font-weight: bold; font-size: 18px; display: block;">
                        {{ mb_strtoupper($detalle->producto->nombre) }}
                    </span>
                    @if($detalle->notas)
                        <div class="nota">** {{ mb_strtoupper($detalle->notas) }} **</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="line"></div>
    <div class="text-center" style="font-size: 14px;">
        -- Fin del pedido --
    </div>

    <div class="text-center no-print" style="margin-top: 40px;">
        <button onclick="window.print()" style="padding: 12px 24px; font-size: 18px; cursor: pointer; font-weight: bold; background: #4CAF50; color: white; border: none; border-radius: 5px;">🖨️ Imprimir Comanda</button>
        <br><br>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; border: 1px solid #ccc; border-radius: 5px;">Cerrar Pestaña</button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>