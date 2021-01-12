<?php
require_once 'control.php';
require_once '_header.php';
?>

<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container-fluid">

        <a href="/" class="navbar-brand">
            <img src="./img/logo.png" alt="Logo WoW Life" height="50">
        </a>

        <div class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                <img src="./img/user.png" alt="Perfil">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="/logout.php">Sair</a>
            </div>
        </div>
		  
    </div>
</nav>

<?php
$idPrograma = $_GET['programa'] ?: 1;

if (empty($_SESSION['USUARIO_ID'])) {
    echo "Aconteceu algum erro, <a href='/logout.php'>Clique aqui</a> para entrar novamente.";
    die();
}

$arrProgresso = getAulaAtualDoUsuario($_SESSION['USUARIO_ID'], $idPrograma);
$aulaAtual = $arrProgresso['AULA_ATUAL'];
$currentStep = $arrProgresso['ETAPA'];

if ($_GET['etapa'] <= $arrProgresso['ETAPA']) {
    $currentStep = $_GET['etapa'] ?: $arrProgresso['ETAPA'];
}

$arrPrograma = getPrograma($idPrograma);
$arrAulas = agruparPorAula(
    getAulasDoPrograma($idPrograma)
);

if (empty($arrPrograma)) {
    echo "Programa não encontrado.";
}

?>

<div class="bg-light w-100 py-4 text-center">
    <span class="font-weight-bold text-muted">
        <?= $arrPrograma[0]['NOME_PROGRAMA'] ?>
    </span>
</div>

<div class="container-fluid">
    <div class="row">

        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">

                <?php if (!empty($arrPrograma)) : ?>
                <ul class="nav flex-column">

                    <?php $step = 1; ?>
                    <?php foreach ($arrPrograma as $etapa) : ?>

                        <?php
                        $showAula = ($currentStep == $step) ? true : false;
                        $disabledAula = ($arrProgresso['ETAPA'] < $step) ? 'disabled' : '';
                        ?>

                        <li class="nav-item d-flex justify-content-between align-items-center">
                            <a href="<?= $_SERVER["PHP_SELF"] ?>?etapa=<?= $step ?>" class="nav-link <?= $disabledAula ?>">
                                <?= $etapa['NOME_ETAPA'] ?>
                                <?php if ($arrProgresso['FL_CONCLUIDO'] && ($arrProgresso['ETAPA'] > $step)) : ?>
                                <i class="fas fa-check-circle text-success"></i>
                                <?php endif; ?>
                            </a>
                            <?php if ($etapa['FL_PREMIO_ETAPA']) : ?>
                                <!-- <span><i class="fas fa-medal text-warning"></i></span> -->
                            <?php endif; ?>
                        </li>
  
                        <?php if ($showAula) : ?>
                        <div class="list-group list-group-reset">
        
                            <?php if ($arrAulas[$step]) : ?>
                                <?php foreach ($arrAulas[$step] as $aula) : ?>
                                <?php $arrAula = getDadosAula($aula['ID_AULA'], $aula['FL_RECEITA_AULA']); ?>
                                <li class="list-group-item py-1">
                                    <?php
                                    if ($aula['FL_RECEITA_AULA']) {
                                        echo $arrAula['NOME_RECEITA'];
                                    } else {
                                        echo $arrAula['NOME_VIDEO'];
                                    }
                                    ?>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
        
                        </div>
                        <?php endif; ?>

                        <?php $step++; ?>
                    <?php endforeach; ?>

                </ul>
                <?php endif; ?>
                
            </div>
        </nav><!-- end sidebar -->

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5 max-container">

            <?php

            $programaAtual = array_filter($arrPrograma, function($value) use ($currentStep) {
                return ($value['ID_ETAPA'] == $currentStep);
            });

            $dadosPrograma = current($programaAtual);
            ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
                <h2 class="h4 font-weight-bold"><?= $dadosPrograma['NOME_ETAPA'] ?></h2>
            </div>

            <?php

            if ($_GET['aula']) {
                $dadosAula = getAulaById($_GET['aula']);
            }

            if (!empty($dadosAula)) {
                ?>

                <?php if ($dadosAula['FL_RECEITA_AULA']) : ?>
                    <div class="mb-3">
                        <h1 class="h2"><?= $dadosAula['NOME_RECEITA'] ?></h1>
                        <?php if ($dadosAula['IMG_RECEITA']) : ?>
                        <p><img src="./uploads/<?= $dadosAula['IMG_RECEITA']; ?>" alt="<?= $dadosAula['NOME_RECEITA'] ?>" class="img-fluid"></p>
                        <?php endif; ?>
                        <p><?= $dadosAula['DESCRICAO_RECEITA']; ?></p>
                    </div>
                <?php else : ?>
                    <div class="mb-3">
                        <h1 class="h3 font-weight-bold"><?= $dadosAula['NOME_VIDEO'] ?></h1>

                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?= $dadosAula['LINK_VIDEO']; ?>?title=0&byline=0&portrait=0&badge=0&showinfo=0&modestbranding=0" frameborder="0"></iframe>
                        </div>
                    </div>
                <?php endif; ?>
                <?php

                    $arrProximaAula = getDadosProximaAula($arrAulas[$currentStep], $dadosAula['ID_AULA']);
            }
            ?>

            <?php if (!empty($dadosAula)) : ?>
            <div class="d-flex justify-content-between">
                <div></div>
                <?php if (!empty($arrProximaAula)) : ?>
                <div>
                    <?php if ($arrProximaAula['FL_CONCLUIR']) : ?>
                        <?php $urlProximaAula = "/concluir-etapa.php?programa=".$idPrograma."&etapa=".$_GET['etapa']; ?>
                        <a href="<?= $urlProximaAula ?>" class="btn btn-dark">Concluir</a>
                    <?php else : ?>
                        <?php $urlProximaAula = "/programa.php?etapa=".$_GET['etapa']."&aula=".$arrProximaAula['ID_AULA']; ?>
                        <a href="<?= $urlProximaAula ?>" class="btn btn-dark">Próxima</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php

            if ($arrAulas[$currentStep] && empty($_GET['aula'])) {
                foreach ($arrAulas[$currentStep] as $value) {
                    $dashAula = getDadosAula($value['ID_AULA'], $value['FL_RECEITA_AULA']);
                    $url = "/programa.php?etapa=".$value['FK_ETAPA']."&aula=".$dashAula['ID_AULA'];
                    ?>
                    <a class="d-block mb-3" href="<?= $url ?>">
                        <?php if ($dashAula['FL_RECEITA_AULA']) : ?>
                            <?php if ($dashAula['IMG_RECEITA']) : ?>
                            <img src="./uploads/<?= $dashAula['IMG_RECEITA']; ?>" alt="<?= $dashAula['NOME_RECEITA'] ?>" class="img-fluid">
                            <?php else : ?>
                            <?= $dashAula['NOME_RECEITA']; ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if ($dashAula['THUMB_VIDEO']) : ?>
                            <img src="./uploads/<?= $dashAula['THUMB_VIDEO']; ?>" alt="<?= $dashAula['NOME_VIDEO'] ?>" class="img-fluid">
                            <?php else : ?>
                            <?= $dashAula['NOME_VIDEO']; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                    <?php
                }
            }
            ?>
        </main><!-- end main -->

    </div><!-- end row -->
</div><!-- end container -->

<!-- Modal -->
<?php $showModal = $_GET['show'] ? 'data-show="true"' : ''; ?>
<div class="modal fade" id="modalConcluirAula" tabindex="-1" <?= $dataShow; ?> aria-labelledby="modalConcluirAula" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header border-bottom-0">
            <h5 class="modal-title">Parabéns</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Você concluir a aula de hoje</p>
        </div>
    </div>
  </div>
</div>

<?php require_once '_footer.php'; ?>

<script>
$(document).ready(function () {
    $('[data-show]').modal('show');
});
</script>
