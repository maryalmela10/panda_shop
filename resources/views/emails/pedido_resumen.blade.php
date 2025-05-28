<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de tu pedido</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; margin:0; padding:0;">
    <table width="100%" style="background-color: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 32px;">
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <h2 style="color: #38b2ac; margin-bottom: 8px;">¡Gracias por tu pedido, {{ $pedido->usuario->name }}!</h2>
                            <p style="color: #4b5563; font-size: 18px; margin: 0;">Resumen de tu pedido #{{ $pedido->id }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" style="border-collapse: collapse; margin-bottom: 24px;">
                                <thead>
                                    <tr style="background-color: #e6fffa;">
                                        <th align="left" style="padding: 8px; color: #319795;">Producto</th>
                                        <th align="center" style="padding: 8px; color: #319795;">Cantidad</th>
                                        <th align="right" style="padding: 8px; color: #319795;">Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $item)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 8px 0;">{{ $item['name'] }}</td>
                                        <td align="center" style="padding: 8px 0;">{{ $item['quantity'] }}</td>
                                        <td align="right" style="padding: 8px 0;">${{ number_format($item['price'], 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table width="100%" style="margin-bottom: 24px;">
                                <tr>
                                    <td align="right" style="padding: 4px 0; color: #4b5563;">Total productos:</td>
                                    <td align="right" style="padding: 4px 0; color: #111827;"><strong>${{ number_format($totalCost, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td align="right" style="padding: 4px 0; color: #4b5563;">Coste de envío:</td>
                                    <td align="right" style="padding: 4px 0; color: #111827;"><strong>${{ number_format($pedido->coste_envio, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td align="right" style="padding: 8px 0; color: #319795; font-size: 16px;">Total pedido:</td>
                                    <td align="right" style="padding: 8px 0; color: #319795; font-size: 16px;"><strong>${{ number_format($totalCost + $pedido->coste_envio, 2) }}</strong></td>
                                </tr>
                            </table>
                            <div style="background: #f1f5f9; border-radius: 6px; padding: 12px 16px; margin-bottom: 24px;">
                                <strong>Dirección de envío:</strong><br>
                                {{ $pedido->direccion_envio }}
                            </div>
                            <p style="color: #4b5563; font-size: 14px;">Si tienes cualquier duda sobre tu pedido, responde a este correo o contacta con nuestro servicio de atención al cliente.</p>
                            <div style="text-align: center; margin-top: 32px;">
                                <a href="{{ url('/') }}" style="display: inline-block; background: #38b2ac; color: #fff; text-decoration: none; padding: 12px 32px; border-radius: 4px; font-weight: bold;">Ir a la tienda</a>
                            </div>
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
