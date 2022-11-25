<?php
require_once './vendor/autoload.php';

use ExemploPDOMySQL\MySQLConnection;

$bd = new MySQLConnection();

$livro = null;

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comando = $bd->prepare('SELECT * FROM generos');
    $comando->execute();

    $generos = $comando->fetchAll(PDO::FETCH_ASSOC);

    $comandoLivro = $bd->prepare('SELECT * FROM livros WHERE id = :id');
    $comandoLivro->execute([':id' => $_GET['id']]);
    $livro = $comandoLivro->fetch(PDO::FETCH_ASSOC);
} else {
    $comando = $bd->prepare(
        'UPDATE livros SET titulo = :titulo, id_genero = :genero WHERE id = :id');
    $comando->execute(
        [':titulo' => $_POST['titulo'],':genero' => $_POST['genero'], ':id' => $_POST['id']]);

    header('Location:/livros_list.php');
}
?>

<?php include('./includes/header.php') ?>

    <h1>Novo Livro</h1>
    <form action="livros_update.php" method="post">
        <input type="hidden" name="id" value="<?= $livro['id'] ?>" />
        <div class="form-group">
            <label for="titulo">Título</label>
            <input class="form-control" type="text" name="titulo" value="<?= $livro['titulo'] ?>" />
        </div>
        <div class="form-group">
            <label for="genero">Gênero</label>
            <select name="genero" class="form-select">
            <?php foreach($generos as $g): ?>
                <option <?= ($g['id'] == $livro['id_genero']) ? 'selected' : '' ?> value="<?= $g['id'] ?>"><?= $g['nome'] ?></option>
            <?php endforeach ?>
            </select>
        </div>
        <br />
        <a class="btn btn-secondary" href="livros_list.php">Voltar</a>
        <button class="btn btn-success" type="submit">Salvar</button>
    </form>

<?php include('./includes/footer.php') ?>