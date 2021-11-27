<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>New Fisco - Cadastro</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
  
  <link href="{{asset('css/main.css')}}" rel="stylesheet">

  <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
</head>
<body>


<section id="sectionCadastro">
  <div class="container-fluid pt-3" style="padding: 2% 7%;">
    <a style="font-size: 28px; text-decoration: none;" href="{{ route('index') }}">
        <p style="margin-top: 1%; color: black;font-weight: 800;">
            <i class="fas fa-caret-left"></i>
            <span class="colorPatternPrimary">New</span><span style="text-shadow: 3px 3px #80008036;">Fisco</span>
        </p>
    </a>

    <div class="row">
        <div class="col-xl-12">
            <div class="card cardCadastro">
                <div class="card-body">
                    <form method="post" action="{{ route('cadastrar') }}">
                        @csrf

                        <h1>Cadastro</h1>

                        <div class="mt-5 mb-5 row">
                            <div class="col-xl-12">
                                <input type="text" max="14" name="cnpj" class="cnpj form-control inputPatternOne" placeholder="CNPJ">
                            </div>
                        </div>
                        
                        <div class="mb-5 row">
                            <div class="col-xl-6">
                                <input type="text" name="razao" class="form-control inputPatternOne" placeholder="Razão Social">
                            </div>
                            <div class="col-xl-6">
                                <input type="text" name="nome" class="form-control inputPatternOne" placeholder="Nome Fantasia">
                            </div>
                        </div>

                        <div class="mb-5 row">
                            <div class="col-xl-12">
                                <input type="text" name="email" class="form-control inputPatternOne" placeholder="E-mail">
                            </div>
                        </div>

                        <div class="mb-5 row">
                            <div class="col-xl-6">
                                <input type="text" name="login" class="form-control inputPatternOne" placeholder="Login">
                            </div>
                            <div class="col-xl-6">
                                <input type="text" name="senha" class="form-control inputPatternOne" placeholder="Senha">
                            </div>
                        </div>

                        <div class="mb-5 row">
                            <div class="col-xl-12 text-end">
                                <button type="submit" class="btnCadastro btn btn-primary">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>

<script src="{{ url('../resources/js/main.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

</body>
</html>


