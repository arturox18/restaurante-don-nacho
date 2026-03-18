<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comanda - {{ $orden->mesa->nombre }}</title>
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
        .bold { font-weight: bold; }
        .line { border-bottom: 2px dashed #000; margin: 10px 0; }
        .mesa-title { font-size: 22px; border: 2px solid #000; padding: 5px; margin: 10px 0; }
        
        /* CORRECCIÓN DEFINITIVA DE LA NOTA */
        .nota { 
            font-size: 13px; 
            font-style: italic; 
            margin-top: 4px; 
            border: 1px dashed #000; 
            padding: 4px; 
            display: block; 
            width: 94%; /* <-- TRUCO: Le damos un margen de respiración derecho */
            box-sizing: border-box; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            background-color: #f9f9f9;
        }
        
        table { 
            width: 100%; 
            text-align: left; 
            border-collapse: collapse; 
            table-layout: fixed; 
        }
        th, td {
            word-wrap: break-word; 
            overflow-wrap: break-word;
        }
        
        /* --- ESTILOS ESTRICTOS PARA POS-58 --- */
        @media print {
            @page {
                margin: 0; 
                /* Quitamos el size para que el driver de Windows no pelee con el navegador */
            }
            html, body {
                height: auto !important; 
                margin: 0 !important;
                padding: 0 !important;
                /* El secreto: el área imprimible es de 48mm, no de 58mm */
                width: 48mm !important; 
                max-width: 48mm !important; 
                overflow: hidden; /* Corta cualquier cosa invisible que empuje el ancho */
            }
            table {
                width: 48mm !important;
                max-width: 48mm !important;
            }
            .mesa-title { font-size: 18px; }
            .txt-cantidad { font-size: 18px !important; }
            .txt-platillo { font-size: 14px !important; line-height: 1.2; display: block; }
            .txt-encabezado { font-size: 13px !important; }
            
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="text-center">
        <h2 class="bold" style="margin: 0; font-size: 18px;">PEDIDO COCINA</h2>
        <p style="margin: 5px 0; font-size: 13px;">{{ date('d/m/Y h:i A') }}</p>
    </div>

    <div class="text-center mesa-title bold">
        Mesa: {{ mb_strtoupper($orden->mesa->nombre) }}
    </div>

    <div style="font-size: 13px; margin-bottom: 10px;">
        <span class="bold">Mesero:</span> {{ $orden->usuario->name }}<br>
        <span class="bold">Folio:</span> #{{ $orden->id }}
    </div>

    <div class="line"></div>

    <table>
        <thead>
            <tr>
                <th class="txt-encabezado" style="width: 22%; border-bottom: 1px solid #000; padding-bottom: 5px; white-space: nowrap; text-align: center;">CANT</th>
                <th class="txt-encabezado" style="width: 78%; border-bottom: 1px solid #000; padding-bottom: 5px;">PLATILLO</th>
            </tr>
        </thead>
        <tbody>
            @if($detallesNuevos->isEmpty())
                <tr>
                    <td colspan="2" style="text-align: center; padding: 15px 0; font-size: 13px; font-weight: bold;">
                        No hay platillos nuevos por preparar.
                    </td>
                </tr>
            @else
                @foreach($detallesNuevos as $detalle)
                <tr>
                    <td class="txt-cantidad" style="vertical-align: top; font-weight: bold; padding-top: 8px;">
                        {{ $detalle->cantidad }}
                    </td>
                    <td style="padding-top: 8px; padding-bottom: 8px;">
                        <span class="txt-platillo" style="font-weight: bold;">
                            {{ mb_strtoupper($detalle->producto->nombre) }}
                        </span>
                        @if($detalle->notas)
                            <div class="nota">** {{ mb_strtoupper($detalle->notas) }} **</div>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="line"></div>
    <div class="text-center" style="font-size: 13px; margin-top: 10px;">
        -- Fin del pedido --
    </div>

    <div class="text-center no-print" style="margin-top: 40px;">
        <button onclick="window.print()" style="width: 100%; padding: 12px; font-size: 16px; cursor: pointer; font-weight: bold; background: #4CAF50; color: white; border: none; border-radius: 8px; margin-bottom: 15px;">
            🖨️ Imprimir Comanda
        </button>
        <button onclick="window.close()" style="width: 100%; padding: 10px; font-size: 16px; cursor: pointer; border: 2px solid #ccc; background: white; border-radius: 8px;">
            Cerrar Pestaña
        </button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>