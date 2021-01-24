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
$idUsuario = $_SESSION['USUARIO_ID'];
$idEtapa = $_GET['etapa'] ?: 1;

if (empty($_SESSION['USUARIO_ID'])) {
    echo "Aconteceu algum erro, <a href='/logout.php'>Clique aqui</a> para entrar novamente.";
    die();
}

$arrPrograma = getPrograma($idPrograma);
$arrEtapasCompletas = getEtapasCompletas($idUsuario, $idPrograma);
$iconEtapaCompleta = getIconEtapaCompleta($idPrograma);
$arModalPersonalizado = getModalPersonalizado($idPrograma);

$arProgresso = $arrEtapasCompletas;
if (empty($arrEtapasCompletas)) {
    $arProgresso[] = 1;
} else {
    $arProgresso[] = end($arProgresso) + 1;
}

?>

<div class="bg-wave-primary w-100 py-5 text-center">
    <h2 class="text-white font-weight-bold text-muted">
        <?= $arrPrograma[0]['NOME_PROGRAMA'] ?>
    </h2>
</div>

<div class="container-fluid">
    <div class="row">

        <div class="w-100 d-block">
            <div class="container">
                <div class="mt-3 text-right d-md-none">
                    <button class="btn btn-light" type="button" data-toggle="collapse" data-target="#sidebarMenu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light pr-0 sidebar collapse">
            <div class="position-sticky pt-3 mb-5">
                <div class="nav-scroll">
                    <?php $arNavegacaoPrograma = getNavegacaoProgramaV2($idPrograma); ?>
                    <?php if (!empty($arNavegacaoPrograma)) : ?>
                    <ul class="nav flex-column">

                        <a class="nav-link pl-0 font-weight-bold" href="introducao.php?programa=<?= $idPrograma; ?>">
                            Introdução
                        </a>

                        <?php foreach ($arNavegacaoPrograma as $topico) : ?>

                            <?php
                            $etapaCompleta = '';
                            $etapaClasse = '';
                            $disabled = 'disabled';

                            if (in_array($topico['ID_ETAPA'], $arrEtapasCompletas)) {
                                $etapaCompleta = '<i class="fas fa-check-circle"></i>';
                                $etapaClasse = 'active';
                            }

                            if ($topico['ID_ETAPA'] <= end($arProgresso)) {
                                $disabled = '';
                            }

                            ?>
                            <a class="link-etapa d-flex justify-content-between align-items-center <?= $etapaClasse; ?>" data-toggle="collapse" href="#grupo-<?= $topico['ID_ETAPA'] ?>">
                                <div>
                                    <span class="font-weight-bold">
                                        <?= $topico['NOME_ETAPA']; ?>
                                        <?= $etapaCompleta; ?>
                                    </span>
                                </div>
                                <?php if ($topico['FL_PREMIO_ETAPA'] && $etapaCompleta) : ?>
                                <div>
                                    <?php if ($iconEtapaCompleta[$topico['ID_ETAPA']]) : ?>
                                    <img src="<?= $iconEtapaCompleta[$topico['ID_ETAPA']]; ?>">
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </a>

                            <?php
                            $showCollapse = '';
                            if ($idEtapa == $topico['ID_ETAPA']) {
                                $showCollapse = 'show';
                            }
                            ?>

                            <div class="collapse <?= $showCollapse; ?>" id="grupo-<?= $topico['ID_ETAPA'] ?>">
                                <nav>
                                    <?php foreach($topico['AULAS'] as $aula) : ?>
                                        <?php $urlAula = "/programa.php?programa=".$aula['FK_PROGRAMA']."&etapa=".$aula['FK_ETAPA']."&aula=".$aula['ID_AULA']; ?>
                                        
                                        <a href="<?= $urlAula; ?>" class="nav-link py-1 <?= $disabled; ?>">
                                            <?= $aula['NOME']; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </nav>
                            </div>

                        <?php endforeach; ?>

                    </ul>
                    <?php endif; ?>
                </div><!-- end scroll -->
            </div>
        </nav><!-- end sidebar -->

        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 mb-5 max-container">

            <?php
            $idAula = $_GET['aula'] ?: getPrimeiraAula($idPrograma)['ID_AULA'];
            $arConteudoAula = getConteudoAulaId($idAula);
            ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
                <h2 class="h4 font-weight-bold"><?= $arConteudoAula['NOME_ETAPA'] ?></h2>
            </div>

            <div class="row">
                <div class="col-md-10">
                <?php if ($arConteudoAula['FL_RECEITA_AULA']) : ?>
                    <div class="mb-3">
                        <h1 class="h3 font-weight-bold"><?= $arConteudoAula['NOME_RECEITA'] ?></h1>
                        <?php if ($arConteudoAula['IMG_RECEITA']) : ?>
                        <p><img src="./uploads/<?= $arConteudoAula['IMG_RECEITA']; ?>" alt="<?= $arConteudoAula['NOME_RECEITA'] ?>" class="img-fluid"></p>
                        <?php endif; ?>
                        <p><?= $arConteudoAula['DESCRICAO_RECEITA']; ?></p>
                    </div>
                <?php else : ?>
                    <div class="mb-3">
                        <h1 class="h3 font-weight-bold"><?= $arConteudoAula['NOME_VIDEO'] ?></h1>

                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/<?= $arConteudoAula['LINK_VIDEO']; ?>?title=0&byline=0&portrait=0&badge=0&showinfo=0&modestbranding=0" frameborder="0"></iframe>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                $arNavegacao = getNavegacaoProximaAula($idPrograma, $idAula, $idEtapa);
                $urlProximaAula = getUrlProximaAula($arNavegacao);
                ?>

                <hr class="mt-4 hr">

                    <div class="d-flex justify-content-between">
                        <div>
                            <h6>Gostou do conteúdo?</h6>
                            <ul class="list-inline">
                                <?php
                                $meuVoto = getMeuLikeNaAula($idAula, $idUsuario);

                                if (empty($meuVoto)) {
                                    $meuVoto = 0;
                                }

                                if (!empty($meuVoto)) {
                                    $meuVoto = $meuVoto['NM_LIKE'];
                                }

                                $heart = 1;
                                while ($heart <= 5) : ?>
                                <li class="list-inline-item">
                                    <?php
                                    $imgLike = ($meuVoto >= $heart) ? 'active' : '';
                                    $referencia = base64_encode($_SERVER["REQUEST_URI"]);
                                    $urlVoto = "/votar.php?usuario=".$idUsuario."&aula=".$idAula."&voto=".$heart."&referencia=".$referencia;
                                    ?>
                                    <a href="<?= $urlVoto; ?>">
                                        <span class="d-block ico-fav <?= $imgLike; ?>"></span>
                                    </a>
                                </li>
                                <?php
                                $heart++;
                                endwhile;
                                ?>
                            </ul>
                        </div>
                        <div>
                            <?php
                            if ($arNavegacao['FL_COMPLETO']) {
                                $urlProximaAula = "/concluir.php?q=". base64_encode($urlProximaAula);
                            }
                            ?>

                            <a class="btn btn-primary" href="<?= $urlProximaAula ?>">
                                <?= ($arNavegacao['FL_COMPLETO']) ? 'Concluir' : 'Próxima'; ?>
                            </a>

                        </div>
                    </div>

                </div>
            </div>

        </main><!-- end main -->

    </div><!-- end row -->
</div><!-- end container -->

<!-- Modal -->
<?php if ($_GET['completo']) : ?>
<?php
$modalPersonalizado = getIdModalPersonalizado($idPrograma, $idEtapa);
?>

    <?php if (empty($modalPersonalizado)) : ?>
    <div class="modal fade opacity-80" id="modalConcluirAula" tabindex="-1" data-show="true" aria-labelledby="modalConcluirAula" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title">Parabéns</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Você concluiu a aula de hoje</p>
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
    <div class="modal fade modal-transparent" id="modalConcluirAula" tabindex="-1" data-show="true" aria-labelledby="modalConcluirAula" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0 text-center">
                    <img data-dismiss="modal" src="<?= $arModalPersonalizado[$modalPersonalizado['ID_ETAPA']]; ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>

<?php require_once '_footer.php'; ?>

<script>
$(document).ready(function () {
    $('[data-show]').modal('show');
});
</script>
