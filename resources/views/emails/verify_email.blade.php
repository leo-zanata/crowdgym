<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333333;
        }
        .content {
            padding: 20px 0;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #666666;
            margin: 0 0 10px;
        }
        .code {
            display: inline-block;
            background-color: #28a745; /* Cor verde para verificação */
            color: #ffffff;
            font-size: 28px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            letter-spacing: 5px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #aaaaaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verificação de E-mail</h1>
        </div>
        <div class="content">
            <p>Seu código de verificação é:</p>
            <span class="code">{{ $code }}</span>
            <p>Use este código para verificar seu e-mail e ativar sua conta.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Crowd Gym. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>