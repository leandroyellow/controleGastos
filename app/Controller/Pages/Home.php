<?php

namespace App\Controller\Pages;

use \App\Utils\View;


class Home extends Page
{

  /**
   * Método responável por retornar (view) da nossa home
   * @return string
   */
  public static function getHome()
  {
    

    //view da home
    $content = View::render('pages/home', [
     
    ]);

    //retorna  a view da página
    return parent::getPage('home', $content);
  }
}
