<?php
    require_once '../connect/conn.php';

    require_once '../connect/usuarios/usuarios.php';
    require_once '../connect/usuarios/usuariosDao.php';
    require_once '../connect/dados/dados.php';
    require_once '../connect/dados/dadosDao.php';

    // caso esteja logado entraremos nessa condição
    session_start();
    if (isset($_SESSION['logado'])) {

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

            <div class="container">
                <div class="item">
                    <a href="usuario.php">
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
            <div class="item">
                <form action="" method="POST">  
                    <button type="submit" name="deslogar">sair da sessão</button>
                </form>
            </div>
            <div class="item">
                <form action="../index.php">  
                    <button>voltar</button>
                </form>
            </div>
        </div>
    
</header>
<div id="linha"></div>
    <main class="main">
        <form method="POST" action="../more/search.php" class="formulario">
            <input placeholder="Procure um classificado..." type="text" name="input-busca" class="input">
        </form>
        <?php
            foreach ($dadosDao->read() as $dadoDao):
                if ($_SESSION['id'] == $dadoDao['class']):
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
                if (isset($_POST['deslogar'])) {
                    session_unset();
                    session_destroy();
                    session_start();
                    $_SESSION['msg'] = "<script>alert('Deslogado com sucesso!');</script>";
                    header("Location: ../index.php");
                }
            endforeach;
        ?>
    </main>
<footer>

</footer>
</body>
</html>
<?php
    } 
    
    // caso nao tenhamos logado antes
    else {

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" media="all" type="text/css" href="usuario.css">
    </head>
    <body>

    <form class="form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
       <p class="form-title">Coloque sua conta!</p>
        <div class="input-container">
          <input placeholder="Coloque seu usuário!" type="text" name="nome">
          <span>
            <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
          </span>
      </div>
      <div class="input-container"> 
          <input placeholder="Coloque sua senha!" type="password" name="psw">

          <span>
            <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
              <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
          </span>
        </div>
         <button class="submit" type="submit" name="btn">
        Entrar
      </button>

      <p class="signup-link">
        Não tem conta?
        <a href="cadastro.php">Cadastre-se</a>
      </p>
   </form>

    </body>
    </html>
<?php

    if(isset($_POST['btn'])):
        class Filtro {
            private $nome, $senha, $erro;
            public function __construct($n, $s) {
                if (empty($n) or empty($s)):
                    $this->erro = "<script>alert('Por favor, preencha os dois campos');</script>";
                else:
                    $this->nome = $n;
                    $this->senha = $s;
                endif;
            }
            public function verifica() {
                if (empty($this->erro)):
                    return true;
                else:
                    echo $this->erro;
                endif;
                
            }
        }
        
        class Login {
            private $nome, $senha; 
            public function __construct ($n, $s) {
                $this->nome = $n;
                $this->senha = $s;
            }
            public function search () {
                $usu = new conn\UsuarioDao();
                foreach ($usu->read() as $u) {
                    if ($u['nome'] == $this->nome and $u['senha'] == $this->senha):
                        return true;
                    endif;
                }
                return false;
            }
            public function id () {
                $usu = new conn\UsuarioDao();
                foreach ($usu->read() as $u) {
                    if ($u['nome'] == $this->nome and $u['senha'] == $this->senha):
                        return $u['id'];
                    endif;
                }
            }

        }
        $f = new Filtro ($_POST['nome'], $_POST['psw']);
        if ($f->verifica()):
            $login = new Login($_POST['nome'], $_POST['psw']);
            if ($login->search()):
                $_SESSION['logado'] = true;
                $_SESSION['id'] = $login->id();
                header('Location: usuario.php');
            else:
                echo "<li>Usuário ou senha incorretas</li>";
            endif;
        endif;
        
    endif;
}
?>