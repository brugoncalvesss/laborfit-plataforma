<?php
include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php');

if ($_GET['id']) {
    $idEmpresa = $_GET['id'];
} else {
    die("Erro: Empresa não encontrada.");
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
<?php
$video = getEmpresaId($idEmpresa);

if ($video['EMPRESA_VIDEO']) {
    echo "<p>Não é possível excluir, exitem vídeos cadastrados.<br><a href='/admin/empresas/'>Clique para voltar</a></p>";
    die();
}

$usuario = getUsuarioId($idEmpresa);

if (!empty($usuario)) {
    echo "<p>Não é possível excluir, exitem usuários cadastrados.<br><a href='/admin/empresas/'>Clique para voltar</a></p>";
    die();
}

$delete = deleteEmpresaId($idEmpresa);

if ($delete) {
    header("location: /admin/empresas/?status=200");
    exit();
} else {
    echo "<p>Erro ao deletar.<br><a href='/admin/empresas/'>Clique para voltar</a></p>";
    die();
}

function getEmpresaId(int $id) {
    $PDO = db_connect();
    $sql = "SELECT EMPRESA_VIDEO FROM VIDEOS WHERE EMPRESA_VIDEO = :EMPRESA_VIDEO";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_VIDEO', $id, PDO::PARAM_INT);
    
    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar empresa: " . $e->getMessage());
    }

    return $result;
}

function getUsuarioId(int $id) {
    $PDO = db_connect();
    $sql = "SELECT ID_USUARIO FROM USUARIOS WHERE EMPRESA_USUARIO = :EMPRESA_USUARIO";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':EMPRESA_USUARIO', $id, PDO::PARAM_INT);
    
    try{
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        throw new Exception("Erro ao carregar usuário: " . $e->getMessage());
    }

    return $result;
}


function deleteEmpresaId(int $id) {
    $PDO = db_connect();
    $sql = "DELETE FROM EMPRESAS
            WHERE ID_EMPRESA = :ID_EMPRESA LIMIT 1";
    
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':ID_EMPRESA', $id, PDO::PARAM_INT);
    
    try{
        $stmt->execute();
        $result = true;
    } catch(PDOException $e) {
        throw new Exception("Erro ao deletar empresa: " . $e->getMessage());
    }

    return $result;
}