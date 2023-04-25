<?php 
session_start();
if (empty($_SESSION['logado'])):
    $_SESSION['msg'] = "<script>alert('Você não está logado!');</script>";
    header('Location: ../index.php');
else:
    require_once '../connect/conn.php';

    require_once '../connect/dados/dados.php';
    require_once '../connect/dados/dadosDao.php';

    require_once '../connect/usuarios/usuarios.php';
    require_once '../connect/usuarios/usuariosDao.php';

    $usu = new conn\Usuario();
    $usuDao = new conn\UsuarioDao();
    $dados = new conn\Dados();
    $dadosDao = new conn\DadosDao();
    $nome = "user";
    foreach ($usuDao->read() as $usu):
        foreach ($dadosDao->read() as $d) {
            if ($usu['id'] == $d['class'] and $d['id'] == $_GET['id']) {
                $nome = $usu['nome'];
            }
        }
    endforeach;
?>
    <!DOCTYPE html>
    <html lang="PT-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Classificado</title>
        <link rel="stylesheet" media="all" type="text/css" href="style.css">
    </head>
    <body>
    <?php
    foreach ($dadosDao->read() as $dado):
        if ($dado['id'] == $_GET['id']):
                    ?>
        <div class="secao">
            <article class="card">
                <div class="temporary_text">
                    Usuario, <?php echo $nome; ?>!
                </div>
            <div class="card_content">
                <span class="card_title"><?php echo $dado['texto']; ?> </span>
                <span class="card_subtitle"><?php echo $dado['data']; ?></span>
                <p class="card_description"><?php echo $dado['descricao']; ?></p>
                
            </div>
            </article>
        <?php
            if ($dado['class'] == $_SESSION['id']):
        ?>
        <div class="botoes">
            <div class="botao-edit"><a style="color:white" href="../action/edit.php?id=<?php echo $dado['id']; ?>">Editar</a></div>
            <div class="botao-dele"><a style="color:white" href="../action/dele.php?id=<?php echo $dado['id']; ?>">Excluir</a></div>
        </div>
        <?php
            endif;
        endif;
    endforeach;
    ?>
    <div>
    </body>
    </html>
<?php
endif;
?>
