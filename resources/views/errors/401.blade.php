<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Acesso Negado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-blue-950  text-white ">
    <div class="text-center z-20">
        <h1 class="text-[11em] font-bold text-red-600">401</h1>
        <p class="text-[3em]">Acesso Negado</p>
        <p class="text-white mt-2">Website em manutenção</p>
        <a href="{{ url('/') }}"
           class="mt-6 inline-block px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition">
            Voltar à Página Inicial
        </a>
    </div>
</body>
</html>
