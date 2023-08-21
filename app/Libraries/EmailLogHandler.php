<?php
namespace App\Libraries;

use CodeIgniter\Log\Handlers\BaseHandler;

class EmailLogHandler extends BaseHandler{

  public$email;
 public function __construct(array $config) {
  
  parent::__construct($config);
  $this->email=\Config\Services::email();
 }
 
  public function handle($level,$message ):bool{

$this->email->setFrom('handlermailer@example.com')
->setTo('d.casallas@sinapsist.com.co')
->setSubject("Errores Ocurriendo en el Sistema".$level);
//->send();

return true;

  }
}


?>