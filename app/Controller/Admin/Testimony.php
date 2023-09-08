<?php

namespace App\Controller\Admin;


use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \App\Db\Pagination;


class Testimony extends Page
{

  /**
   * Método responsável por obter a renderização dos itens de depoimentos para a página
   * @param Request $request
   * @param Pagination $obpagination
   * @return string
   */
  private static function getTestimonyItens($request, &$obpagination)
  {
    //DEPOIMENTOS
    $itens = '';

    //QUANTIDADE TOTAL DE REGISTRO
    $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;


    //PÁGINA ATUAL
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;

    //INSTANCIA DE PAGINAÇÃO
    $obpagination = new Pagination($quantidadeTotal, $paginaAtual, 5);


    //RESULTADOS DA PAGINA
    $results = EntityTestimony::getTestimonies(null, 'id DESC', $obpagination->getLimit());

    //RENDERIZA O ITEM
    while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
      //VIEW DE DEPOIMENTOS
      $itens .= View::render('admin/modules/testimonies/item', [
        'id' => $obTestimony->id,
        'nome' => $obTestimony->nome,
        'mensagem' => $obTestimony->mensagem,
        'data' => date('d/m/Y H:i:s', strtotime($obTestimony->data))
      ]);
    }

    //RETORNA OS DEPOIMENTOS
    return $itens;
  }



  /**
   * Método responsável por renderizar a view de listagem de depoimentos
   * @param Request $request
   * @return string
   */
  public static function getTestimonies($request)
  {
    //CONTEÚDO DA HOME
    $content = View::render('admin/modules/testimonies/index', [
      'itens' => self::getTestimonyItens($request, $obpagination),
      'pagination' => parent::getPagination($request, $obpagination),
      'status' => self::getStatus($request)
    ]);

    //RETORNA A PÁGINA COMPLETA
    return parent::getPanel('Depoimentos > leandro', $content, 'testimonies');
  }

  /**
   * Método responspável de retornar o formulário de cadastro de um novo depoimento
   * @param Request $request
   * @return string
   */
  public static function getNewTestimony($request)
  {
    //CONTEÚDO DO FORMULÁRIO
    $content = View::render('admin/modules/testimonies/form', [
      'title' => 'Cadastrar depoimento',
      'nome' => '',
      'mensagem' => '',
      'status' => ''
    ]);

    //RETORNA A PÁGINA COMPLETA
    return parent::getPanel('Cadastrar depoimento > leandro', $content, 'testimonies');
  }

  /**
   * Método responspável por cadastrar um depoimento no banco
   * @param Request $request
   * @return string
   */
  public static function setNewTestimony($request)
  {
    //POST VARS
    $postVars = $request->getPostvars();

    //NOVA INSTÂNCIA DE DEPOIMENTO
    $obTestimony = new EntityTestimony;
    $obTestimony->nome = $postVars['nome'] ?? '';
    $obTestimony->mensagem = $postVars['mensagem'] ?? '';
    $obTestimony->cadastrar();

    //REDIRECIONA O USUÁRIO
    $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=created');
  }

  /**
   * Método responsável por retornar a mensagem de status
   * @param Request $request
   * @return string
   */
  private static function getStatus($request){
    //QUERY PARANS
    $queryParams = $request->getQueryParams();
    
    //STATUS
    if(!isset($queryParams['status'])) return '';

    //MENSAGEM DE STATUS
    switch ($queryParams['status']) {
      case 'created':
        return Alert::getSuccess('Depoimento criado com sucesso!');
        break;
      case 'updated':
        return Alert::getSuccess('Depoimento atualizado com sucesso!');
        break;
      case 'deleted':
        return Alert::getSuccess('Depoimento excluido com sucesso!');
        break;
    }
  }

  /**
   * Método responspável de retornar o formulário de edição de um depoimento
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function getEditTestimony($request, $id)
  {
    //OBTEM O DEPOIMENTO DO BANCO DE DADOS
    $obTestimony = EntityTestimony::getTestimonyById($id);

    //VALIDA A INSTANCIA
    if (!$obTestimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    //CONTEÚDO DO FORMULÁRIO
    $content = View::render('admin/modules/testimonies/form', [
      'title' => 'Editar depoimento',
      'nome' => $obTestimony->nome,
      'mensagem' => $obTestimony->mensagem,
      'status' => self::getStatus($request)
    ]);

    //RETORNA A PÁGINA COMPLETA
    return parent::getPanel('Editar depoimento > leandro', $content, 'testimonies');
  }

  /**
   * Método responspável gravar a atualização de um depoimento
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function setEditTestimony($request, $id)
  {
    //OBTEM O DEPOIMENTO DO BANCO DE DADOS
    $obTestimony = EntityTestimony::getTestimonyById($id);

    //VALIDA A INSTANCIA
    if (!$obTestimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    //POST VARS
    $postVars = $request->getPostvars();

    //ATUALIZA A INSTANCIA
    $obTestimony->nome = $postVars['nome'] ?? $obTestimony->nome;
    $obTestimony->mensagem = $postVars['mensagem'] ?? $obTestimony->mensagem;
    $obTestimony->atualizar();

    //REDIRECIONA O USUÁRIO
    $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=updated');
  }

  /**
   * Método responspável por excluir um depoimento
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function getDeleteTestimony($request, $id)
  {
    //OBTEM O DEPOIMENTO DO BANCO DE DADOS
    $obTestimony = EntityTestimony::getTestimonyById($id);

    //VALIDA A INSTANCIA
    if (!$obTestimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    //CONTEÚDO DO FORMULÁRIO
    $content = View::render('admin/modules/testimonies/delete', [
      'nome' => $obTestimony->nome,
      'mensagem' => $obTestimony->mensagem,
    ]);

    //RETORNA A PÁGINA COMPLETA
    return parent::getPanel('Excluir depoimento > leandro', $content, 'testimonies');
  }

   /**
   * Método responspável por excluir um depoimento
   * @param Request $request
   * @param integer $id
   * @return string
   */
  public static function setDeleteTestimony($request, $id)
  {
    //OBTEM O DEPOIMENTO DO BANCO DE DADOS
    $obTestimony = EntityTestimony::getTestimonyById($id);

    //VALIDA A INSTANCIA
    if (!$obTestimony instanceof EntityTestimony) {
      $request->getRouter()->redirect('/admin/testimonies');
    }

    //ECLUIR O DEPOIMENTO
    $obTestimony->excluir();

    //REDIRECIONA O USUÁRIO
    $request->getRouter()->redirect('/admin/testimonies?status=deleted');
  }
}
