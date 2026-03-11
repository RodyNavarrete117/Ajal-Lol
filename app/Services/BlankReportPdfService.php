<?php

namespace App\Services;

use Mpdf\Mpdf;

class BlankReportPdfService
{
    public function generate()
    {
        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 24,
            'margin_bottom' => 15,
            'margin_left'   => 18,
            'margin_right'  => 18,
        ]);

        $mpdf->SetTitle('Formato de Informe - Ajal-Lol A.C.');

        $mpdf->SetHTMLHeader('
        <table width="100%" style="border-bottom:2.5px solid #783d66;padding-bottom:6px;font-family:Arial;">
            <tr>
                <td width="12%">
                    <img src="' . public_path('assets/img/logo_ajal_lol.png') . '" style="height:40px;">
                </td>
                <td width="88%" style="padding-left:12px;">
                    <div style="font-size:15px;font-weight:bold;color:#5a2d4d;letter-spacing:2px;text-transform:uppercase;">
                        Ajal-Lol A.C.
                    </div>
                    <div style="font-size:8px;color:#777;margin-top:2px;text-transform:uppercase;">
                        Sistema Administrativo · Informe de Evento / Actividad
                    </div>
                </td>
            </tr>
        </table>
        ');

        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top:1px solid #e0c8d8;font-size:7px;color:#aaa;">
            <tr>
                <td>Ajal-Lol A.C. · Documento interno · Formato para llenar a mano</td>
                <td style="text-align:right;">Generado el ' . now()->format('d/m/Y') . '</td>
            </tr>
        </table>
        ');

        $style = '
        <style>
            body { font-family: Arial; font-size: 10px; }

            .section-title {
                background: #783d66; color: #fff;
                font-size: 10px; font-weight: bold;
                padding: 6px 10px; text-transform: uppercase;
            }
            .meta-box {
                width: 100%; border-collapse: collapse;
                margin-bottom: 8px; border: 1px solid #e0c8d8;
            }
            .meta-box td { padding: 6px 8px; border-bottom: 1px solid #f0e0ea; }
            .meta-label {
                font-weight: bold; color: #783d66;
                width: 130px; background: #fdf5fa; font-size: 8px;
            }
            .section-header {
                background: #783d66; color: #fff;
                font-size: 9px; font-weight: bold;
                padding: 5px 10px; text-transform: uppercase;
            }
            table.ben-table { width: 100%; border-collapse: collapse; }
            table.ben-table th {
                background: #f7edf4; color: #5a2d4d;
                font-size: 8px; padding: 4px; border: 1px solid #e0c8d8;
            }
            table.ben-table td { border: 1px solid #eedde8; height: 10mm; }
            td.num-cell {
                text-align: center; font-weight: bold;
                color: #783d66; background: #fdf0f7; width: 26px;
            }
        </style>
        ';

        $blank = '<span style="border-bottom:1px solid #bbb;display:inline-block;width:100%;height:14px;"></span>';

        $html = $style . '

        <div class="section-title">Datos del documento</div>

        <table class="meta-box">
            <tr>
                <td class="meta-label">Documento</td>
                <td>Informe de Evento / Actividad</td>
                <td class="meta-label">Número de documento</td>
                <td>' . $blank . '</td>
            </tr>
            <tr>
                <td class="meta-label">Organización</td>
                <td>' . $blank . '</td>
                <td class="meta-label">Fecha del evento</td>
                <td>' . $blank . '</td>
            </tr>
            <tr>
                <td class="meta-label">Evento</td>
                <td>' . $blank . '</td>
                <td class="meta-label">Lugar</td>
                <td>' . $blank . '</td>
            </tr>
            <tr>
                <td class="meta-label">Teléfono</td>
                <td>' . $blank . '</td>
                <td class="meta-label">Total beneficiarios</td>
                <td>' . $blank . '</td>
            </tr>
        </table>

        <div class="section-header">Registro de personas beneficiarias</div>

        <table class="ben-table">
            <thead>
                <tr>
                    <th style="width:26px;">No.</th>
                    <th>Nombre completo</th>
                    <th style="width:200px;">CURP</th>
                    <th style="width:55px;">Edad</th>
                    <th style="width:110px;">Firma</th>
                </tr>
            </thead>
            <tbody>';

        for ($i = 1; $i <= 20; $i++) {
            $html .= '
            <tr>
                <td class="num-cell">' . $i . '</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
        }

        $html .= '</tbody></table>';

        $mpdf->WriteHTML($html);

        return $mpdf->Output('formato_informe_ajal_lol.pdf', 'S');
    }
}