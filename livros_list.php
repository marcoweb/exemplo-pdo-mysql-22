<?php
require_once './vendor/autoload.php';

use ExemploPDOMySQL\MySQLConnection;

$bd = new MySQLConnection();

$comando = $bd->prepare(
    'SELECT livros.id AS id, livros.titulo AS titulo, generos.nome AS genero
        FROM livros LEFT JOIN generos ON livros.id_genero = generos.id');
$comando->execute();

$livros = $comando->fetchAll(PDO::FETCH_ASSOC);

$_title = 'Livros';

?>


<?php include('./includes/header.php') ?>

<a class="btn btn-primary" href='livros_insert.php'>Novo Livro</a>
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach($livros as $l): ?>
            <tr>
                <td><?= $l['id'] ?></td>
                <td><?= $l['titulo'] ?></td>
                <td><?= $l['genero'] ?></td>
                <td>
                    <a class="btn btn-secondary" href="livros_update.php?id=<?= $l['id'] ?>">Editar</a> | 
                    <a class="btn btn-danger" href="livros_delete.php?id=<?= $l['id'] ?>">Remover</a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
            
<?php include('./includes/footer.php') ?>


