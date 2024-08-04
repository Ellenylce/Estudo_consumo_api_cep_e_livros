<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca CEP</title>
    <link rel="stylesheet" href="styles.css">
    <script src="meu-script.js" defer></script>
</head>
<body>
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
//Está faltando a limpeza de cep quando carrega a pagina

// Função para buscar informações de um CEP
function buscarCep($cep) {
    // ... (seu código da função buscarCep)
    // URL da API ViaCEP
    $url = "https://viacep.com.br/ws/$cep/json/";

    // Faz a requisição HTTP e decodifica o JSON
    $dados = file_get_contents($url);
    return json_decode($dados);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cep = $_POST['cep'];

    // teste
    if (!preg_match('/^\d{8}$/', $cep)) {
            echo "<script>
            document.getElementById('mensagem_erro').textContent = 'CEP inválido: deve conter 8 dígitos numéricos.';
            </script>";
            exit;
    }

    // Verifica se o CEP foi informado
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
    $resultado = buscarCep($cep);
    // teste (agora após verificar se o CEP não está vazio)
    if (!preg_match('/^\d{8}$/', $cep)) {
        echo "<script>
            document.getElementById('mensagem_erro').textContent = 'CEP inválido: deve conter 8 dígitos numéricos.';
        </script>";
        exit;
    }

    // Verifica se houve algum erro na consulta
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


































