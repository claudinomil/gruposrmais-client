<h1>Confirmação de E-mail</h1>

<p>Código de Confirmação: {{$token1.' | '.$token2.' | '.$token3.' | '.$token4}}</p>

Você pode confirmar seu E-mail no link abaixo:
<a href="{{ route('code.confirm.email.get', $email) }}">Confirmar E-mail</a>
