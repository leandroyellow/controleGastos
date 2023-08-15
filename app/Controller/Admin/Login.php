<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;

class Login extends Page
{

  /**
   * Método responsável por retornar a renderização da página de login
   * @param Request $request
   * @param string $errorMessage
   * @return string
   */
  public static function getLogin($request, $errorMenssage = null)
  {
    //STATUS
    $status = !is_null($errorMenssage) ? View::render('admin/login/status', [
      'mensagem' => $errorMenssage
    ]) : '';

    //CONTEÚDO DA PÁGINA DE LOGIN
    $content = View::render('admin/login', [
      'status' => $status
    ]);

    //RETORNA A PÁGINA COMPLETA
    return parent::getPage('Login > leandro', $content);
  }

  /**
   * Método responsável por definir o login do usuário
   * @param Request $request
   */
  public static function setLogin($request)
  {
    //POST VARS
    $postVars = $request->getPostVars();
    $usuario = $postVars['usuario'] ?? '';
    $senha = $postVars['senha'] ?? '';

    //BUSCA O USUÁRIO PELO USUÁRIO
    $obUser = User::getUserByUsuario($usuario);
    if (!$obUser instanceof User) {
      return self::getLogin($request, 'Usuário ou senha inválidos!');
    }

    //VERIFICA A SENHA DO USUÁRIO
    if (!password_verify($senha, $obUser->senha)) {
      return self::getLogin($request, 'Usuário ou senha inválidos!');
    }

    //CRIA A SESSÃO DE LOGIN
    SessionAdminLogin::login($obUser);

    //REDIRECIONA O USUÁRIO PARA HOME DO ADMIN
    $request->getRouter()->redirect('/admin');
  }

  /**
   * Método responsável por deslogar o usuário
   *
   * @param Request $request
   * @return void
   */
  public static function setLogout($request)
  {
    //DESTROI A SESSÃO DE LOGIN
    SessionAdminLogin::logout();

    //REDIRECIONA O USUÁRIO PARA TELA DE LOGIN
    $request->getRouter()->redirect('/admin/login');
  }
}
