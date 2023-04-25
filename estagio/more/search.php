<?php
    if (empty($_POST['input-busca'])) {
        header('Location: ../index.php');
    } else {

        session_start();
        require_once '../connect/conn.php';

        require_once '../connect/dados/dados.php';
        require_once '../connect/dados/dadosDao.php';
    
        require_once '../connect/usuarios/usuarios.php';
        require_once '../connect/usuarios/usuariosDao.php';

        $usu = new conn\Usuario();
        $usuDao = new conn\UsuarioDao();
        $dados = new conn\Dados();
        $dadosDao = new conn\DadosDao();
        // criando uma var para a contagem dos classificados
        $cont = 0;
        foreach ($dadosDao->read() as $d) {
            $cont += 1;
        }
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classificados</title>
    <link rel="stylesheet" media="all" type="text/css" href="../style.css">
</head>
<body>
    <header class="cabecalho">
        <div class="cabecalho-items">
            <div class="cabecalho-items-title">
                Classificados (<?php echo $cont;?>)
            </div>

            <div class="container">
                    <div class="item">
                        <a href="../action/add.php">
                            <button type="button" class="button">
                                <span class="button__text">Novo Item</span>
                                <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="svg"><line y2="19" y1="5" x2="12" x1="12"></line><line y2="12" y1="12" x2="19" x1="5"></line></svg></span>
                            </button>
                        </a>
                    </div>

                    <div class="item">
                        <a href="../action/usuario.php">
                            <img class="img" src="../img/usuario.png" alt="usuario">
                            <p class="descr">
                            <?php
                                $nome = "Usuário";
                                foreach ($usuDao->read() as $u) {
                                    if (isset($_SESSION['id'])){
                                        if ($u['id'] == $_SESSION['id']) {
                                            $nome = $u['nome'];
                                        }
                                    }
                                }
                                echo $nome;
                            ?>
                            </p>
                        </a>
                    </div>
                </div>
        
    </header>
    <div id="linha"></div>
        <main class="main">
            <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" class="formulario">
                <input placeholder="Procure um classificado..." type="text" name="input-busca" class="input">
            </form>
            <?php
                $achou = false; // varivael responsavel para exibir se achou o conteudo pesquisado
                foreach ($dadosDao->read() as $dadoDao):
                    // parte responsável por filtrar e aparecer o conteúdo que pesquisamos
                    if ($dadoDao['texto'] == $_POST['input-busca']):
                        $achou = true;
            ?>
            <a class="secao" href="../more/classif.php?id=<?php echo $dadoDao['id']; ?>">
                <div class="card">
                    <h3 class="card__title">
                        <?php
                            echo $dadoDao['texto'];
                        ?>
                    </h3>
                    <p class="card__content">
                        <?php
                            echo $dadoDao['descricao'];
                        ?>
                    </p>
                    <div class="card__date">
                        <?php
                            echo $dadoDao['data'];
                        ?>
                    </div>
                    <div class="card__arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="15" width="15">
                            <path fill="#fff" d="M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z"></path>
                        </svg>
                    </div>
                </div>
            </a>
           

            <?php
                    endif;
                endforeach;
                if ($achou == false):
            ?>
            <div class="procura">
                Não achamos o que está procurando :(
            </div>
            <?php 
            endif;
            ?>
        </main>
    <footer>

    </footer>
</body>
</html>
<?php
    }
?>