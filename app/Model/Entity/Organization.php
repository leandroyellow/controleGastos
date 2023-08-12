<?php 

namespace App\Model\Entity;

class Organization {
  /**
   * id da organização
   * @var integer
   */
  public $id = 1;

  
  /**
   * nome da organização
   * @var string
   */
  public $name = 'Leandro Queiroz Trepador';

  
  /**
   * site da organização
   * @var string
   */
  public $site = 'https://site.com';



  /**
   * descrição da organização
   * @var string
   */
  public $description = 'Sistema desenvolvido para controlar e gerencias suas finanças, controlando e observando todo o fluxo de caixa pessoal ou empresarial';

  /**
   * Contato telefone
   * @var string
   */
  public $telefone = '(16) 99185-5775';

  
  /**
   * Contato email
   * @var string
   */
  public $email = 'leandroqueiroztrepador@gmail.com';

}

?>