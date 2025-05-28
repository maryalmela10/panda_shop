<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo mensaje de contacto</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8fafc; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 32px;">
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <h2 style="color: #38b2ac; margin-bottom: 8px;">Nuevo mensaje de contacto</h2>
                            <p style="color: #4b5563; font-size: 16px; margin: 0;">
                                Has recibido un nuevo mensaje desde el formulario de contacto de tu tienda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" style="margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563; width: 120px;"><strong>Nombre:</strong></td>
                                    <td style="padding: 8px 0; color: #111827;">{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563;"><strong>Email:</strong></td>
                                    <td style="padding: 8px 0; color: #111827;">{{ $email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #4b5563;"><strong>Asunto:</strong></td>
                                    <td style="padding: 8px 0; color: #111827;">{{ $subject }}</td>
                                </tr>
                            </table>
                            <div style="background: #f1f5f9; border-radius: 6px; padding: 16px; margin-bottom: 24px;">
                                <strong style="color: #319795;">Mensaje:</strong>
                                <p style="color: #4b5563; margin: 12px 0 0 0;">{{ $body }}</p>
                            </div>
                            <p style="color: #a0aec0; font-size: 12px; margin-top: 32px;">
                                Este mensaje ha sido enviado automáticamente desde el formulario de contacto de tu tienda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 32px; color: #a0aec0; font-size: 12px;">
                            &copy; {{ date('Y') }} Tu Tienda. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
