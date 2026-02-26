<?php

namespace App\Services;

use Mpdf\Mpdf;

class FormPdfService
{
    public function generate($forms)
    {
        $mpdf = new Mpdf([
            'margin_left'   => 18,
            'margin_right'  => 18,
            'margin_top'    => 38,
            'margin_bottom' => 28,
            'format'        => 'A4',
        ]);

        // ── Encabezado repetido en cada página ──────────────────────────────
        $mpdf->SetHTMLHeader('
            <table width="100%" style="border-bottom: 2px solid #b71c50; padding-bottom: 8px; margin-bottom: 0;">
                <tr>
                    <td width="15%" style="vertical-align:middle;">
                        <img src="' . public_path('assets/img/logo_ajal_lol.png') . '"
                             style="height:48px;">
                    </td>
                    <td width="70%" style="text-align:center; vertical-align:middle;">
                        <div style="font-size:15px; font-weight:bold; color:#b71c50;
                                    letter-spacing:1.5px; text-transform:uppercase;">
                            Ajal-Lol A.C.
                        </div>
                        <div style="font-size:9px; color:#555; margin-top:2px; letter-spacing:0.5px;">
                            SISTEMA ADMINISTRATIVO · REPORTE DE FORMULARIOS DE CONTACTO
                        </div>
                    </td>
                    <td width="15%" style="text-align:right; vertical-align:middle;
                                           font-size:8px; color:#888; line-height:1.6;">
                        Folio: RPT-' . date('Ymd') . '<br>
                        Fecha: ' . date('d/m/Y') . '<br>
                        Página {PAGENO}/{nb}
                    </td>
                </tr>
            </table>
        ');

        // ── Pie de página ────────────────────────────────────────────────────
        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top: 1px solid #e0a0bb; padding-top: 6px; font-size:8px; color:#888;">
                <tr>
                    <td width="50%">Ajal-Lol A.C. · Sistema Administrativo Interno</td>
                    <td width="50%" style="text-align:right;">
                        Generado el ' . date('d/m/Y \a \l\a\s H:i') . ' hrs &nbsp;|&nbsp; Página {PAGENO} de {nb}
                    </td>
                </tr>
            </table>
        ');

        // ── Estilos ──────────────────────────────────────────────────────────
        $style = '
        <style>
            * { box-sizing: border-box; }

            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
                color: #222;
                line-height: 1.5;
            }

            /* ── Caja de metadatos superior ── */
            .meta-box {
                border: 1px solid #e8c0d0;
                border-radius: 6px;
                padding: 10px 16px;
                margin-bottom: 18px;
                background-color: #fff9fb;
            }
            .meta-box table {
                width: 100%;
                border: none;
                margin: 0;
            }
            .meta-box td {
                border: none;
                padding: 2px 8px;
                font-size: 10px;
                color: #444;
            }
            .meta-label {
                font-weight: bold;
                color: #b71c50;
                width: 120px;
            }

            /* ── Título de sección ── */
            .section-title {
                font-size: 11px;
                font-weight: bold;
                color: #b71c50;
                text-transform: uppercase;
                letter-spacing: 1px;
                border-left: 4px solid #b71c50;
                padding-left: 8px;
                margin-bottom: 10px;
            }

            /* ── Tabla principal ── */
            table.main-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 0;
                font-size: 10.5px;
            }

            table.main-table thead tr {
                background-color: #b71c50;
            }

            table.main-table th {
                color: #ffffff;
                font-size: 9.5px;
                font-weight: bold;
                padding: 9px 8px;
                text-transform: uppercase;
                letter-spacing: 0.6px;
                border: 1px solid #9c1640;
                text-align: left;
            }

            table.main-table th.center { text-align: center; }

            table.main-table td {
                padding: 8px;
                border: 1px solid #ecd0da;
                vertical-align: top;
                color: #333;
            }

            table.main-table tbody tr:nth-child(odd) {
                background-color: #ffffff;
            }
            table.main-table tbody tr:nth-child(even) {
                background-color: #fdf3f7;
            }
            table.main-table tbody tr:last-child td {
                border-bottom: 2px solid #b71c50;
            }

            td.num-cell {
                text-align: center;
                font-weight: bold;
                color: #b71c50;
                width: 30px;
            }

            td.date-cell {
                white-space: nowrap;
                color: #555;
                font-size: 10px;
            }

            td.email-cell {
                color: #1a6bb5;
                font-size: 10px;
            }

            /* ── Resumen final ── */
            .summary-box {
                margin-top: 20px;
                padding: 10px 16px;
                background-color: #fdf3f7;
                border: 1px solid #e8c0d0;
                border-radius: 6px;
                font-size: 10px;
                color: #555;
            }
            .summary-box strong {
                color: #b71c50;
            }

            /* ── Firma / validación ── */
            .signature-section {
                margin-top: 36px;
            }
            .signature-section table {
                width: 100%;
                border: none;
                margin: 0;
            }
            .signature-section td {
                border: none;
                text-align: center;
                padding: 0 20px;
                font-size: 10px;
                color: #444;
            }
            .sig-line {
                border-top: 1px solid #555;
                margin: 0 auto 6px auto;
                width: 160px;
            }
            .sig-label {
                font-weight: bold;
                color: #222;
            }
            .sig-sub {
                color: #888;
                font-size: 9px;
            }
        </style>
        ';

        // ── Cuerpo del documento ─────────────────────────────────────────────
        $totalRegistros = count($forms);
        $fechaGeneracion = date('d/m/Y H:i');

        $html = $style . '

        <!-- Metadatos del reporte -->
        <div class="meta-box">
            <table>
                <tr>
                    <td class="meta-label">Documento:</td>
                    <td>Reporte de Formularios de Contacto</td>
                    <td class="meta-label">Organización:</td>
                    <td>Ajal-Lol A.C.</td>
                </tr>
                <tr>
                    <td class="meta-label">Folio:</td>
                    <td>RPT-' . date('Ymd-His') . '</td>
                    <td class="meta-label">Total de registros:</td>
                    <td><strong>' . $totalRegistros . '</strong></td>
                </tr>
                <tr>
                    <td class="meta-label">Fecha de emisión:</td>
                    <td>' . date('d \d\e F \d\e Y', time()) . '</td>
                    <td class="meta-label">Generado a las:</td>
                    <td>' . date('H:i') . ' hrs</td>
                </tr>
            </table>
        </div>

        <!-- Título de sección -->
        <div class="section-title">Listado de solicitudes recibidas</div>

        <!-- Tabla principal -->
        <table class="main-table">
            <thead>
                <tr>
                    <th class="center" style="width:30px;">No.</th>
                    <th style="width:17%;">Nombre completo</th>
                    <th style="width:20%;">Correo electrónico</th>
                    <th style="width:12%;">Teléfono</th>
                    <th style="width:18%;">Asunto</th>
                    <th style="width:22%;">Mensaje</th>
                    <th style="width:11%;">Fecha de envío</th>
                </tr>
            </thead>
            <tbody>';

        $counter = 1;
        foreach ($forms as $form) {
            $fecha    = date('d/m/Y H:i', strtotime($form->fecha_envio));
            $telefono = $form->numero_telefonico ?? 'N/A';
            $mensaje  = mb_strlen($form->mensaje) > 120
                        ? mb_substr($form->mensaje, 0, 120) . '…'
                        : $form->mensaje;

            $html .= '
                <tr>
                    <td class="num-cell">' . $counter . '</td>
                    <td>' . htmlspecialchars($form->nombre_completo) . '</td>
                    <td class="email-cell">' . htmlspecialchars($form->correo) . '</td>
                    <td>' . htmlspecialchars($telefono) . '</td>
                    <td>' . htmlspecialchars($form->asunto) . '</td>
                    <td style="font-size:9.5px;color:#444;">' . htmlspecialchars($mensaje) . '</td>
                    <td class="date-cell">' . $fecha . '</td>
                </tr>';
            $counter++;
        }

        $html .= '
            </tbody>
        </table>

        <!-- Resumen -->
        <div class="summary-box">
            Total de registros en este reporte: <strong>' . $totalRegistros . '</strong> &nbsp;|&nbsp;
            Período: desde <strong>' . ($forms->min('fecha_envio') ? date('d/m/Y', strtotime($forms->min('fecha_envio'))) : '—') . '</strong>
            hasta <strong>' . ($forms->max('fecha_envio') ? date('d/m/Y', strtotime($forms->max('fecha_envio'))) : '—') . '</strong> &nbsp;|&nbsp;
            Documento emitido el <strong>' . $fechaGeneracion . ' hrs</strong>
        </div>

        <!-- Sección de firmas -->
        <div class="signature-section">
            <table>
                <tr>
                    <td>
                        <div class="sig-line"></div>
                        <div class="sig-label">Elaboró</div>
                        <div class="sig-sub">Administrador del Sistema</div>
                    </td>
                    <td>
                        <div class="sig-line"></div>
                        <div class="sig-label">Revisó</div>
                        <div class="sig-sub">Coordinación General</div>
                    </td>
                    <td>
                        <div class="sig-line"></div>
                        <div class="sig-label">Autorizó</div>
                        <div class="sig-sub">Dirección · Ajal-Lol A.C.</div>
                    </td>
                </tr>
            </table>
        </div>
        ';

        $mpdf->WriteHTML($html);
        return $mpdf;
    }
}