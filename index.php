<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="meu_script.js"></script>

    <script>
        function preencherCampos(dados) {
            document.getElementById('result-logradouro').value = dados.logradouro;
            document.getElementById('result-bairro').value = dados.bairro;   

            document.getElementById('result-cidade').value = dados.localidade;
           document.getElementById('result-estado').value = dados.uf;   
        }
    </script>

</head>
<body>
    <div id = "container">
        <div id = "container-header">
            <h1>Consulta de CEP</h1>
            <form id = "input-button" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type = "text" id = "campoCep" name = "cep" placeholder = "Digite seu cep" requerid>
                <button type = "submit"> Buscar </button>
            </form>
        </div>
        <div  id = "container-body">
            <div class="label">Logradouro:</div>
            <input type="text" id="result-logradouro">

            <div class="label">Bairro:</div>
            <input type="text" id="result-bairro">

            <div class="label">Cidade:</div>
            <input type="text" id="result-cidade">

            <div class="label">Estado:</div>
            <input type="text" id="result-estado">
            
        </div>
           
        </div>
    </div>
</body>
</html>




<?php
// ... (função buscarCep)
function buscarCep($cep) {
    // URL da API ViaCEP
    $url = "https://viacep.com.br/ws/$cep/json/";

    // Faz a requisição HTTP e decodifica o JSON
    $dados = file_get_contents($url);
    return json_decode($dados);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cep = $_POST['cep'];
    $resultado = buscarCep($cep);
}
    //Verifica se houve algum erro na consulta
if (!$resultado || isset($resultado->erro)) {
    echo "CEP inválido ou não encontrado.";
} else {
    // Exibe os dados do endereço
    
    var_dump($resultado);
    preencherCampos($resultado);
    // echo preencherCampos() . $resultado->logradouro . "<br>";
    // echo "Bairro: " . $resultado->bairro . "<br>";
    // echo "Cidade: " . $resultado->localidade . "<br>";
    // echo "Estado: " . $resultado->uf . "<br>";
}

?>




<!-- <!DOCTYPE html>
<html>
<head>
    <title>Consulta CEP</title>
</head>
<body>
    <form method="post">
        <input type="text" name="cep" placeholder="Digite o CEP">
        <button type="submit">Buscar</button>
    </form>
    <div id="resultado">
        <p>Logradouro: <span id="logradouro"></span></p>
        <p>Bairro: <span id="bairro"></span></p>
        <p>Cidade: <span id="cidade"></span></p>
        <p>Estado: <span id="estado"></span></p>
    </div>

    
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $cep = $_POST['cep'];
    //     $url = "https://viacep.com.br/ws/$cep/json/";
    //     $data = file_get_contents($url);
    //     $dados = json_decode($data);

    //     if (isset($dados->erro)) {
    //         echo "<script>alert('CEP inválido');</script>";
    //     } else {
    //         echo "<script>
    //             document.getElementById('logradouro').textContent = '$dados->logradouro';
    //             document.getElementById('bairro').textContent = '$dados->bairro';
    //             document.getElementById('cidade').textContent = '$dados->localidade';
    //             document.getElementById('estado').textContent = '$dados->uf';
    //         </script>";
    //     }
    // }
    // ?>
</body>
</html> --> 








<!-- 
// // Função para buscar informações de um CEP
// function buscarCep($cep) {
//     // URL da API ViaCEP
//     $url = "https://viacep.com.br/ws/$cep/json/";

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     return json_decode($dados);
// }

// // Exemplo de uso:
// $cep = "01001000"; // Substitua pelo CEP desejado
// $resultado = buscarCep($cep);

// // Verifica se houve algum erro na consulta
// if (!$resultado || isset($resultado->erro)) {
//     echo "CEP inválido ou não encontrado.";
// } else {
//     // Exibe os dados do endereço
//     echo "Logradouro: " . $resultado->logradouro . "<br>";
//     echo "Bairro: " . $resultado->bairro . "<br>";
//     echo "Cidade: " . $resultado->localidade . "<br>";
//     echo "Estado: " . $resultado->uf . "<br>";
// }

 -->







<!-- <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CEP</title>
    <style>
        /* Estilo básico da página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Container centralizado */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Estilo do título */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Estilo do formulário */
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Estilo do campo de entrada e botão */
        input[type="text"] {
            width: calc(100% - 110px);
            padding: 10px;
            margin-right: 10px;
        }

        button {
            padding: 10px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #4cae4c;
        }

        /* Estilo da seção de resultado */
        .resultado {
            text-align: center;
        }

        .resultado p {
            font-size: 18px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consulta de CEP</h1>
       
         Formulário para buscar o CEP 
        <form id="formularioCep" method="GET">
            <input type="text" id="campoCep" name="cep" placeholder="Digite o CEP" required>
            <button type="submit">Buscar</button>
        </form>

         Seção para exibir o resultado da consulta 
        <div id="resultado" class="resultado">
          
            // // Verifica se o parâmetro 'cep' foi enviado
            // if (isset($_GET['cep'])) {
            //     // Recebe o CEP enviado pelo formulário
            //     $cep = $_GET['cep'];
               
            //     // URL da API ViaCEP para consultar o CEP
            //     $url = "https://viacep.com.br/ws/{$cep}/json/";

            //     // Faz a requisição para a API
            //     $resposta = file_get_contents($url);

            //     // Verifica se a resposta não é falsa
            //     if ($resposta !== false) {
            //         // Decodifica a resposta JSON em um array PHP
            //         $dados = json_decode($resposta, true);

            //         // Verifica se a API retornou um erro
            //         if (isset($dados['erro'])) {
            //             echo "<p>CEP não encontrado.</p>";
            //         } else {
            //             // Exibe os dados do endereço retornados pela API
            //             $logradouro = $dados['logradouro'] ?? 'Não disponível';
            //             $bairro = $dados['bairro'] ?? 'Não disponível';
            //             $cidade = $dados['localidade'] ?? 'Não disponível';
            //             $estado = $dados['uf'] ?? 'Não disponível';

            //             echo "
            //             <p><strong>Logradouro:</strong> {$logradouro}</p>
            //             <p><strong>Bairro:</strong> {$bairro}</p>
            //             <p><strong>Cidade:</strong> {$cidade}</p>
            //             <p><strong>Estado:</strong> {$estado}</p>
            //             ";
            //         }
            //     } else {
            //         echo "<p>Erro ao consultar a API.</p>";
            //     }
            // }
//             // 
//         </div>
//     </div>
// </body>
// </html> -->