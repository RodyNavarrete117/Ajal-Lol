<?php

namespace App\Services;

use Mpdf\Mpdf;

class FormPdfService
{
    public function generate($forms)
    {
        $mpdf = new Mpdf([
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 20,
            'margin_bottom' => 20,
            'format'        => 'A4'
        ]);

        // CSS para PDF
        $style = '
            <style>
                body { font-family: sans-serif; font-size: 12px; color: #333; }
                h2 { text-align: center; color: #4b2e83; margin-bottom: 20px; }
                table { border-collapse: collapse; width: 100%; }
                th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; }
                th { background-color: #7d3f6a; color: #fff; font-weight: bold; }
                tbody tr:nth-child(even) { background-color: #f9f9f9; }
                tbody tr:hover { background-color: #f1eaff; }
            </style>
        ';

        // Contenido HTML
        $html = $style . '<h2>Formularios de Contacto</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($forms as $form) {
            $fecha = date('d/m/Y H:i', strtotime($form->fecha_envio));
            $telefono = $form->numero_telefonico ?? 'N/A';

            $html .= '<tr>
                        <td>'.$form->id_formcontacto.'</td>
                        <td>'.htmlspecialchars($form->nombre_completo).'</td>
                        <td>'.htmlspecialchars($form->correo).'</td>
                        <td>'.htmlspecialchars($telefono).'</td>
                        <td>'.htmlspecialchars($form->asunto).'</td>
                        <td>'.$fecha.'</td>
                      </tr>';
        }

        $html .= '</tbody></table>';

        $mpdf->WriteHTML($html);
        return $mpdf;
    }
}