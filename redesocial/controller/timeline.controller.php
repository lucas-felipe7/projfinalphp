<?php

require_once '../repository/post.repository.php';
require_once '../model/post.class.php';

$repository = new PostRepository();

$posts = $repository->recuperaPosts();

// TODO contar curtidas