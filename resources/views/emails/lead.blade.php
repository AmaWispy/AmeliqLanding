<!DOCTYPE html>
<html>
<head>
    <title>Новая заявка</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px;">
    <h2>Новая заявка с сайта</h2>
    
    <table style="width: 100%; max-width: 600px; border-collapse: collapse;">
        @foreach($data as $key => $value)
            @if(!empty($value) && $key !== '_token')
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px; font-weight: bold; width: 150px;">
                        {{ ucfirst($key) }}:
                    </td>
                    <td style="padding: 10px;">
                        {{ is_array($value) ? json_encode($value) : $value }}
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
    
    <p style="margin-top: 20px; color: #666; font-size: 12px;">
        Письмо отправлено автоматически с сайта {{ config('app.name') }}
    </p>
</body>
</html>

