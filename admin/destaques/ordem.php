<?php require($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'); ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Vídeos em destaque</h1>
        </div>
        <div class="col text-sm-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalVideos">Adicionar vídeos</button>
        </div>
    </header>
    
    <div class="card mb-3">
        <?php

        $idDestaque = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$idDestaque) {
            die("Erro: #ID não informado.");
        }

        $PDO = db_connect();
        $sql = "SELECT * FROM
                    DESTAQUES_VIDEOS
                INNER JOIN VIDEOS ON
                    DESTAQUES_VIDEOS.ID_VIDEO = VIDEOS.ID_VIDEO
                WHERE
                    DESTAQUES_VIDEOS.ID_DESTAQUE = :ID_DESTAQUE
                    AND VIDEOS.STATUS_VIDEO = 1
                ORDER BY
                    DESTAQUES_VIDEOS.DATA_EXIBICAO
                ASC";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':ID_DESTAQUE', $idDestaque);
        
        try{
            $stmt->execute();
            $arDestaques = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
        }
        ?>

        <div id="sortable" data-destaque="<?= $idDestaque ?>">
        <?php if (count($arDestaques) > 0) : ?>
            <?php foreach ($arDestaques as $destaque) : ?>
            <div data-id="<?= $destaque['ID_VIDEO'] ?>" class="row align-items-center no-gutters border-bottom p-2" style="cursor: pointer;">
                <div class="col">
                    <i class="fas fa-sort mr-2"></i>
                    <span><?= $destaque['NOME_VIDEO'] ?></span>
                </div>
                <div class="col col-auto">
                    <?php
                    // $data = explode('-', $destaque['DATA_EXIBICAO']);
                    // echo $data[2] . "/" . $data[1] . "/" . $data[0];
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>

    </div>
</main>

<?php

$PDO = db_connect();
$sql = "SELECT ID_VIDEO FROM DESTAQUES_VIDEOS WHERE ID_DESTAQUE = :ID_DESTAQUE";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_DESTAQUE', $idDestaque);

try{
    $stmt->execute();
    $emDestaque = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
}

$idsEmDestaque = array_values(array_column($emDestaque, 'ID_VIDEO'));

$PDO = db_connect();
$sql = "SELECT * FROM
            VIDEOS
        WHERE
            VIDEOS.STATUS_VIDEO = 1
            AND VIDEOS.DESTAQUE_VIDEO = 1
        ORDER BY
            VIDEOS.ID_VIDEO
        DESC";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':ID_DESTAQUE', $idDestaque);

try{
    $stmt->execute();
    $arVideos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    throw new Exception("Erro ao carregar categorias: " . $e->getMessage());
}
?>
<!-- Modal -->
<div class="modal fade" id="modalVideos" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVideosLabel">Vídeos com destaque</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php if (!empty($arVideos)) : ?>
        <form action="/admin/destaques/put.php" method="post">
            <input type="hidden" name="ID_DESTAQUE" class="form-control" value="<?= $idDestaque; ?>">

            <?php foreach ($arVideos as $video) : ?>
            <div class="form-group form-check mb-0">
                <?php $checked = in_array($video['ID_VIDEO'], $idsEmDestaque) ? 'checked': ''; ?>
                <input type="checkbox" class="form-check-input" name="ID_VIDEO[]" id="labelVideo-<?= $video['ID_VIDEO'] ?>" value="<?= $video['ID_VIDEO'] ?>" <?= $checked ?>>
                <label class="form-check-label" for="labelVideo-<?= $video['ID_VIDEO'] ?>"><?= $video['NOME_VIDEO'] ?></label>
            </div>
            <?php endforeach; ?>

            <button type="submit" class="btn btn-primary mt-3">Salvar</button>
        </form>
        <?php else: ?>
        <div class="alert alert-info">Nenhum vídeo com destaque.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'); ?>