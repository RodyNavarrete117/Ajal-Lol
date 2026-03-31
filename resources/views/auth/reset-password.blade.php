<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nueva contraseña</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<style>
  .login-card {
    padding-bottom: 200px;
  }
</style>
<body>
<div class="login-container">
  <div class="logo">
    <img src="{{ asset('assets/img/ajallol/ImagenPrincipal-white.png') }}" alt="Logo">
  </div>
  <div class="login-card">

    @if ($errors->has('token'))
      <p style="color:#E24B4A;font-size:14px;text-align:center;margin-bottom:16px;">
        <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('token') }}
      </p>
    @endif

    <form method="POST" action="{{ route('password.reset') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="input-group step step-active @error('password') error @enderror" style="margin-bottom: 20px;">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password" placeholder="Nueva contraseña (mín. 8 caracteres)">
        @error('password')
          <small class="input-error">{{ $message }}</small>
        @enderror
      </div>

      <div class="input-group step step-active">
        <i class="fa-solid fa-lock"></i>
        <input type="password" name="password_confirmation" placeholder="Confirmar nueva contraseña">
      </div>

      <div class="actions">
        <button type="submit" class="btn-login" style="width:100%">Guardar contraseña</button>
      </div>
    </form>

  </div>
</div>
</body>
</html>