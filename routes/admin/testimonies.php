<?php 

use \App\Http\Response;
use \App\Controller\Admin;

//ROTA LISTAGEM DE DEPOIMENTOS
$obRouter->get('/admin/testimonies', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, Admin\Testimony::getTestimonies($request));
  }
]);

//ROTA CADASTRO DE UM NOVO DEPOIMENTOS
$obRouter->get('/admin/testimonies/new', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, Admin\Testimony::getNewTestimony($request));
  }
]);


//ROTA CADASTRO DE UM NOVO DEPOIMENTOS (POST)
$obRouter->post('/admin/testimonies/new', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request) {
    return new Response(200, Admin\Testimony::setNewTestimony($request));
  }
]);

//ROTA EDIÇÃO DE UM DEPOIMENTOS
$obRouter->get('/admin/testimonies/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request, $id) {
    return new Response(200, Admin\Testimony::getEditTestimony($request, $id));
  }
]);

//ROTA EDIÇÃO DE UM DEPOIMENTOS (POST)
$obRouter->post('/admin/testimonies/{id}/edit', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request, $id) {
    return new Response(200, Admin\Testimony::setEditTestimony($request, $id));
  }
]);

//ROTA EXCLUSÃO DE UM DEPOIMENTOS
$obRouter->get('/admin/testimonies/{id}/delete', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request, $id) {
    return new Response(200, Admin\Testimony::getDeleteTestimony($request, $id));
  }
]);

//ROTA EXCLUSÃO DE UM DEPOIMENTOS (POST)
$obRouter->post('/admin/testimonies/{id}/delete', [
  'middlewares' => [
    'required-admin-login'
  ],
  function($request, $id) {
    return new Response(200, Admin\Testimony::setDeleteTestimony($request, $id));
  }
]);
?>