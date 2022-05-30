<?php

require_once '../data/conexao.class.php';
require_once '../model/post.class.php';

class PostRepository {

    private $conexao;

    public function __construct() {
        $this->conexao = Conexao::getInstancia();
    }

    public function recuperaPosts() {
        $operacao = $this->conexao->prepare(
            'SELECT usuario.nomeCompleto, post.dataHora, post.conteudo, post.id FROM usuario INNER JOIN post ON usuario.id = post.idUsuario ORDER BY post.dataHora DESC'
        );

        $resultado = $operacao->execute();

        if ($resultado) {
            $posts = $operacao->fetchAll(PDO::FETCH_CLASS, 'Post');
            return $posts;
        } else {
            return [];
        }
    }

    public function recuperaPostsDoUsuario($idUsuario) {
        // TODO
        return [];
    }

    public function contaCurtidas($idPost) {
        // TODO
        return 0;
    }

    public function criaPost($conteudo, $idUsuario) {
        $operacao = $this->conexao->prepare(
            'INSERT INTO post (conteudo, idUsuario) VALUES (?, ?)'
        );

        $operacao->bindValue(1, $conteudo);
        $operacao->bindValue(2, $idUsuario);

        return $operacao->execute();
    }
}