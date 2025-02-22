<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Contacto Recebido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #d3d3d3;
        }
        .header img {
            max-width: 200px;
        }
        .content {
            padding: 25px;
            color: #333;
        }
        .content h2 {
            color: #3D4877;
            text-align: center;
            font-size: 22px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .highlight {
            font-weight: bold;
            color: #3D4877;
        }
        .message-box {
            background: #f8f8f8;
            padding: 15px;
            border-radius: 8px;
            font-style: italic;
            border-left: 5px solid #3D4877;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        a{
            color: white;
        }
        .button {
            display: inline-block;
            background: #3D4877;
            color: #fff!important;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo/LOGO.svg') }}">
        </div>

        <div class="content">
            <h2>Novo Contacto Recebido</h2>
            <p><span class="highlight">Nome:</span> {{ $contactData['first_name'] }} {{ $contactData['nickname'] }}</p>
            <p><span class="highlight">Email:</span> {{ $contactData['email'] }}</p>
            <p><span class="highlight">Telemóvel:</span> {{ $contactData['phone'] }}</p>
            <p><span class="highlight">Assunto:</span> {{ $contactData['subject'] }}</p>
            <p><span class="highlight">Mensagem:</span></p>
            <p class="message-box">{{ $contactData['message'] }}</p>

            <div class="button-container">
                <a href="mailto:{{ $contactData['email'] }}" class="button">Responder ao Contacto</a>
            </div>
        </div>

        <div class="footer">
            <p>Este e-mail foi gerado automaticamente pelo site.</p>
        </div>
    </div>
</body>
</html>
