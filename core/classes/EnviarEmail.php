<?php

namespace core\classes;

//require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
//require './vendor/phpmailer/phpmailer/src/SMTP.php';
//require './vendor/phpmailer/phpmailer/src/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use League\OAuth2\Client\Provider\Google;



class EnviarEmail {
    
    // Função para enviar o e-mail de confirmação de conta de cadastro de cliente
    public function enviar_email_confirmacao($email_cliente, $purl) {

        $link = BASE_URL . '?a=confirmar_email&purl=' . $purl;

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = EMAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL_FROM;                     //SMTP username
            $mail->Password   = EMAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = EMAIL_PORT;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                 
            
            
            //Recipients
            $mail->setFrom('sempreviva.americana@gmail.com', 'PHPSTORE');
            $mail->addAddress($email_cliente);     //Add a recipient
            //var_dump($email_cliente);

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);       
            $mail->CharSet="UTF8";                           //Set email format to HTML
            $mail->Subject = APP_NAME.' - Confirmação de E-mail';
            $html = '<p> Seja bem vindo à nossa loja ' . APP_NAME . '</p>';
            $html .= '<p> Para porder entrar na nossa loja, você necessita confirmar seu e-mail.</p>';
            $html .= '<p> Para confirmar o seu e-mail, clique no link abaixo: </p>';
            $html .= '<p><a href="'.$link.'">Confirmar E-mail</a></p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';
            $mail->Body = $html;
            

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }


    }

    // Função para enviar o e-mail de confirmação de conta de cadastro de cliente
    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda) {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = EMAIL_HOST;                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL_FROM;                     //SMTP username
            $mail->Password   = EMAIL_PASS;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = EMAIL_PORT;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
                 
            
            
            //Recipients
            $mail->setFrom('sempreviva.americana@gmail.com', 'PHPSTORE');
            $mail->addAddress($email_cliente);     //Add a recipient
            //var_dump($email_cliente);

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);       
            $mail->CharSet="UTF8";                           //Set email format to HTML
            $mail->Subject = APP_NAME.' - Confirmação de Encomenda - XXXXXXXX';
            $html = '';
            $mail->Body = $html;
            

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }


    }
}