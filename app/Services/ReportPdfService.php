<?php

namespace App\Services;

use App\Models\Report;
use Mpdf\Mpdf;

class ReportPdfService
{
    public function generate(Report $report)
    {
        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 38,
            'margin_bottom' => 28,
            'margin_left'   => 18,
            'margin_right'  => 18,
        ]);

        $mpdf->SetTitle('Informe - ' . $report->evento);

        // ── Encabezado fijo en cada página ───────────────────────────────────
        $mpdf->SetHTMLHeader('
            <table width="100%" style="border-bottom:2px solid #5a2d4d; padding-bottom:8px;">
                <tr>
                    <td width="15%" style="vertical-align:middle;">
                        <img src="' . public_path('assets/img/logo_ajal_lol.png') . '"
                             style="height:46px;">
                    </td>
                    <td width="70%" style="text-align:center; vertical-align:middle;">
                        <div style="font-size:15px; font-weight:bold; color:#5a2d4d;
                                    letter-spacing:1.5px; text-transform:uppercase;">
                            Ajal-Lol A.C.
                        </div>
                        <div style="font-size:9px; color:#555; margin-top:3px; letter-spacing:0.5px;">
                            SISTEMA ADMINISTRATIVO · INFORME DE EVENTO / ACTIVIDAD
                        </div>
                    </td>
                    <td width="15%" style="text-align:right; vertical-align:middle;
                                           font-size:8px; color:#888; line-height:1.7;">
                        Folio: INF-' . str_pad($report->id_informe, 5, '0', STR_PAD_LEFT) . '<br>
                        Fecha: ' . \Carbon\Carbon::parse($report->fecha)->format('d/m/Y') . '<br>
                        Página {PAGENO}/{nb}
                    </td>
                </tr>
            </table>
        ');

        // ── Pie de página fijo ────────────────────────────────────────────────
        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top:1px solid #c9a0bc; padding-top:6px;
                                        font-size:8px; color:#888;">
                <tr>
                    <td width="50%">Ajal-Lol A.C. · Documento de uso interno</td>
                    <td width="50%" style="text-align:right;">
                        Generado el ' . now()->format('d/m/Y \a \l\a\s H:i') . ' hrs
                        &nbsp;|&nbsp; Página {PAGENO} de {nb}
                    </td>
                </tr>
            </table>
        ');

        // ── Estilos ───────────────────────────────────────────────────────────
        $style = '
        <style>
            * { box-sizing: border-box; }

            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 11px;
                color: #222;
                line-height: 1.5;
            }

            /* ── Caja de metadatos ── */
            .meta-box {
                border: 1px solid #d4a8c7;
                border-radius: 6px;
                padding: 10px 16px;
                margin-bottom: 16px;
                background-color: #fdf8fc;
            }
            .meta-box table { width:100%; border:none; margin:0; }
            .meta-box td    { border:none; padding:3px 8px; font-size:10.5px; color:#333; }
            .meta-label     { font-weight:bold; color:#5a2d4d; width:140px; }

            /* ── Título de sección ── */
            .section-title {
                font-size: 10.5px;
                font-weight: bold;
                color: #5a2d4d;
                text-transform: uppercase;
                letter-spacing: 1px;
                border-left: 4px solid #783d66;
                padding-left: 8px;
                margin: 16px 0 10px 0;
            }

            /* ── Tabla de beneficiarios ── */
            table.ben-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 10.5px;
            }
            table.ben-table thead tr {
                background-color: #783d66;
            }
            table.ben-table th {
                color: #fff;
                font-size: 9.5px;
                font-weight: bold;
                padding: 9px 10px;
                text-transform: uppercase;
                letter-spacing: 0.6px;
                border: 1px solid #5a2d4d;
                text-align: left;
            }
            table.ben-table th.center { text-align:center; }
            table.ben-table td {
                padding: 8px 10px;
                border: 1px solid #e8d0e0;
                vertical-align: middle;
                color: #333;
            }
            table.ben-table tbody tr:nth-child(odd)  { background-color:#ffffff; }
            table.ben-table tbody tr:nth-child(even) { background-color:#fdf3f8; }
            table.ben-table tbody tr:last-child td   { border-bottom:2px solid #783d66; }

            td.num-cell {
                text-align: center;
                font-weight: bold;
                color: #783d66;
                width: 36px;
            }
            td.curp-cell {
                font-family: "Courier New", Courier, monospace;
                font-size: 10px;
                letter-spacing: 0.5px;
                color: #444;
            }
            td.sign-cell {
                /* Espacio en blanco para firma manuscrita */
                min-height: 32px;
                background-color: #fdf8fc;
            }

            /* ── Resumen ── */
            .summary-box {
                margin-top: 18px;
                padding: 9px 16px;
                background-color: #fdf3f8;
                border: 1px solid #d4a8c7;
                border-radius: 6px;
                font-size: 10px;
                color: #555;
            }
            .summary-box strong { color: #5a2d4d; }

        </style>
        ';

        // ── Datos del informe ─────────────────────────────────────────────────
        $fecha        = \Carbon\Carbon::parse($report->fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
        $folio        = 'INF-' . str_pad($report->id_informe, 5, '0', STR_PAD_LEFT);
        $totalBenef   = $report->beneficiaries->count();
        $emisionFecha = now()->format('d/m/Y H:i');

        $html = $style . '

        <!-- Metadatos del informe -->
        <div class="meta-box">
            <table>
                <tr>
                    <td class="meta-label">Documento:</td>
                    <td>Informe de Evento / Actividad</td>
                    <td class="meta-label">Folio:</td>
                    <td><strong>' . $folio . '</strong></td>
                </tr>
                <tr>
                    <td class="meta-label">Organización:</td>
                    <td>' . htmlspecialchars($report->nombre_organizacion) . '</td>
                    <td class="meta-label">Fecha del evento:</td>
                    <td>' . $fecha . '</td>
                </tr>
                <tr>
                    <td class="meta-label">Evento:</td>
                    <td>' . htmlspecialchars($report->evento) . '</td>
                    <td class="meta-label">Lugar:</td>
                    <td>' . htmlspecialchars($report->lugar) . '</td>
                </tr>
                ' . ($report->numero_telefonico ? '
                <tr>
                    <td class="meta-label">Teléfono de contacto:</td>
                    <td>' . htmlspecialchars($report->numero_telefonico) . '</td>
                    <td class="meta-label">Total de beneficiarios:</td>
                    <td><strong>' . $totalBenef . '</strong></td>
                </tr>' : '
                <tr>
                    <td class="meta-label">Total de beneficiarios:</td>
                    <td colspan="3"><strong>' . $totalBenef . '</strong></td>
                </tr>') . '
            </table>
        </div>

        <!-- Beneficiarios -->
        <div class="section-title">Registro de personas beneficiarias</div>

        <table class="ben-table">
            <thead>
                <tr>
                    <th class="center" style="width:36px;">No.</th>
                    <th style="width:40%;">Nombre completo</th>
                    <th style="width:28%;">CURP</th>
                    <th style="width:32%;">Firma</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($report->beneficiaries as $i => $b) {
            $html .= '
                <tr>
                    <td class="num-cell">' . ($i + 1) . '</td>
                    <td>' . htmlspecialchars($b->nombre) . '</td>
                    <td class="curp-cell">' . htmlspecialchars($b->curp) . '</td>
                    <td class="sign-cell"></td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <!-- Resumen -->
        <div class="summary-box">
            Total de beneficiarios registrados: <strong>' . $totalBenef . '</strong>
            &nbsp;|&nbsp;
            Evento: <strong>' . htmlspecialchars($report->evento) . '</strong>
            &nbsp;|&nbsp;
            Documento emitido el <strong>' . $emisionFecha . ' hrs</strong>
        </div>

        ';

        $mpdf->WriteHTML($html);

        return $mpdf->Output('informe_' . $report->id_informe . '.pdf', 'S');
    }
}