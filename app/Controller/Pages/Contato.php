<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;

class Contato extends Page
{

  /**
   * Método responável por retornar (view) da página de contato
   * @return string
   */
  public static function getContato()
  {
    $obOrganization = new Organization;

    //VIEW DO FORMUÁRIO
    $content = View::render('pages/contato', [
      'name' => $obOrganization->name,
      'email' => $obOrganization->email,
      'telefone' => $obOrganization->telefone,
    ]);

    //RETORNA A VIEW DA PÁGINA
    return parent::getPage('contato', $content);
  }
}
