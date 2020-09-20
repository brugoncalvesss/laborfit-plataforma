<?php
require_once './functions.php';

$data = filter_input_array(INPUT_POST);

if (empty($data)) {
    die('Erro: CPF não informado.');
}

$data['CPF_USUARIO'] = limparCaracteres($data['CPF_USUARIO']);

$PDO = db_connect();
$sql = "SELECT EMAIL_USUARIO FROM
            USUARIOS
        WHERE
            USUARIOS.CPF_USUARIO = :CPF_USUARIO
        LIMIT 1";

$stmt = $PDO->prepare($sql);
$stmt->bindParam(':CPF_USUARIO', $data['CPF_USUARIO']);

try{
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    throw new Exception("Erro ao carregar usuário: " . $e->getMessage());
}

if (empty($result['EMAIL_USUARIO'])) {
    die("Erro: Seu cadastro não possue e-mail cadastrado.");
}

require './phpmailer/PHPMailerAutoload.php';

$prefix = rand(1001, 9999);
$enconde = base64_encode($data['CPF_USUARIO']);
$url = "http://wowlife.com.br/reset.php?q=" . $prefix . $enconde;

$html_content = "<div>
    <h1>Recuperar senha</h1>
    <p>
        <a href='".$url."'>Clique aqui</a> para recuperar a senha.
    </p>
</div>";

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->CharSet = 'utf-8';
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "wowlife.com.br";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "noreply@wowlife.com.br";
//Password to use for SMTP authentication
$mail->Password = "%+&l!t;1!?kG";
//Set who the message is to be sent from
$mail->setFrom('noreply@wowlife.com.br', 'wowlife');
//Set an alternative reply-to address
// $mail->addReplyTo('noreply@wowlife.com.br', 'wowlife');
//Set who the message is to be sent to
$mail->addAddress($result['EMAIL_USUARIO']);
//Set the subject line
$mail->Subject = 'WoW Life: Recuperar senha';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($html_content);
//Replace the plain text body with one created manually
$mail->AltBody = 'Recuperar senha';
//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    header('Location: /success.php?status=200');
    exit();
}
