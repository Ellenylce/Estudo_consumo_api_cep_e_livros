<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca CEP</title>
    <link rel="stylesheet" href="styles.css">
    <script src="meu-script.js" defer></script>
</head>
<body id ="body">
    <!-- Contém o icone seta-->
    <!-- Quando o botão é clicado é redirecionado para outra página -->
    <div id = "seta_direita">
        <button type = "submit" onclick="window.location.href='biblioteca.php'">
            <img src="seta.png" alt="">
         </button>    
    </div>

<!-- Fiz um container que contem o campo de pesquisa (container-header) e a exibição do dados (container-body) -->
    <div id = "container">
        <div id = "container-header">
            <h1>Consulta de CEP</h1>
            <form  id = "input-button" action="" method="post" >
                <input type="text" name="cep" placeholder="Digite o CEP">
                <button type = "submit"> Buscar </button>
            </form>
        </div>
        <div  id = "container-body">
            <div class="label">Logradouro:</div>
            <input type="text" id="logradouro" readonly>

            <div class="label">Bairro:</div>
            <input type="text" id="bairro" readonly>

            <div class="label">Cidade:</div>
            <input type="text" id="cidade" readonly>

            <div class="label">Estado:</div>
            <input type="text" id="estado" readonly> 
        </div>
        <div id = "alinhar_mensagem">
            <p class = "mensagem-erro" id = "mensagem_erro"></p>
        </div>
    </div>
    
           <!--  Aqui estava tentando apagar os dados quando carrega a página mas dar conflito (deu erro)-->

    <!-- <script>
        // Limpa os inputs ao carregar a página
        window.onload = function() {
            document.getElementById('logradouro').value = '';
            document.getElementById('bairro').value = '';
            document.getElementById('cidade').value   
 = '';
            document.getElementById('estado').value = '';
            document.getElementById('mensagem_erro').textContent   
 = '';
        }
    </script> -->

</body>
</html>

 <?php
// Função para buscar informações de um CEP
function buscarCep($cep) {
   
    // URL da API ViaCEP
    $url = "https://viacep.com.br/ws/$cep/json/";

    // Faz a requisição HTTP e decodifica o JSON em um objeto PHP e retorna o resultado.
    $dados = file_get_contents($url);
    return json_decode($dados);
}

// Verifica se a requisição HTTP foi do tipo POST (ou seja, se um formulário foi enviado).
// Obtém o valor do campo "cep" do formulário enviado e põe na variavel $cep.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cep = $_POST['cep'];

// Verifica se o CEP contém exatamente 8 dígitos numéricos.
// Se o CEP for inválido, exibe uma mensagem de erro no elemento HTML com o ID "mensagem_erro".
// exit;: Interrompe a execução do script.
// preg_match: Essa é uma função do PHP que realiza uma busca por padrões em uma string usando uma expressão regular.
// '/^\d{8}$/': Essa é a própria expressão regular:
// ^: Indica o início da string.
// \d: Representa qualquer dígito numérico (0-9).
// {8}: Quantificador que indica que o dígito anterior (neste caso, \d) deve ocorrer exatamente 8 vezes.
// $: Indica o final da string.
// verifica se a string $cep começa com um dígito e contém exatamente 8 dígitos numéricos, e nada mais. Se a string corresponder a esse padrão, a função preg_match retorna true, indicando que o CEP é válido (no sentido de ter o formato correto). Caso contrário, retorna false.
    if (!preg_match('/^\d{8}$/', $cep)) {
            echo "<script>
            document.getElementById('mensagem_erro').textContent = 'CEP inválido: deve conter 8 dígitos numéricos.';
            </script>";
            exit;
    }

    // Verifica se o CEP foi informado
    // Verifica se o campo CEP está vazio.
// Se estiver vazio: Exibe uma mensagem de erro e limpa os campos do formulário.
    if (empty($cep)) {
        echo "<script>
            document.getElementById('mensagem_erro').textContent = 'Por favor, digite um CEP.';
            // Limpa os inputs se o CEP for inválido
                document.getElementById('logradouro').value = '';
                document.getElementById('bairro').value = '';
                document.getElementById('cidade').value = '';
                document.getElementById('estado').value = '';
                
        </script>";
        exit;
    }

    // Chama a função para buscar as informações do CEP.
    $resultado = buscarCep($cep);


    // // teste (agora após verificar se o CEP não está vazio)
    // if (!preg_match('/^\d{8}$/', $cep)) {
    //     echo "<script>
    //         document.getElementById('mensagem_erro').textContent = 'CEP inválido: deve conter 8 dígitos numéricos.';
    //     </script>";
    //     exit;
    // }

    // Verifica se houve algum erro na consulta
// Se houver erro: Exibe uma mensagem de erro indicando que o CEP não foi encontrado.
// Se não houver erro: Preenche os campos do formulário com as informações obtidas da API.
    if (!$resultado || isset($resultado->erro)) {
        echo "<script>
            document.getElementById('mensagem_erro').textContent = 'CEP não encontrado. Verifique se o CEP está correto.';
        </script>";
    } else {
        echo 
        "<script>
            document.getElementById('logradouro').value = '$resultado->logradouro';
            document.getElementById('bairro').value = '$resultado->bairro';
            document.getElementById('cidade').value = '$resultado->localidade';
            document.getElementById('estado').value = '$resultado->uf';
        </script>";
    }
}

?>


































