<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_header.php'; ?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    
    <header class="row my-3">
        <div class="col">
            <h1 class="h3 my-0">Usuários</h1>
        </div>
        <div class="col text-sm-right">
            <a class="btn btn-secondary btn-sm" href="/admin/usuarios/lote.php">Cadastrar em lote</a>
            <a class="btn btn-primary btn-sm" href="/admin/usuarios/novo.php">Novo</a>
        </div>
    </header>
    
    <div class="mb-3">
    <?php
        $PDO = db_connect();
        $sql = "SELECT * FROM USUARIOS
                LEFT JOIN EMPRESAS ON
                    EMPRESAS.ID_EMPRESA = USUARIOS.EMPRESA_USUARIO
                WHERE USUARIOS.STATUS_USUARIO >= 0 ORDER BY USUARIOS.NOME_USUARIO ASC";
        $stmt = $PDO->prepare($sql);
    
        try{
            $stmt->execute();
            $arResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Erro ao carregar admins: " . $e->getMessage());
        }
        ?>

        <?php if (count($arResult) > 0) : ?>
        <div class="table-responsive datatable-custom">
			<table id="usersDatatable" class="table card-table">
				<thead class="thead-light">
					<tr>
						<th>Nome</th>
						<th>Empresa</th>
                        <th></th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
                    <?php foreach ($arResult as $usuario) : ?>
                    <tr>
                        <td>
                            <i class="far fa-user mr-2"></i>
                            <span><?= $usuario['NOME_USUARIO'] ?></span>
                        </td>
                        <td><?= $usuario['NOME_EMPRESA'] ?></td>
                        <td>
                            <?php if ($usuario['STATUS_USUARIO']) : ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else : ?>
                                <span class="badge badge-secondary">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right">
                            <a class="btn-link mx-1" href="/admin/usuarios/editar.php?id=<?= $usuario['ID_USUARIO'] ?>">
                                <i class="far fa-edit"></i>
                            </a>
                            <a class="btn-link mx-1" href="/admin/usuarios/deletarUsuario.php?id=<?= $usuario['ID_USUARIO'] ?>">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div id="usersFiltered"></div>

    </div>
</main>

<?php require_once  $_SERVER['DOCUMENT_ROOT'] . '/admin/layout/_footer.php'; ?>