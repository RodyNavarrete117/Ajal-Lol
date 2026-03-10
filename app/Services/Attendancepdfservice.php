<?php

namespace App\Services;

use App\Models\Report;
use Mpdf\Mpdf;

class AttendancePdfService
{
    public function generate(Report $report)
    {
        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 28,
            'margin_bottom' => 32,
            'margin_left'   => 20,
            'margin_right'  => 20,
        ]);

        $mpdf->SetTitle('Asistencia - ' . $report->evento);

        // ── Encabezado ────────────────────────────────────────────────────────
        $mpdf->SetHTMLHeader('
            <table width="100%" style="border-bottom: 3px solid #2d6a8a; padding-bottom: 10px; font-family: Arial, sans-serif;">
                <tr>
                    <td width="12%" style="vertical-align: middle;">
                        <img src="' . public_path('assets/img/logo_ajal_lol.png') . '" style="height: 50px;">
                    </td>
                    <td width="88%" style="vertical-align: middle; padding-left: 14px; text-align: center;">
                        <div style="font-size: 17px; font-weight: bold; color: #1a4a63; letter-spacing: 2px; text-transform: uppercase;">
                            Ajal-Lol A.C.
                        </div>
                        <div style="font-size: 9px; color: #777; margin-top: 3px; letter-spacing: 1px; text-transform: uppercase;">
                            Sistema Administrativo &nbsp;·&nbsp; Lista de Asistencia
                        </div>
                    </td>
                </tr>
            </table>
        ');

        // ── Pie de página ─────────────────────────────────────────────────────
        $mpdf->SetHTMLFooter('
            <table width="100%" style="border-top: 1.5px solid #c8dde8; padding-top: 7px; font-family: Arial, sans-serif; font-size: 8px; color: #999;">
                <tr>
                    <td>Ajal-Lol A.C. &nbsp;·&nbsp; Documento de uso interno &nbsp;·&nbsp; Folio: ASI-' . str_pad($report->id_informe, 5, '0', STR_PAD_LEFT) . '</td>
                    <td style="text-align: right;">Generado el ' . now()->format('d/m/Y') . ' a las ' . now()->format('H:i') . ' hrs &nbsp;|&nbsp; Página {PAGENO} de {nb}</td>
                </tr>
            </table>
        ');

        // ── Estilos ───────────────────────────────────────────────────────────
        $style = '
        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { font-family: Arial, sans-serif; font-size: 12px; color: #222; line-height: 1.6; }

            .meta-box {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 22px;
                border: 1.5px solid #c8dde8;
                border-top: 4px solid #2d6a8a;
            }
            .meta-box td {
                padding: 6px 12px;
                font-size: 12px;
                color: #333;
                border-bottom: 1px solid #e0eff5;
                vertical-align: middle;
            }
            .meta-box tr:last-child td { border-bottom: none; }
            .meta-label {
                font-weight: bold;
                color: #2d6a8a;
                width: 150px;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                background-color: #f3f8fb;
            }
            .meta-value { background-color: #fff; }

            .section-header {
                background-color: #2d6a8a;
                color: #fff;
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                padding: 8px 14px;
                margin-top: 22px;
            }

            table.ben-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }
            table.ben-table thead tr { background-color: #edf4f8; }
            table.ben-table th {
                color: #1a4a63;
                font-size: 10px;
                font-weight: bold;
                padding: 9px 11px;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                border: 1.5px solid #c8dde8;
                text-align: left;
            }
            table.ben-table th.center { text-align: center; }
            table.ben-table td {
                padding: 10px 11px;
                border: 1px solid #d8eaf2;
                vertical-align: middle;
                font-size: 12px;
                color: #2d2d2d;
            }
            table.ben-table tbody tr:nth-child(odd)  { background-color: #ffffff; }
            table.ben-table tbody tr:nth-child(even) { background-color: #f3f8fb; }
            table.ben-table tbody tr:last-child td   { border-bottom: 2px solid #2d6a8a; }

            td.num-cell {
                text-align: center;
                font-weight: bold;
                color: #2d6a8a;
                background-color: #eaf3f8;
                width: 36px;
            }
            td.age-cell { text-align: center; color: #555; }
            td.sign-cell {
                background-color: #fafcfe;
                border-bottom: 1.5px dashed #a8c8d8;
            }
        </style>
        ';

        // ── Datos ─────────────────────────────────────────────────────────────
        $personas   = $report->attendances;
        $totalAsist = $personas->count();
        $fecha      = \Carbon\Carbon::parse($report->fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY');
        $folio      = 'ASI-' . str_pad($report->id_informe, 5, '0', STR_PAD_LEFT);

        $html = $style . '

        <table class="meta-box">
            <tr>
                <td class="meta-label">Documento</td>
                <td class="meta-value">Lista de Asistencia</td>
                <td class="meta-label">Folio</td>
                <td class="meta-value"><strong>' . $folio . '</strong></td>
            </tr>
            <tr>
                <td class="meta-label">Organización</td>
                <td class="meta-value">' . htmlspecialchars($report->nombre_organizacion) . '</td>
                <td class="meta-label">Fecha del evento</td>
                <td class="meta-value">' . $fecha . '</td>
            </tr>
            <tr>
                <td class="meta-label">Evento</td>
                <td class="meta-value">' . htmlspecialchars($report->evento) . '</td>
                <td class="meta-label">Lugar</td>
                <td class="meta-value">' . htmlspecialchars($report->lugar) . '</td>
            </tr>
            ' . ($report->numero_telefonico ? '
            <tr>
                <td class="meta-label">Teléfono</td>
                <td class="meta-value">' . htmlspecialchars($report->numero_telefonico) . '</td>
                <td class="meta-label">Total asistentes</td>
                <td class="meta-value"><strong style="font-size:14px; color:#2d6a8a;">' . $totalAsist . '</strong></td>
            </tr>' : '
            <tr>
                <td class="meta-label">Total asistentes</td>
                <td class="meta-value" colspan="3"><strong style="font-size:14px; color:#2d6a8a;">' . $totalAsist . '</strong></td>
            </tr>') . '
        </table>

        <div class="section-header">Lista de asistencia</div>

        <table class="ben-table">
            <thead>
                <tr>
                    <th class="center" style="width: 36px;">No.</th>
                    <th style="width: 52%;">Nombre completo</th>
                    <th class="center" style="width: 10%;">Edad</th>
                    <th style="width: 30%;">Firma de asistencia</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($personas as $i => $p) {
            $html .= '
                <tr>
                    <td class="num-cell">' . ($i + 1) . '</td>
                    <td>' . htmlspecialchars($p->asistencianombrebeneficiario) . '</td>
                    <td class="age-cell">' . ($p->asistenciaedadbeneficiario ?? '—') . '</td>
                    <td class="sign-cell"></td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>';

        $mpdf->WriteHTML($html);

        return $mpdf->Output('asistencia_' . $report->id_informe . '.pdf', 'S');
    }
}