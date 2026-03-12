<?php

namespace App\Services;

use Mpdf\Mpdf;

class BlankAttendancePdfService
{
    // ── Formato completamente en blanco ───────────────────────────────────────
    public function generate()
    {
        return $this->buildPdf(null);
    }

    // ── Con metadatos del formulario ──────────────────────────────────────────
    public function generateWithMeta(\App\Models\Report $report)
    {
        return $this->buildPdf($report);
    }

    // ── Lógica compartida ─────────────────────────────────────────────────────
    private function buildPdf(?\App\Models\Report $report)
    {
        $withMeta = $report !== null;


        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 24,
            'margin_bottom' => 18,
            'margin_left'   => 18,
            'margin_right'  => 18,
        ]);

        $mpdf->SetTitle('Formato de Asistencia - Ajal-Lol A.C.');

        $mpdf->SetHTMLHeader('
        <table width="100%" style="border-bottom:2.5px solid #783d66;padding-bottom:6px;font-family:Arial;">
            <tr>
                <td width="12%">
                    <img src="' . public_path('assets/img/logo_ajal_lol.png') . '" style="height:40px;">
                </td>
                <td width="88%" style="padding-left:12px; text-align:center;">
                    <div style="font-size:15px;font-weight:bold;color:#5a2d4d;letter-spacing:2px;text-transform:uppercase;">
                        Ajal-Lol A.C.
                    </div>
                    <div style="font-size:8px;color:#777;margin-top:2px;text-transform:uppercase;">
                        Sistema Administrativo · Registro de Asistencia
                    </div>
                </td>
            </tr>
        </table>
        ');

        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top:1px solid #e0c8d8;font-size:7px;color:#aaa;">
            <tr>
                <td style="width:25%;">Documento interno · Formato para llenar a mano</td>
                <td style="text-align:center; color:#5a2d4d; font-weight:bold;">
                    Ajal-Lol A.C. &nbsp;·&nbsp; Tel: +52 999 177 3532
                </td>
                <td style="text-align:right; width:25%;">Generado el ' . now()->format('d/m/Y') . '</td>
            </tr>
        </table>
        ');

        $style = '
        <style>
            body { font-family: Arial; font-size: 12px; }
            .section-title { background: #783d66; color: #fff; font-size: 12px; font-weight: bold; padding: 6px 10px; text-transform: uppercase; }
            .meta-box { width: 100%; border-collapse: collapse; margin-bottom: 8px; border: 1px solid #e0c8d8; }
            .meta-box td { padding: 6px 8px; border-bottom: 1px solid #f0e0ea; }
            .meta-box tr:last-child td { border-bottom: none; }
            .meta-label { font-weight: bold; color: #783d66; width: 130px; background: #fdf5fa; font-size: 12px; }
            .meta-value { font-size: 12px; color: #222; }
            .section-header { background: #783d66; color: #fff; font-size: 12px; font-weight: bold; padding: 5px 10px; text-transform: uppercase; }
            table.ben-table { width: 100%; border-collapse: collapse; }
            table.ben-table th { background: #f7edf4; color: #5a2d4d; font-size: 12px; padding: 4px; border: 1px solid #e0c8d8; }
            table.ben-table td { border: 1px solid #eedde8; height: 10mm; }
            td.num-cell { text-align: center; font-weight: bold; color: #783d66; background: #fdf0f7; width: 26px; }
        </style>
        ';

        // Metadatos: usar valores del reporte o celdas vacías
        if ($withMeta) {
            $fecha        = $report->fecha
                ? \Carbon\Carbon::parse($report->fecha)->locale('es')->isoFormat('D [de] MMMM [de] YYYY')
                : '';
            $organizacion = htmlspecialchars($report->nombre_organizacion ?? '');
            $evento       = htmlspecialchars($report->evento ?? '');
            $lugar        = htmlspecialchars($report->lugar ?? '');
        } else {
            $fecha = $organizacion = $evento = $lugar = '';
        }

        $html = $style . '

        <div class="section-title">Datos del documento</div>

        <table class="meta-box">
            <tr>
                <td class="meta-label">Organización</td>
                <td class="meta-value">' . $organizacion . '</td>
                <td class="meta-label">Fecha del evento</td>
                <td class="meta-value">' . $fecha . '</td>
            </tr>
            <tr>
                <td class="meta-label">Lugar</td>
                <td class="meta-value">' . $lugar . '</td>
                <td class="meta-label">Total asistentes</td>
                <td class="meta-value"></td>
            </tr>
            <tr>
                <td class="meta-label">Nombre del evento</td>
                <td class="meta-value" colspan="3">' . $evento . '</td>
            </tr>
        </table>

        <div class="section-header">Lista de asistencia</div>

        <table class="ben-table">
            <thead>
                <tr>
                    <th style="width:26px;">No.</th>
                    <th style="width:35%;">Nombre completo</th>
                    <th style="width:10%;">Edad</th>
                    <th>Firma de asistencia</th>
                </tr>
            </thead>
            <tbody>';

        for ($i = 1; $i <= 20; $i++) {
            $html .= '<tr>
                <td class="num-cell">' . $i . '</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
        }

        $html .= '</tbody></table>';

        $mpdf->WriteHTML($html);

        return $mpdf->Output('formato_asistencia_ajal_lol.pdf', 'S');
    }
}