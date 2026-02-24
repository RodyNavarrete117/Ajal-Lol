<?php

namespace App\Services;

use Mpdf\Mpdf;

class FormPdfService
{
    public function generate($forms)
    {
        $mpdf = new Mpdf([
            'margin_left'   => 20,
            'margin_right'  => 20,
            'margin_top'    => 30,
            'margin_bottom' => 25,
            'format'        => 'A4'
        ]);

        $style = '
        <style>
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: #333;
            }

            /* MARCO EXTERIOR */
            .page-border {
                border: 3px solid #f06292;
                border-radius: 18px;
                padding: 25px;
            }

            /* Línea interna decorativa */
            .inner-border {
                border: 1.5px solid #f8bbd0;
                border-radius: 12px;
                padding: 20px;
            }

            .header {
                text-align: center;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid #f8bbd0;
            }

            .logo {
                height: 55px;
                margin-bottom: 8px;
            }

            .title {
                font-size: 18px;
                font-weight: bold;
                color: #c2185b;
                letter-spacing: 0.5px;
            }

            .subtitle {
                font-size: 11px;
                color: #666;
                margin-top: 4px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
                border-radius: 8px;
                overflow: hidden;
            }

            th {
                background-color: #e91e63;
                color: #fff;
                font-size: 11px;
                padding: 10px;
                text-transform: uppercase;
            }

            td {
                padding: 9px;
                border-bottom: 1px solid #f3c1d3;
            }

            tbody tr:nth-child(even) {
                background-color: #fdf2f6;
            }

            tbody tr:last-child td {
                border-bottom: none;
            }

            td.number {
                text-align: center;
                font-weight: bold;
                color: #c2185b;
                width: 40px;
            }

            .footer {
                font-size: 10px;
                color: #777;
                text-align: right;
                margin-top: 15px;
            }
        </style>
        ';

        $html = $style . '
        <div class="page-border">
            <div class="inner-border">

                <div class="header">
                    <img src="' . public_path('assets/img/logo_ajal_lol.png') . '" class="logo">
                    <div class="title">REPORTE DE FORMULARIOS</div>
                    <div class="subtitle">Ajal Lol · Sistema Administrativo</div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Asunto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>';

        $counter = 1;
        foreach ($forms as $form) {
            $fecha = date('d/m/Y H:i', strtotime($form->fecha_envio));
            $telefono = $form->numero_telefonico ?? 'N/A';

            $html .= '
                    <tr>
                        <td class="number">'.$counter.'</td>
                        <td>'.htmlspecialchars($form->nombre_completo).'</td>
                        <td>'.htmlspecialchars($form->correo).'</td>
                        <td>'.htmlspecialchars($telefono).'</td>
                        <td>'.htmlspecialchars($form->asunto).'</td>
                        <td>'.$fecha.'</td>
                    </tr>';
            $counter++;
        }

        $html .= '
                    </tbody>
                </table>

            </div>
        </div>';

        $mpdf->SetHTMLFooter('
            <div class="footer">
                Generado el: ' . date('d/m/Y H:i') . ' | Página {PAGENO} de {nb}
            </div>
        ');

        $mpdf->WriteHTML($html);
        return $mpdf;
    }
}