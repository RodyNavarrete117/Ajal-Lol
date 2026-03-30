<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; padding:0; }
    .container { max-width:520px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
    .header { background:#1a1a2e; padding:32px; text-align:center; }
    .body { padding:36px 40px; }
    .body h2 { font-size:20px; color:#1a1a1a; margin:0 0 12px; }
    .body p { font-size:15px; color:#555; line-height:1.6; margin:0 0 20px; }
    .btn { display:inline-block; padding:14px 32px; background:#6C63FF; color:#fff !important; border-radius:8px; text-decoration:none; font-size:15px; font-weight:600; }
    .note { font-size:12px; color:#999; margin-top:24px; }
    .footer { background:#f9f9f9; padding:20px 40px; text-align:center; font-size:12px; color:#aaa; }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="{{ asset('assets/img/ajallol/ImagenPrincipal-white.png') }}" alt="Ajal-LoL" style="height:48px;">
    </div>
    <div class="body">
      <h2>Hola, {{ $userName }}</h2>
      <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el botón para continuar:</p>
      <a href="{{ $resetUrl }}" class="btn">Restablecer contraseña</a>
      <p class="note">
        Este enlace expirará en <strong>60 minutos</strong>.<br>
        Si no solicitaste este cambio, puedes ignorar este correo.
      </p>
    </div>
    <div class="footer">© {{ date('Y') }} Ajal-LoL. Todos los derechos reservados.</div>
  </div>
</body>
</html>