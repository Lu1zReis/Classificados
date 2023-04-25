<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" media="all" type="text/css" href="usuario.css">
</head>
<body>

    <form class="form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
       <p class="form-title">Cadastre uma conta!</p>
        <div class="input-container">
          <input placeholder="Coloque um usuário" type="text" name="nome">
          <span>
            <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
          </span>
        </div>
        <div class="input-container"> 
          <input placeholder="Coloque uma senha" type="password" name="psw1">

          <span>
            <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
              <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
          </span>
        </div>

        <div class="input-container"> 
          <input placeholder="Repita a senha" type="password" name="psw2">

          <span>
            <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
              <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
            </svg>
          </span>
        </div>

         <button class="submit" type="submit" name="btn">
        Cadastrar
      </button>

   </form>

</body>
</html>
<?php
    session_start();
    if (isset($_POST['btn'])):
        if ($_POST['psw1'] == $_POST['psw2']):
            class Filtro {
                private $nome, $senha, $erros = array();
                public function __construct ($n, $s) {
                    $this->nome = $n;
                    $this->senha = $s;
                }
                public function verifica () {
                    if(empty($this->nome)) {
                        $this->erros[] = "<li>Preencha o campo nome</li>";
                    }       
                    if(empty($this->senha)) {
                        $this->erros[] = "<li>Preencha o campo senha</li>";
                    }
                    if (empty($this->erros)):
                        return true;
                    else:
                        foreach ($this->erros as $erro) {
                            echo $erro;
                        }
                    endif;
                }
            }
            $filtro = new Filtro ($_POST['nome'], $_POST['psw1']);
            if ($filtro->verifica()):
                require_once '../connect/conn.php';
                require_once '../connect/usuarios/usuarios.php';
                require_once '../connect/usuarios/usuariosDao.php';

                
                $usu = new conn\Usuario();
                $usuDao = new conn\UsuarioDao();

                $usu->setNome($_POST['nome']);
                $usu->setSenha($_POST['psw1']);
            
                if ($usuDao->create($usu)) {
                    $_SESSION['msg'] = "<script>alert('Nova conta criada com sucesso!');</script>";
                    header('Location: ../index.php');
                }

            endif;
        else:
            echo "<li>As senhas não são iguais!</li>";
        endif;
    endif;
?>