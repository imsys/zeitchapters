<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Confirmação de Cadastro</h2>

		<p>Por favor, clique no link para confirmar seu cadastro: {{ HTML::link('registration/confirm/'.$enc, URL::to('registration/confirm/'.$enc)) }}
		</p>
		
		<p>Movimento Zeitgeist Brasil</p>
	</body>
</html>