<?php
// se conectar ao banco de dados
require_once __DIR__. "/conexao.php";


// função para capturar os dados passados de uma página a outra
function redirewWith($url, $params=[]){
// verifica se os paramentros não vieram vazios    
if(!empty($params[])){
// separar os oaramentros em espaços diferentes    
$qs= http_build_query($params);
$sep =(strops($url,'?')=== false) ? '?': '&';
$url .= $sep . $qs;
}
// joga a url para o cabeçalho no navegador
header("Location: $url");
// fecha o script
exit;
}

// capturando os dados e jogando em váriaveis
try{
 // SE O METODO DE ENVIO FOR DIFERENTE DO POST
 if($_SERVER["REQUEST_METHOD"] !== "POST"){
// VOLTANDO Á TELA DE CADASTRO E EXIBIR ERRO
redirecWith ("../paginas/cadastro.html",
["erro"=> "Metodo inválido"]);

 }
//jogando os dados da dentro  de váriaveis
$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$telefone =["telefone"];
$cpf = $_POST["cpf"];
$confirmarsenha=["confirmar"];

// VALIDANDO OS CAMPOS
// criar uma váriavel para receber os erros de validação
$erros_validacao=[];
// se qualquer um campo for vazio
if($nome === ""|| $email=== "" || $senha=== ""
|| $telefone === ""|| $cpf=== "" $confirmarsenha===""){
    $erros_validacao[]="Preencha todos os campos";
}

// validação para verificar se o email tem @ 
if(!filter_var($email, filter_validade_email)){
    $erros_validacao[]= "E-mail inválido";,
}
if($senha !== $confirmarsenha){
    $erros_validacao[]= "As senhas não conferem";
}

// verificar se a senha tem mais de 8 digitos
if(strlen($senha)<8){
    $erros_validacao[]= "senha deve ter pelo menos 8 caracteres";
}
// verificar se o telefone tem pelo menos 11 digitos
if(strlen($telefone)<11){
    $erros_validacao[]="telefone incorreto";
}
// verificar se o cpf tem pelo menos 11 digitos
if(strelen($cpf)<11){
    $erros_validacao[]="cpf inválido";
}
// agora é enviar os erros para a tela de cadastro
    if($erros_validacao){
        redirecWith("../paginas/cadastro.html" , 
        ["erro" => $erros_validacao[0]]);
    }

    // verificar se o cpf já foi cadastro no banco de dados
    $stmt = $pdo->prepare("SELECT * From Cliente 
    Where cpf= :cpf LIMIT 1");
    // joga o cpf digitado dentro do banco de dados
    $stmt ->execute([':cpf'=>$cpf]);
    // se o cpf já existir ele volta a tela cadastro
    if($stmt->fetch()){
        redirecWith('../paginas/cadastro.html',["erro" 
    => "CPF já está cadastrado"]);
    }
    /* Inserir o Cliente no banco de dados */
    $sql ="INSERT INTO 
    Cliente (nome,cpf,telefone,email,senha)
     Values (:nome,:cpf,:telefone,:email,:senha)";
     // executando o comando no banco de dados
     $inserir = $pdo->prepare($sql)->execute([
        ":nome" => $nome,
        ":cpf"=> $cpf,
        ":telefone"=> $telefone,
        ":email" => $email,
        ":senha"=> $senha,
     ]);
     /* Verificando se foi cadastrado no banco de dados */
     if($inserir){
        redirecWith("../paginas/login.html",
        ["cadastro" => "ok"]) ;
     }else{
        redirecWith("../paginas/cadastro.html",["erro" 
        =>"Erro ao cadastrar no banco de dados"]);
     }
    /* agora que tudo foi feito no Try, vamos elaborar 
    o catch com os possiveis erros */

}catch(PDOException $e){
     redirecWith("../paginas/cadastro.html",
      ["erro" => "Erro no banco de dados: "
      .$e->getMessage()]);
}


?>

