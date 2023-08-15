<?php 

namespace App\Model\Entity;

use App\Db\Database;

class User {

  /**
   * ID do usuário
   * @var integer
   */
  public $id;

  /**
   * Nome do usuário
   * @var string
   */
  public $nome;

  /**
   * Email do usuário
   * @var string
   */
  public $email;

  /**
   * login do usuário
   * @var string
   */
  public $usuario;

  /**
   * Senha do usuário
   * @var string
   */
  public $senha;


  public static function getUserByUsuario ($usuario) {
    return (new Database('usuarios'))->select('usuario = "'.$usuario.'"')->fetchObject(self::class);
  }
}