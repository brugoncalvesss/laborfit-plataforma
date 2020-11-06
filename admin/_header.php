<?php
ob_start();
session_start();
?>
<!doctype html>
<html lang="pt-br">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

		<!-- FontAwesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
		
		<link rel="stylesheet" href="/admin/css/style.css">

		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/3.20.0/tagify.min.css">
		
		<script src="/admin/js/jquery-latest.min.js"></script>

		<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    	<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/translations/pt-br.js"></script>

		<title>Plataforma</title>
	</head>
	<body>
	
	<?php
	if (!isset($_SESSION['LEMBRAR_USUARIO'])) {
		header("location: /admin/login/logout.php?status=redirect");
		exit;
	}

	require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/init.php';
	?>