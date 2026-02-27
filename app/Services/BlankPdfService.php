<?php

namespace App\Services;

use Mpdf\Mpdf;

class BlankPdfService
{
    public function generate()
    {
        $mpdf = new Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 38,
            'margin_bottom' => 22,
            'margin_left'   => 18,
            'margin_right'  => 18,
        ]);

        $mpdf->SetTitle('Formato de Informe - Ajal-Lol A.C.');

        /* ---------- HEADER ---------- */
        $mpdf->SetHTMLHeader('
        <table width="100%" style="border-bottom:2.5px solid #783d66;padding-bottom:7px;font-family:Arial;">
            <tr>
                <td width="12%">
                    <img src="' . public_path('assets/img/logo_ajal_lol.png') . '" style="height:42px;">
                </td>

                <td width="60%" style="padding-left:12px;">
                    <div style="font-size:15px;font-weight:bold;color:#5a2d4d;letter-spacing:2px;text-transform:uppercase;">
                        Ajal-Lol A.C.
                    </div>
                    <div style="font-size:8px;color:#777;margin-top:2px;text-transform:uppercase;">
                        Sistema Administrativo · Informe de Evento / Actividad
                    </div>
                </td>

                <td width="28%">
                    <table width="100%" style="border-collapse:collapse;border:1px solid #e0c8d8;">
                        <tr style="background:#783d66;color:#fff;">
                            <td colspan="2" style="padding:3px 8px;font-size:7px;font-weight:bold;">
                                Datos del documento
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:2px 7px;font-size:7px;">Folio</td>
                            <td style="padding:2px 7px;">INF-_____</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 7px;font-size:7px;">Fecha</td>
                            <td style="padding:2px 7px;">___/___/______</td>
                        </tr>
                        <tr>
                            <td style="padding:2px 7px;font-size:7px;">Página</td>
                            <td style="padding:2px 7px;">{PAGENO}/{nb}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        ');

        /* ---------- FOOTER ---------- */
        $mpdf->SetHTMLFooter('
        <table width="100%" style="border-top:1px solid #e0c8d8;font-size:7px;color:#aaa;">
            <tr>
                <td>
                    Ajal-Lol A.C. · Documento interno · Formato para llenar a mano
                </td>
                <td style="text-align:right;">
                    Generado el ' . now()->format('d/m/Y') . '
                </td>
            </tr>
        </table>
        ');

        /* ---------- ESTILOS ---------- */
        $style = '
        <style>
        body{
            font-family:Arial;
            font-size:11px;
            color:#222;
        }

        .meta-box{
            width:100%;
            border-collapse:collapse;
            margin-bottom:8px;
            border:1px solid #e0c8d8;
            border-top:3px solid #783d66;
        }

        .meta-box td{
            padding:4px 10px;
            border-bottom:1px solid #f0e0ea;
        }

        .meta-label{
            font-weight:bold;
            color:#783d66;
            width:130px;
            background:#fdf5fa;
            font-size:9px;
        }

        .section-header{
            background:#783d66;
            color:#fff;
            font-size:9px;
            font-weight:bold;
            padding:5px 12px;
            text-transform:uppercase;
        }

        table.ben-table{
            width:100%;
            border-collapse:collapse;
        }

        table.ben-table th{
            background:#f7edf4;
            color:#5a2d4d;
            font-size:9px;
            padding:5px;
            border:1px solid #e0c8d8;
        }

        table.ben-table td{
            height:9.5mm;
            border:1px solid #eedde8;
        }

        td.num-cell{
            text-align:center;
            font-weight:bold;
            color:#783d66;
            background:#fdf0f7;
            width:28px;
        }
        </style>
        ';

        $blank = '<span style="border-bottom:1px solid #bbb;display:inline-block;width:100%;height:11px;"></span>';

        /* ---------- CONTENIDO ---------- */
        $html = $style . '

        <table class="meta-box">
            <tr>
                <td class="meta-label">Documento</td>
                <td>Informe de Evento / Actividad</td>
                <td class="meta-label">Folio</td>
                <td>'.$blank.'</td>
            </tr>

            <tr>
                <td class="meta-label">Organización</td>
                <td>'.$blank.'</td>
                <td class="meta-label">Fecha del evento</td>
                <td>'.$blank.'</td>
            </tr>

            <tr>
                <td class="meta-label">Evento</td>
                <td>'.$blank.'</td>
                <td class="meta-label">Lugar</td>
                <td>'.$blank.'</td>
            </tr>

            <tr>
                <td class="meta-label">Teléfono</td>
                <td>'.$blank.'</td>
                <td class="meta-label">Total beneficiarios</td>
                <td>'.$blank.'</td>
            </tr>
        </table>

        <div class="section-header">■ Registro de personas beneficiarias</div>

        <table class="ben-table">
            <thead>
                <tr>
                    <th style="width:28px;">No.</th>
                    <th>Nombre completo</th>
                    <th>CURP</th>
                    <th>Firma de recibido</th>
                </tr>
            </thead>
            <tbody>';

        for ($i = 1; $i <= 20; $i++) {
            $html .= '
            <tr>
                <td class="num-cell">'.$i.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
        }

        $html .= '
            </tbody>
        </table>';

        $mpdf->WriteHTML($html);

        return $mpdf->Output('formato_informe_ajal_lol.pdf', 'S');
    }
}