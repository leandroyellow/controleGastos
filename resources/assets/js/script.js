//Remover todas as classes active do menu
function removerActive() {
  var elements = document.querySelectorAll('.btn-menu')

  for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove('active');
  }
}

//Separar a url
let teste = window.location.pathname.split("/")

//pegar o último valor da url
let valor = teste[teste.length - 1];
//console.log(valor);

removerActive();

//Adicionar a classe active em um botão específico
switch (valor) {
  case "":
    document.querySelector('#btn-home').classList.add('active');
    break;

  case "sobre":
    document.querySelector('#btn-sobre').classList.add('active');
    break;
  
  case "contato":
    document.querySelector('#btn-contato').classList.add('active');
    break;
  
  case "depoimentos":
    document.querySelector('#btn-depoimentos').classList.add('active');
    break;

  default:
    break;
}

//console.log(window.location.pathname);
//console.log(valor);