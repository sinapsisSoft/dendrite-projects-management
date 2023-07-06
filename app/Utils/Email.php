<?php

namespace App\Utils;

use App\Models\EmailModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Email
{

  private $emailModel;
  private $mail;
  private $body;
  private $subject;
  private $message;

  public function __construct()
  {
    $this->emailModel = new EmailModel();
    $this->mail = new PHPMailer(true);
  }

  public function sendEmail($data, $email, $type)
  {
    // ini_set( 'display_errors', 1 );
    // error_reporting( E_ALL );
    if($type == 1){      
      $this->subject =  'Novedades del proyecto ' . $data[0]->Project_name;
      $this->body = '<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
            
      <div style="font-size: 16px; color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;">Hola, se han realizado cambios en el proyecto <strong>' . $data[0]->Project_name . '</strong></p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table>    
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">            
      <div style="font-size: 14px; font-weight: 400; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;">Los cambios efectuados corresponden a la actividad <strong>' . $data[0]->Activi_name . '</strong></p>
    </br>
    <p style="line-height: 140%;">La subactividad <strong>'. $data[0]->SubAct_name .'</strong> del colaborador <strong>'. $data[0]->User_name .'</strong> ha sido marcada como finalizada</p>
    </br>
    <p style="line-height: 140%;">Revisa las subactividades del proyecto <a href="' . $_SERVER['HTTP_HOST'] . '/subactivities?activitiesId=' . $data[0]->Activi_id . '" target="_blank">aquí</a></p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table> ';
    }
    else if($type == 2){
      $this->subject =  'Notificación del proyecto ' . $data[0]->Project_name;
      $this->body = '<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">            
      <div style="font-size: 16px; color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;">Hola, se han realizado cambios en el proyecto <strong>' . $data[0]->Project_name . '</strong></p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table>    
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
            
      <div style="font-size: 14px; font-weight: 400; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;">El colaborador <strong>'. $data[0]->User_name .'</strong> ha enviado una notificación desde la plataforma sobre la actividad <strong>' . $data[0]->Activi_name . '</strong></p>
    </br>
    <p style="line-height: 140%;"><strong>Notificación </strong></p>
    </br>
    <p style="line-height: 140%;"><strong>Asunto:</strong> '. $data[0]->subject . '</p>
    </br>
    <p style="line-height: 140%;"><strong>Link adjunto: </strong>'. $data[0]->link . '</p>
    </br>
    <p style="line-height: 140%;"><strong>Detalle: </strong>'. $data[0]->message . '</p>
    </br>
    <p style="line-height: 140%;">Revisa las subactividades del proyecto <a href="' . $_SERVER['HTTP_HOST'] . '/subactivities?activitiesId=' . $data[0]->Activi_id . '" target="_blank">aquí</a></p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table> ';
    }
    else if($type == 3){
      $this->subject =  'Nuevo proyecto creado: ' . $data[0]->Project_name;
      $this->body = '<table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">            
      <div style="font-size: 16px; color: #000000; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;">Hola, se ha creado el proyecto <strong>' . $data[0]->Project_name . '</strong></p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table>    
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
            
      <div style="font-size: 14px; font-weight: 400; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;">El proyecto creado es pertenece a la marca <strong>'. $data[0]->Brand_name .'</strong> del gerente <strong>'. $data[0]->Manager_name .'</strong> del cliente <strong>'. $data[0]->Client_name .'</strong></p>
    </br>
    <p style="line-height: 140%;"><strong>Detalle del proyecto </strong></p>
    </br>
    <p style="line-height: 140%;"><strong>Orden de compra:</strong> '. $data[0]->Project_purchaseOrder . '</p>
    </br>
    <p style="line-height: 140%;"><strong>Fecha de inicio del proyecto: </strong>'. $data[0]->Project_startDate . '</p>
    </br>
    <p style="line-height: 140%;"><strong>Prioridad: </strong>'. $data[0]->Priorities_name . '</p>
    </br>
    <p style="line-height: 140%;">Revisa el proyecto <a href="' . $_SERVER['HTTP_HOST'] . '/details?projectId=' . $data[0]->Project_id . '" target="_blank">aquí</a></p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table> ';
    }
    $this->message = '<!DOCTYPE html>
    <head>
    <!--[if gte mso 9]>
    <xml>
      <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="x-apple-disable-message-reformatting">
      <!--[if !mso]><!--><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
      <title></title>
      
        <style type="text/css">
          @media only screen and (min-width: 520px) {
      .u-row {
        width: 500px !important;
      }
      .u-row .u-col {
        vertical-align: top;
      }
    
      .u-row .u-col-100 {
        width: 500px !important;
      }
    
    }
    
    @media (max-width: 520px) {
      .u-row-container {
        max-width: 100% !important;
        padding-left: 0px !important;
        padding-right: 0px !important;
      }
      .u-row .u-col {
        min-width: 320px !important;
        max-width: 100% !important;
        display: block !important;
      }
      .u-row {
        width: 100% !important;
      }
      .u-col {
        width: 100% !important;
      }
      .u-col > div {
        margin: 0 auto;
      }
    }
    body {
      margin: 0;
      padding: 0;
    }
    
    table,
    tr,
    td {
      vertical-align: top;
      border-collapse: collapse;
    }
    
    p {
      margin: 0;
    }
    
    .ie-container table,
    .mso-container table {
      table-layout: fixed;
    }
    
    * {
      line-height: inherit;
    }
    
    a[x-apple-data-detectors="true"] {
      color: inherit !important;
      text-decoration: none !important;
    }
    
    table, td { color: #000000; } </style>
      
      
    
    </head>
    
    <body class="clean-body u_body" style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #e7e7e7;color: #000000">
      <!--[if IE]><div class="ie-container"><![endif]-->
      <!--[if mso]><div class="mso-container"><![endif]-->
      <table style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #e7e7e7;width:100%" cellpadding="0" cellspacing="0">
      <tbody>
      <tr>
        <td style="display:none !important;visibility:hidden;mso-hide:all;font-size:1px;color:#ffffff;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
          Se han registrado cambios en un proyecto
        </td>
      </tr>
      
      <tr style="vertical-align: top">
        <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
        <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #e7e7e7;"><![endif]-->
        
    
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
      <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->
          
    <!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
    <div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
      <div style="height: 100%;width: 100% !important;">
      <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;"><!--<![endif]-->
      
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
            
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
      <tr>
        <td style="padding-right: 0px;padding-left: 0px;" align="center">
          
          <img align="center" border="0" src="' . $_SERVER['HTTP_HOST'] . '/public/assets/img/logos/logo_slogan.png" alt="" title="Abrir aplicación" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 480px;" width="480"/>
          
        </td>
      </tr>
    </table>
    
          </td>
        </tr>
      </tbody>
    </table>
    
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">
            
      <table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
        <tbody>
          <tr style="vertical-align: top">
            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
              <span>&#160;</span>
            </td>
          </tr>
        </tbody>
      </table>
    
          </td>
        </tr>
      </tbody>
    </table>
    
    ' . $this->body .'   
      <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
      </div>
    </div>
    <!--[if (mso)|(IE)]></td><![endif]-->
          <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
      <div class="u-row" style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
        <div style="border-collapse: collapse;display: table;width: 100%;height: 100%;background-color: transparent;">
          <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->
          
    <!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;" valign="top"><![endif]-->
    <div class="u-col u-col-100" style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
      <div style="height: 100%;width: 100% !important;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;">
      <!--[if (!mso)&(!IE)]><!--><div style="box-sizing: border-box; height: 100%; padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;border-radius: 0px;-webkit-border-radius: 0px; -moz-border-radius: 0px;"><!--<![endif]-->      
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">            
      <table height="0px" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
        <tbody>
          <tr style="vertical-align: top">
            <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
              <span>&#160;</span>
            </td>
          </tr>
        </tbody>
      </table>    
          </td>
        </tr>
      </tbody>
    </table>    
    <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
      <tbody>
        <tr>
          <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;" align="left">            
      <div style="font-size: 10px; font-weight: 700; line-height: 140%; text-align: center; word-wrap: break-word;">
        <p style="line-height: 140%;">Este es un mensaje generado automáticamente por el sistema. Por favor, no responda a este e-mail.</p>
    <p style="line-height: 140%;">Cualquier duda que tenga, comuníquese directamente con el administrador del sistema.</p>
      </div>    
          </td>
        </tr>
      </tbody>
    </table>    
      <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
      </div>
    </div>
    <!--[if (mso)|(IE)]></td><![endif]-->
          <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>
        <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
        </td>
      </tr>
      </tbody>
      </table>
      <!--[if mso]></div><![endif]-->
      <!--[if IE]></div><![endif]-->
    </body>    
    </html>';    
    $emailSetting = $this->emailModel->findAll()[0];
    try {
      $this->mail->SMTPDebug = 0;                                                     // Enable verbose debug output
      $this->mail->isSMTP();
      $this->mail->Host  = $emailSetting["Email_host"];
      $this->mail->SMTPAuth   = true;                                                 // Enable SMTP authentication
      $this->mail->Username   = $emailSetting["Email_user"];         // SMTP username
      $this->mail->Password   = $emailSetting["Email_pass"];
      $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $this->mail->Port       = $emailSetting["Email_puerto"];
      $this->mail->setFrom($emailSetting["Email_user"], 'Market Support');
      $this->mail->addAddress($email);
      $this->mail->isHTML(true);  
      $this->mail->Subject = $this->subject;
      $this->mail->Body = $this->message;
      $this->mail->CharSet = 'utf-8';
      $this->mail->send();
      return 1;
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
      return 0;
    }
  }
}
