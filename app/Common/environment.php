<?php 

namespace App\Common;

class Environment {

  /**
   * Método responsável por carregar as variáveis de ambiente do projeto
   * @param string $dir caminho absoluto da pasta onde encontra-se o arquivo .env
   */
  public static function load($dir) {
    //VERIFICA SE O ARQUIVO .ENV EXISTE
    if(!file_exists($dir. '/.env')){
      return false;
    }

    //DEFINE AS VARIÁVEIS DE AMBIENTE
    $lines = file($dir.'/.env');
    foreach ($lines as $line) {
      putenv(trim($line));
    }
  }
}

?>