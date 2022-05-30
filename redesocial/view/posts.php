<?php
require_once '../controller/exibemensagem.controller.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABQI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body class="container-fluid p-0">
    <!-- TODO: só pode entrar aqui se estiver logado e tiver um usuário -->
    <header class="bg-secondary pt-2 pb-2 row m-0">
        <h2 class="text-start text-white col-6">Bem-vindo(a), pessoa!</h2>
        <!-- TODO: puxar o nome da pessoa e verificar se é bem-vindo ou bem-vinda -->
        <h1 class="text-end text-white mb-0 col-6">ABQI</h1>
    </header>
    <main class="container-fluid">
        <div class="row py-3">
            <aside class="col-2">
                <div class="sticky-top">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="./home.php" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="./posts.php" class="nav-link active">Meus posts</a>
                        </li>
                        <li class="nav-item">
                            <a href="./perfil.php" class="nav-link">Meu perfil</a>
                        </li>
                        <li class="nav-item">
                        <a href="./controller/logout.controller.php" class="nav-link text-danger">Sair</a>
                        </li>
                        <!-- TODO: Atualizar hrefs -->
                    </ul>
                </div>
            </aside>
            <div class="col px-3">
                <section>
                    <h2>Meus posts</h2>
                    <?php if ($temErro) { ?>
                        <div class="mt-2 alert alert-danger" role="alert"><?=$erro?></div>
                    <?php } else if ($temSucesso) { ?>
                        <div class="mt-2 alert alert-success" role="alert"><?=$sucesso?></div>
                    <?php } ?>
                    <?php
                    require_once '../controller/meusposts.controller.php';

                    foreach ($posts as $post) {
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title"><strong><?=$post->nomeCompleto?></strong></p>
                                <p class="card-subtitle text-muted mb-3"><?=$post->dataHora?></p>
                                <p class="card-text"><?=$post->conteudo?></p>
                                <div class="row">
                                    <a href="#" class="col-6 link-secondary text-start">15</a>
                                    <!-- TODO: atualizar href para ver quem curtiu -->
                                    <a href="#" class="col-6 link-danger text-end">Excluir</a>
                                    <!-- TODO: atualizar href para excluir post -->
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </section>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>