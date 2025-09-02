<!DOCTYPE html>

<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $mailData['subject'] }}</title>
<style>
body {
font-family: Arial, sans-serif;
line-height: 1.6;
color: #333;
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
border-bottom: 2px solid #ddd;
}
.header h1 {
color: #555;
}
.content {
padding: 20px 0;
}
.footer {
text-align: center;
padding-top: 20px;
border-top: 2px solid #ddd;
font-size: 12px;
color: #888;
}
</style>
</head>
<body>
<div class="container">
<div class="header">
<h1>Mensagem da Academia {{ $gym_name }}</h1>
</div>
<div class="content">
<p>Olá,</p>
<p>Você recebeu uma mensagem importante da sua academia:</p>

        <p><strong>Assunto:</strong> {{ $mailData['subject'] }}</p>
        <hr>
        <p>{{ $mailData['message'] }}</p>
        <hr>
        <p>Atenciosamente,</p>
        <p><strong>{{ $manager_name }}</strong></p>
        <p>Gerente da Academia {{ $gym_name }}</p>
    </div>
    <div class="footer">
        <p>Esta é uma mensagem automática, por favor não responda a este email.</p>
        <p>&copy; {{ date('Y') }} Crowd Gym. Todos os direitos reservados.</p>
    </div>
</div>

</body>
</html>