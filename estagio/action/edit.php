<?php
    // incluindo as dependencias
    require_once '../connect/conn.php';

    require_once '../connect/dados/dados.php';
    require_once '../connect/dados/dadosDao.php';

    session_start();
    if (!isset($_SESSION['logado'])) {
        $_SESSION['msg'] = "<script>alert('Por favor, esteja logado antes de editar um classificado!');</script>";
        header('Location: usuario.php');
    }
    $dados = new conn\Dados();
    $dadosDao = new conn\DadosDao();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Classificados</title>
    <link rel="stylesheet" media="all" type="text/css" href="add.css">
</head>
<body>
    
    <main class="classificadoMain">
        <div class="classificadoMain-form">
            <?php
            foreach ($dadosDao->read() as $d):
                if ($d['id'] == $_GET['id']):
            ?>

            <div class="card">
                <span class="title">Editar Classificado</span>
                <form class="form" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="group">
                        <input placeholder="‎" type="text" name="form-nome" required="" value="<?php echo $d['texto']; ?>">
                        <label for="name">Nome</label>
                    </div>
                    <div class="group">
                        <input placeholder="‎" type="date" id="email" name="form-data" required="" value="<?php echo $d['data']; ?>">
                        <label for="email">Data</label>
                        </div>
                    <div class="group">
                        <textarea placeholder="‎" id="comment" name="form-desc" rows="5" required=""><?php echo $d['descricao']; ?></textarea>
                        <label for="comment">Descrição</label>
                    </div>
                        <button type="submit" name="form-btn">Editar</button>
                </form>
            </div>

            <?php
                endif;
            endforeach;
            ?>
        </div>
    </main>
</body>
</html>
<?php
    if (isset($_POST['form-btn'])) {
        class Verifica {
            private $nome;
            private $data;
            private $desc;
            private $erros = array();

            public function __construct($no, $da, $de) {
                $this->nome = $no;
                $this->data = $da;
                $this->desc = $de;
            }

            public function filtrar () {
                if (empty($this->nome)) {
                    $this->erros[] = "<li>Por favor, preencha o campo nome</li>";
                } 
                if (empty($this->data)) {
                    $this->erros[] = "<li>Por favor, preencha o campo data</li>"; 
                } 
                if (empty($this->desc)) {
                    $this->erros[] = "<li>Por favor, preencha o campo descrição</li>";
                }

                if (empty($this->erros)) {
                    return true;
                } else {
                    foreach ($this->erros as $erro):
                        echo $erro;
                    endforeach;
                }
            }

        }

        // instanciando a classe e verificando se está tudo ok
        $filtro = new Verifica ($_POST['form-nome'],
                                $_POST['form-data'],
                                $_POST['form-desc']);
        
        if($filtro->filtrar()) {
            // colocando os dados como novo classificado    
            $dados->setId($_GET['id']);
            $dados->setClass($_SESSION['id']);
            $dados->setTexto($_POST['form-nome']);
            $dados->setData($_POST['form-data']);
            $dados->setDescr($_POST['form-desc']);

            if ($dadosDao->update($dados)):
                $_SESSION['msg'] = "<script>alert('Classificado editado com sucesso!')</script>";
                header("Location: ../index.php");
            else: 
                $_SESSION['msg'] = "<script>alert('Não foi possível editar o classificado')</script>";
                header("Location: ../index.php");
            endif;
        }
    }

?>