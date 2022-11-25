<?php
require_once './vendor/autoload.php';

use ExemploPDOMySQL\MySQLConnection;

$bd = new MySQLConnection();

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comando = $bd->prepare('SELECT * FROM generos');
    $comando->execute();

    $generos = $comando->fetchAll(PDO::FETCH_ASSOC);
} else {
    $comando = $bd->prepare('INSERT INTO livros(titulo, id_genero) VALUES(:nome, :genero)');
    $comando->execute([':nome' => $_POST['titulo'], ':genero' => $_POST['genero']]);

    header('Location:/livros_list.php');
}
?>

<?php include('./includes/header.php') ?>

    <h1>Novo Livro</h1>
    <form action="livros_insert.php" method="post">
        <div class="form-group">
            <label for="titulo">Título</label>
            <input class="form-control" type="text" name="titulo" />
        </div>
        <div class="form-group">
            <label for="genero">Gênero</label>
            <select name="genero" class="form-select">
            <?php foreach($generos as $g): ?>
                <option value="<?= $g['id'] ?>"><?= $g['nome'] ?></option>
            <?php endforeach ?>
            </select>
        </div>
        <br />
        <a class="btn btn-secondary" href="livros_list.php">Voltar</a>
        <button class="btn btn-success" type="submit">Salvar</button>
    </form>

<?php include('./includes/footer.php') ?>