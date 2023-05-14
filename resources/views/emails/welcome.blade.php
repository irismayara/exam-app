<x-guest-layout>
    <h2 class="mb-4"><strong>Olá, {{$userName}}!</strong></h2>

    <p>Bem-vindo ao Exam-App! Abaixo estão suas informações de login para o primeiro acesso:</p>

    <ul class="m-4">
        <li><strong>Nome de usuário:</strong> {{$userEmail}}</li>
        <li><strong>Senha:</strong> {{$userPassword}}</li>
    </ul>

    <p>Obrigado,</p>
    <p>Equipe Exam-App</p>
</x-guest-layout>