<?php
// Conectando este arquivo ao banco de dados
require_once __DIR__ ."/conexao.php";

// função para capturar os dados passados de uma página a outra
function redirecWith($url,$params=[]){
// verifica se os os paramentros não vieram vazios
 if(!empty($params)){
// separar os parametros em espaços diferentes
$qs= http_build_query($params);
$sep = (strpos($url,'?') === false) ? '?': '&';
$url .= $sep . $qs;
}
// joga a url para o cabeçalho no navegador
header("Location:  $url");
// fecha o script
exit;
}

try{

 // SE O METODO DE ENVIO FOR DIFERENTE DO POST
    if($_SERVER["REQUEST_METHOD"] !== "POST"){
        //VOLTAR À TELA DE CADASTRO E EXIBIR ERRO
        redirecWith("../paginas/frete_pagamento_logista.html",
           ["erro"=> "Metodo inválido"]);
    }
    // variaveis
    $nomepagamento = $_POST["nomepagamento"];
    

    // validação
    $erros_validacao=[];
    //se qualquer campo for vazio
    if($nomepagamento === ""  ){
        $erros_validacao[]="Preencha todos os campos";
    }
/* Inserir o frete no banco de dados*/
$sql = "INSERT INTO Formas_pagamento (nome)"




}catch(Exception $e){

    redirecWith("../paginas/frete_pagamento_logista.html",
      ["erro" => "Erro no banco de dados: "
      .$e->getMessage()]);
}





?>