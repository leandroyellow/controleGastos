<?php

namespace App\Controller\Pages;

use App\Http\Request;
use \App\Utils\View;

class Page
{

  /**
   * método responsável por renderizar o topo da página
   * @return string
   */
  private static function getHeader()
  {
    return View::render('pages/header');
  }

  /**
   * método responsável por renderizar o rodapé da página
   * @return string
   */
  private static function getFooter()
  {
    return View::render('pages/footer');
  }

  /**
   * Método responsável por renderizar o layout da paginação
   * @param Request $request
   * @param Pagination $obpagination
   * @return string
   */
  public static function getPagination($request, $obpagination)
  {
    //PÁGINAS
    $pages = $obpagination->getPages();

    //VERIFICA A QUANTIDADE DE PÁGINAS
    if (count($pages) <= 1) return '';

    //LINKS
    $links = '';

    //URL ATUAL (SEM GETS)
    $url = $request->getRouter()->getCurrentUrl();

    //GET
    $queryParams = $request->getQueryParams();

    //RENDERIZA OS LINKS
    foreach ($pages as $page) {
      //ALTERA A PAGINA
      $queryParams['page'] = $page['page'];

      //LINK
      $link = $url . '?' . http_build_query($queryParams);

      //VIEW
      $links .= View::render('pages/pagination/link', [
        'page' => $page['page'],
        'link' => $link,
        'active' => $page['current'] ? 'active' : ''
      ]);
    }

    //RENDERIZA BOX DE PAGINAÇÃO
    return View::render('pages/pagination/box', [
      'links' => $links
    ]);
  }


  /**
   * Método responável por retornar (view) da nossa página genérica
   * @param string $title
   * @param string $content
   * @return string
   */
  public static function getPage($title, $content)
  {
    return View::render('pages/page', [
      'title' => $title,
      'header' => self::getHeader(),
      'content' => $content,
      'footer' => self::getFooter()
    ]);
  }
}
