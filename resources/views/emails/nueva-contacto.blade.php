<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva solicitud de contacto</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: #ede8ec;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
            padding: 32px 16px;
            color: #2d1f28;
        }

        .wrapper {
            max-width: 540px;
            margin: 0 auto;
        }

        /* ── Header ── */
        .header {
            background: linear-gradient(150deg, #8d3a6d 0%, #4a1f3d 100%);
            border-radius: 12px 12px 0 0;
            padding: 32px 32px 28px;
        }

        .header-pill {
            display: inline-block;
            background: rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.95);
            border: 1px solid rgba(255,255,255,0.28);
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1.2px;
            padding: 4px 12px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .header h1 {
            color: #fff;
            font-size: 1.4rem;
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .header-date {
            color: rgba(255,255,255,0.5);
            font-size: 0.78rem;
            letter-spacing: 0.3px;
        }

        /* ── Body ── */
        .body {
            background: #ffffff;
            border-left: 1px solid #e0d8de;
            border-right: 1px solid #e0d8de;
        }

        /* ── Section ── */
        .section {
            padding: 22px 32px;
        }

        .section + .section {
            border-top: 1px solid #f0e8ee;
        }

        .section-title {
            font-size: 0.67rem;
            font-weight: 700;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: #c09ab0;
            margin-bottom: 16px;
        }

        /* ── Row ── */
        .row {
            display: flex;
            padding: 9px 0;
            border-bottom: 1px solid #f5f0f4;
            align-items: baseline;
            gap: 12px;
        }

        .row:last-child { border-bottom: none; }

        .row-label {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.4px;
            color: #c09ab0;
            text-transform: uppercase;
            min-width: 82px;
            flex-shrink: 0;
        }

        .row-value {
            font-size: 0.9rem;
            color: #2d1f28;
            line-height: 1.55;
        }

        .row-value.mensaje {
            color: #4a3545;
            line-height: 1.65;
        }

        /* ── CTA ── */
        .cta-section {
            padding: 22px 32px;
            background: #fdf8fc;
            border-top: 1px solid #f0e8ee;
            text-align: center;
        }

        .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #8d3a6d, #4a1f3d);
            color: #ffffff !important;
            text-decoration: none !important;
            padding: 12px 32px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* ── Footer ── */
        .footer {
            background: #3a2535;
            border-radius: 0 0 12px 12px;
            padding: 22px 32px;
            text-align: center;
        }

        .footer-brand {
            color: rgba(255,255,255,0.85);
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            margin-bottom: 6px;
        }

        .footer-text {
            color: rgba(255,255,255,0.38);
            font-size: 0.75rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header -->
        <div class="header">
            <div class="header-pill">● Nuevo mensaje</div>
            <h1>Nueva solicitud<br>de contacto</h1>
            <div class="header-date">{{ now()->format('d/m/Y \a \l\a\s H:i') }}</div>
        </div>

        <!-- Body -->
        <div class="body">

            <!-- Remitente -->
            <div class="section">
                <div class="section-title">Remitente</div>
                <div class="row">
                    <div class="row-label">Nombre</div>
                    <div class="row-value">{{ $formulario->nombre_completo }}</div>
                </div>
                <div class="row">
                    <div class="row-label">Correo</div>
                    <div class="row-value">{{ $formulario->correo }}</div>
                </div>
                <div class="row">
                    <div class="row-label">Teléfono</div>
                    <div class="row-value">{{ $formulario->numero_telefonico ?? '—' }}</div>
                </div>
            </div>

            <!-- Mensaje -->
            <div class="section">
                <div class="section-title">Mensaje</div>
                <div class="row">
                    <div class="row-label">Asunto</div>
                    <div class="row-value">{{ $formulario->asunto }}</div>
                </div>
                <div class="row">
                    <div class="row-label">Texto</div>
                    <div class="row-value mensaje">{{ $formulario->mensaje }}</div>
                </div>
            </div>

            <!-- CTA -->
            <div class="cta-section">
                <a href="{{ url('/admin/forms') }}" class="cta-btn">Ver en el panel</a>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-brand">Ajal-Lol</div>
            <div class="footer-text">
                Este correo fue generado automáticamente por el sistema Ajal-Lol.<br>
                {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

    </div>
</body>
</html>