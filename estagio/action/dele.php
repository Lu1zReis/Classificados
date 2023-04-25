<script>
    const resp = confirm('Deseja mesmo apagar esse classificado?');
    if (!resp) {
        window.location.href = "../index.php";
    }
</script>

<?php
    // incluindo as dependencias
    require_once '../connect/conn.php';

    require_once '../connect/dados/dados.php';
    require_once '../connect/dados/dadosDao.php';
    session_start();
    $dados = new conn\Dados();
    $dadosDao = new conn\DadosDao();

    
    if ($dadosDao->delete($_GET['id'])) {
        $_SESSION['msg'] = "<script>alert('Classificado deletado com sucesso!');</script>";
        header('Location: ../index.php');
    }
    
?>
