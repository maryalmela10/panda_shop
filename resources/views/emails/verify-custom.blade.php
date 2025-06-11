<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verifica tu correo</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; margin:0; padding:0;">
    <table width="100%" style="background-color: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 32px;">
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <h2 style="color: #38b2ac; margin-bottom: 8px;">¡Bienvenido, {{ $user->name }}!</h2>
                            <p style="color: #4b5563; font-size: 18px; margin: 0;">Por favor verifica tu correo electrónico</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 24px 0;">
                            <a href="{{ $url }}" style="display: inline-block; background: #38b2ac; color: #fff; text-decoration: none; padding: 14px 28px; border-radius: 6px; font-weight: bold; font-size: 16px;">
                                Verificar correo
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 16px; color: #4b5563; font-size: 14px;">
                            Si no creaste una cuenta, puedes ignorar este mensaje.
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 32px; color: #a0aec0; font-size: 12px;">
                            &copy; {{ date('Y') }} Tu Sitio. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
