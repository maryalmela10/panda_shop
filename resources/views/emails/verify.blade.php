<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifica tu cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #198754;  /* Color verde de Bootstrap */
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Confirma tu cuenta</h1>
        </div>
        
        <p>Hola {{ $name }},</p>
        
        <p>Gracias por registrarte. Para completar tu registro y activar tu cuenta, por favor haz clic en el botón de abajo:</p>
        
        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">Verificar mi cuenta</a>
        </div>
        
        <p>O puedes copiar y pegar el siguiente enlace en tu navegador:</p>
        <p style="word-break: break-all;">{{ $verificationUrl }}</p>
        
        <p>Este enlace expirará en 24 horas.</p>
        
        <p>Si no has creado esta cuenta, puedes ignorar este mensaje.</p>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>