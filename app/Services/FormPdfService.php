<?php

namespace App\Services;

use Mpdf\Mpdf;

class FormPdfService
{
    public function generate($forms)
    {
        $mpdf = new Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'format' => 'A4'
        ]);

        $html = '<h2 style="text-align:center;">Formularios de Contacto</h2>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead style="background-color:#f2f2f2;">
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