<?php
require_once './vendor/autoload.php';

use ExemploPDOMySQL\MySQLConnection;

$bd = new MySQLConnection();
$livro = null;

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $comando = $bd->prepare('SELECT * FROM livros WHERE id = :id');
    $comando->execute([':id' => $_GET['id']]);
    $livro = $comando->fetch(PDO::FETCH_ASSOC);
} else {
    $comando = $bd->prepare('DELETE FROM livros WHERE id = :id');
    $comando->execute([':id' => $_POST['id']]);

    header('Location:/livros_list.php');
}

$_title = 'Remover Livro';

?>

<?php include('./includes/header.php') ?>

            <h1>Remover Livro</h1>
            <p>Tem certeza que deseja excluir o livro <?= $livro['titulo'] ?>?</p>

            <form action="livros_delete.php" method="post">
                <input type="hidden" name="id" value="<?= $livro['id'] ?>" />
                <a class="btn btn-secondary" href="livros_list.php">Voltar</a>
                <button class="btn btn-danger" type="submit">Excluir</button>
            </form>
            
<?php include('./includes/footer.php') ?>

