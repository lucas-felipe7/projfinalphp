<?php
require_once '../controller/criamensagem.controller.php';

function trataErro($mensagem) {
    criaErro($mensagem);
    header('location:../view/perfil.php');
}

$erro;
$sucesso;

if (isset($_POST['senha-antiga']) &&
    isset($_POST['nova-senha']) &&
    isset($_POST['confirmar-senha']) &&
    isset($_POST['nome-completo']) &&
    isset($_POST['data-nascimento']) &&
    isset($_POST['genero'])) {

    $senhaAntiga = $_POST['senha-antiga'];
    $novaSenha = $_POST['nova-senha'];
    $confirmaSenha = $_POST['confirmar-senha'];
    $nomeCompleto = ucwords(strtolower($_POST['nome-completo']));
    $dataNascimento = $_POST['data-nascimento'];
    $genero = $_POST['genero'];

    if (!empty($senhaAntiga) && !empty($novaSenha) && !empty($confirmaSenha))  {
        if ($novaSenha == $confirmaSenha) {
            require_once '../model/conta.class.php';

            $senhaAntiga = md5('qi'.$senhaAntiga.'ab');
        
            $conta = unserialize($_SESSION['auth']);
        
            if ($senhaAntiga == $conta->senha) {
                require_once '../repository/conta.repository.php';

                $novaSenha = md5('qi'.$novaSenha.'ab');
                $repository = new ContaRepository();
        
                $resultado = $repository->atualizaConta($conta->id, $novaSenha);
        
                if ($resultado) {
                    $conta->senha = $novaSenha;
                    $_SESSION['auth'] = serialize($conta);
                } else {
                    $erro = 'Nao foi possível alterar a senha';
                }
            } else {
                $erro = 'Senha antiga inválida';
            }
        } else {
            $erro = 'As senhas precisam ser iguais';
        }
    }

    if ($erro != null) {
        trataErro($erro);
        return;
    }

    if (!empty($nomeCompleto) && !empty($dataNascimento) && !empty($genero)) {
        if (strlen($nomeCompleto) > 50) {
            $erro = 'Preencha o nome corretamente';
        } else if (strlen($dataNascimento) != 10) {
            $erro = 'Preencha a data de nascimento corretamente';
        } else if ($genero != 'M' && $genero != 'F' && $genero != 'X') {
            $erro = 'Selecione um gênero válido';
        } else {
            $datas = explode('/', $dataNascimento);

            if (count($datas) != 3) {
                $erro = 'Preencha a data corretamente';
            } else {
                require_once '../repository/usuario.repository.php';

                $dataNascimento = $datas[2].'-'.$datas[1].'-'.$datas[0];

                $repository = new UsuarioRepository();
    
                $resultado = $repository->atualizaUsuario(
                    $nomeCompleto,
                    $genero,
                    $dataNascimento,
                    $conta->id
                );
    
                if (!$resultado) {
                    $erro = 'Nao foi possível atualizar os seus dados.';
                }
            }
        }
    }

    if ($erro == null) {
        criaSucesso('Dados atualizados!');
        header('location:../view/perfil.php');
    } else {
        trataErro($erro);
    }
} else {
    header('location:../view/perfil.php');
}
