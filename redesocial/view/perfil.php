<?php
require_once '../controller/exibemensagem.controller.php';

$estaLogado = isset($_SESSION['auth']);

if ($estaLogado) {
    require_once '../model/conta.class.php';
    require_once '../model/usuario.class.php';
    require_once '../repository/usuario.repository.php';

    $conta = unserialize($_SESSION['auth']);

    $repository = new UsuarioRepository();
    $usuario = $repository->recuperaUsuario($conta->id);

    if ($usuario == null) {
        header('location:./completar-perfil.php');
    } else {
        $dataOriginal = $usuario->dataNascimento;
        $datas = explode('-', $dataOriginal);
        $novaData = $datas[2].'/'.$datas[1].'/'.$datas[0];
        $usuario->dataNascimento = $novaData;
    }
} else {
    header('location:./login.php');
}
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
    <header class="bg-secondary pt-2 pb-2 row m-0">
        <h2 class="text-start text-white col-6">
            Bem-vindo(a), pessoa!
        </h2>
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
                            <a href="./posts.php" class="nav-link">Meus posts</a>
                        </li>
                        <li class="nav-item">
                            <a href="./perfil.php" class="nav-link active">Meu perfil</a>
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
                    <h2>Meu perfil</h2>
                    <?php if ($temErro) { ?>
                        <div class="mt-2 alert alert-danger" role="alert"><?=$erro?></div>
                    <?php } else if ($temSucesso) { ?>
                        <div class="mt-2 alert alert-success" role="alert"><?=$sucesso?></div>
                    <?php } ?>
                    <form action="../controller/atualizaperfil.controller.php" method="post">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" disabled
                            value="<?=$conta->email?>">
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label for="senha-antiga" class="form-label">Senha antiga</label>
                                <input type="password" name="senha-antiga" id="senha-antiga" class="form-control">
                            </div>
                            <div class="col">
                                <label for="nova-senha" class="form-label">Nova senha</label>
                                <input type="password" name="nova-senha" id="nova-senha" class="form-control">
                            </div>
                            <div class="col">
                                <label for="confirmar-senha" class="form-label">Confirme a nova senha</label>
                                <input type="password" name="confirmar-senha" id="confirmar-senha" class="form-control">
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="nome-completo" class="form-label">Nome completo</label>
                            <input type="text" name="nome-completo" id="nome-completo" class="form-control" required maxlength="50"
                            value="<?=$usuario->nomeCompleto?>">
                        </div>
                        <div class="form-group mt-2">
                            <label for="data-nascimento" class="form-label">Data de nascimento</label>
                            <input type="text" name="data-nascimento" id="data-nascimento" class="form-control" required minlength="10" maxlength="10"
                            value="<?=$usuario->dataNascimento?>">
                        </div>
                        <div class="form-group mt-2">
                            <p>Gênero</p>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="genero" id="m" class="form-check-input" required value="M"
                                <?php
                                if ($usuario->genero == 'M') {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="m" class="form-check-label">Masculino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="genero" id="f" class="form-check-input" value="F"
                                <?php
                                if ($usuario->genero == 'F') {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="f" class="form-check-label">Feminino</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="genero" id="x" class="form-check-input" value="X"
                                <?php
                                if ($usuario->genero == 'X') {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="x" class="form-check-label">Outro</label>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <input type="submit" class="btn btn-primary" value="Atualizar dados">
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>