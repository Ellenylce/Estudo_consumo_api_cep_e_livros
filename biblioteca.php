<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="styles.css"> </head>
</head>
<body id = "body_biblioteca">

<header id = "header">
        <form id="form-busca" action="" method="get">
            <input type="text" id="titulo" name="titulo" placeholder="Digite o título do livro">
            <button type="submit">
                <img src="lupa.png" alt="Buscar">
            </button>
        </form>
    </header>
    <div id="results"></div>
    
</body>
</html> -->


<!-- esse codigo funcionou -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>biblioteca de livros</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="styles.css"> 
</head>

    <body  id = "body_biblioteca">
        <!-- cabaeçalho da página
        Conterá uma seta para retroceder página, campo de pesquisa e botão de pesquisa  -->
        <header id = "header">

        <div id = "seta_esquerda" style="margin:20px">
            <button type = "submit" onclick="window.location.href='index.php'" >
                <img src="seta_esquerda.png" alt="" style="width: 20px; height: 20px;" >
            </button>
        </div>

            <form id="form-busca" action="" method="get">
                <input type="text" id="campo_busca" name="titulo" placeholder="Digite o título do livro">
                <button type="submit">Buscar
                    <!-- <img src="lupa.png" alt="Buscar"> -->
                </button>
            </form>
        </header>
        <!-- <main id = "main"></main> -->
    </body>
</html> 

<!-- if (isset($_GET['titulo'])) {: Verifica se o parâmetro titulo existe na URL 
Se existir:
Extrai o título: Recupera o valor do parâmetro titulo usando $_GET['titulo'].
Monta a URL da API: Constrói a URL da API Open Library para buscar livros com base no título.
Busca os dados: Faz uma requisição para a API e armazena o resultado JSON na variável $dados.
Decodifica o JSON: Converte o JSON em um array PHP usando json_decode.-->
    <?php
    if (isset($_GET['titulo'])) {
        $titulo = $_GET['titulo'];
        $url = "https://openlibrary.org/search.json?title=" . urlencode($titulo);
        $dados = file_get_contents($url);
        $resultados = json_decode($dados, true);

//  Verifica se há resultados:
// Se houver resultados:
// Cria um container: Cria uma div com a classe container para agrupar os resultados.
// Percorre os resultados: Itera sobre o array de livros usando um foreach.
// Para cada livro:
// Extrai a capa: Verifica se existe uma capa disponível na API e monta a URL da imagem.
// Cria a estrutura do livro: Cria divs para o container da capa (capa-container) e informações do livro (info-livro).
// Capa: Exibe a imagem da capa se disponível, caso contrário, exibe uma mensagem indicando que o livro não possui capa.
// Informações: Exibe o título, autores, número de páginas (se disponíveis) do livro.
// Fecha a div container.
// Se não houver resultados: Exibe uma mensagem informando que nenhum livro foi encontrado para o título buscado.

// verifica se a chave 'docs' existe dentro do array $resultados.
// Essa chave, de acordo com a documentação da API Open Library, contém um array de documentos (livros) encontrados na busca.
// conta o numero de elementos e ver se é maior que 0

        if (isset($resultados['docs']) && count($resultados['docs']) > 0) {
            echo "<div class='container'>";

// Percorre os livros      
// $capa = isset($livro['cover_i']) ? ... : "";
// Verifica se a chave 'cover_i' existe no array $livro. Se existir, significa que o livro possui uma capa.
// Se a capa existir, a variável $capa recebe a URL da imagem da capa, construída com base no ID da capa.
// Se não existir, $capa recebe uma string vazia.

            foreach ($resultados['docs'] as $livro) {
                $capa = isset($livro['cover_i']) ? "https://covers.openlibrary.org/b/id/" . $livro['cover_i'] . "-L.jpg" : "";
                echo "<div class='livro'>";
                echo "<div class='capa-container'>";
                if ($capa) {
                    echo "<img class='capa' src='$capa' alt='Capa de $livro[title]'>";
                } else {
                    echo "<p class='sem-capa'>Livro não contém capa</p>";
                }

                // Exibe as outras informações dos livros
                echo "</div>";
                echo "<div class='info-livro'>";
                echo "<h3>$livro[title]</h3>";
                echo "<p><strong>Autor(es):</strong> " . (isset($livro['author_name']) ? implode(", ", $livro['author_name']) : 'N/A') . "</p>";
                echo "<p><strong>Páginas:</strong> " . (isset($livro['number_of_pages_median']) ? $livro['number_of_pages_median'] : 'N/A') . "</p>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>Nenhum livro encontrado para o título '$titulo'.</p>";
        }
    }
    ?>










<?php





// function buscarLivros($titulo) {
//     // URL da API Open Library
//     $url = "https://openlibrary.org/search.json?title=" . urlencode($titulo);

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     $resultados = json_decode($dados, true); // Decodifica como array associativo

//     // Verifica se houve algum erro na consulta ou se não há resultados
//     if (empty($resultados['docs'])) {
//         return [];
//     }

//     return $resultados['docs'];
// }

// // Verifica se o título foi passado via GET
// if (isset($_GET['titulo'])) {
//     $titulo = $_GET['titulo'];
//     $resultados = buscarLivros($titulo);

//     if ($resultados) {
//         // echo "<h1>Resultados da busca para '$titulo'</h1>";
//         foreach ($resultados as $livro) {
//             if (isset($livro['cover_i'])) {
//                         $coverUrl = "https://covers.openlibrary.org/b/id/" . $livro['cover_i'] . "-M.jpg";
//                         echo "<img src='$coverUrl' alt='Capa do livro'>";
//                     } else {
//                         echo "<img src='placeholder.png' alt='Capa não disponível'>";
//                     }
//                     echo "</div>";
//             echo "Título: " . (isset($livro['title']) ? $livro['title'] : 'N/A') . "<br>";
//             echo "Autor(es): " . (isset($livro['author_name']) ? implode(", ", $livro['author_name']) : 'N/A') . "<br>";
//             echo "Número de Páginas: " . (isset($livro['number_of_pages_median']) ? $livro['number_of_pages_median'] : 'N/A') . "<br><br>";
//         }
//     } else {
//         echo "<p>Nenhum livro encontrado para o título '$titulo'.</p>";
//     }
// } else {
//     echo "<p>Por favor, insira um título para buscar.</p>";
// }








//esse é o codigo que havia dado certo
// function buscarLivros($titulo) {
//     // URL da API Open Library
//     $url = "https://openlibrary.org/search.json?title=" . urlencode($titulo);

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     $resultados = json_decode($dados, true); // Decodifica como array associativo

//     // Verifica se houve algum erro na consulta ou se não há resultados
//     if (empty($resultados['docs'])) {
//         return [];
//     }

//     return $resultados['docs'];
// }

// // Exemplo de uso:
// $titulo = "a cabana";
// $resultados = buscarLivros($titulo);

// if ($resultados) {
//     foreach ($resultados as $livro) {
//         echo "Título: " . (isset($livro['title']) ? $livro['title'] : 'N/A') . "<br>";
//         echo "Autor(es): " . (isset($livro['author_name']) ? implode(", ", $livro['author_name']) : 'N/A') . "<br>";
//         echo "Número de Páginas: " . (isset($livro['number_of_pages_median']) ? $livro['number_of_pages_median'] : 'N/A') . "<br><br>";

//     // não poe esse aqui abaixo da descrição

//     //     // Verifica a descrição
//     //     $descricao = 'N/A';
//     //     if (isset($livro['first_sentence'])) {
//     //         $descricao = is_array($livro['first_sentence']) ? implode(" ", $livro['first_sentence']) : $livro['first_sentence'];
//     //     } elseif (isset($livro['description'])) {
//     //         if (is_array($livro['description'])) {
//     //             $descricao = $livro['description']['value'];
//     //         } else {
//     //             $descricao = $livro['description'];
//     //         }
//     //     }

//     //     echo "Descrição: " . $descricao . "<br><br>";
//     }
// }
// o codigo finaliza aquui











// if ($resultados) {
//     foreach ($resultados as $livro) {
//         echo "Título: " . (isset($livro['title']) ? $livro['title'] : 'N/A') . "<br>";
//         echo "Autor(es): " . (isset($livro['author_name']) ? implode(", ", $livro['author_name']) : 'N/A') . "<br>";

//         echo "Número de Páginas: " . (isset($livro['number_of_pages_median']) ? $livro['number_of_pages_median'] : 'N/A') . "<br>";
//         echo "Descrição: " . (isset($livro['first_sentence']) ? $livro['first_sentence'] : 'N/A') . "<br><br>";
//         // echo "Número de Páginas: " . (isset($livro['number_of_pages']) ? $livro['number_of_pages'] : 'N/A') . "<br>";
//         // echo "Descrição: " . (isset($livro['description']) ? $livro['description'] : 'N/A') . "<br><br>";
//     }
// }





























// function buscarLivros($titulo) {
//     // URL da API Open Library
//     $url = "https://openlibrary.org/search.json?title=" . urlencode($titulo);

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     $resultados = json_decode($dados, true); // Decodifica como array associativo

//     // Verifica se houve algum erro na consulta ou se não há resultados
//     if (empty($resultados['docs'])) {
//         return [];
//     }

//     return $resultados['docs'];
// }

// // Exemplo de uso:
// $titulo = "a cabana";
// $resultados = buscarLivros($titulo);

// if ($resultados) {
//     foreach ($resultados as $livro) {
//         echo "Título: " . $livro['title'] . "<br>";
//         echo "Autor(es): " . implode(", ", $livro['author_name']) . "<br>";
//         // echo "Número de Páginas: " . $livro['number_of_pages'] . "<br>";
//         // echo "Descrição: " . $livro['description'] . "<br><br>";
//     }
// }




// function buscarLivros($titulo) {
//     // URL da API Open Library
//     $url = "https://openlibrary.org/search.json?title=" . urlencode($titulo);

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     $resultados = json_decode($dados, true); // Decodifica como array associativo

//     // Verifica se houve algum erro na consulta ou se não há resultados
//     if (empty($resultados['docs'])) {
//         return [];
//     }

//     return $resultados['docs'];
// }

// // Exemplo de uso:
// $titulo = "a cabana";
// $resultados = buscarLivros($titulo);

// if ($resultados) {
//     var_dump($resultados);
//     foreach ($resultados as $livro) {
//             echo "Título: " . $resultados ->title . "<br>";
//             // echo "Autor(es): " . implode(", ", $livro['authors']) . "<br>";
//             // echo "Número de Páginas: " . $livro['number_of_pages'] . "<br>";
//             // echo "Descrição: " . $livro['description'] . "<br><br>";
//         }






    // foreach ($resultados as $livro) {
    //     echo "Título: " . $livro['title'] . "<br>";
    //     echo "Autor(es): " . implode(", ", $livro['authors']) . "<br>";
    //     echo "Número de Páginas: " . $livro['number_of_pages'] . "<br>";
    //     echo "Descrição: " . $livro['description'] . "<br><br>";
    // }
// } else {
//     echo "Nenhum livro encontrado.";
// }





// function buscarLivros($titulo) {
    
//     $url = "https://openlibrary.org/search.json?title={$titulo}";
//     // $url = "https://openlibrary.org/search.json?title=" . urlencode($titulo);
//     // $url = "https://openlibrary.org/search.json?title=O+Pequeno+Pr%C3%ADncipe";

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     return json_decode($dados);
// }

// // Exemplo de uso:
// $titulo = "a cabana";
// $resultados = buscarLivros($titulo);
// // var_dump($resultados);


// if ($resultados) {
//     foreach ($resultados as $livro) {
//         echo "Título: " . $livro->volumeInfo->title . "<br>";
//         echo "Autor(es): " . implode(", ", $livro->volumeInfo->authors) . "<br>";
//         echo "Número de Páginas: " . $livro->volumeInfo->pageCount . "<br>";
//         echo "Descrição: " . $livro->volumeInfo->description . "<br><br>";
//     }
// } else {
//     // var_dump($resultados);
//     echo "Nenhum livro encontrado.";
// }





// function buscarLivros($titulo) {
//     // URL da API Google Books
//     $url = "https://openlibrary.org/search.json?title=$titulo";

//     // Faz a requisição HTTP e decodifica o JSON
//     $dados = file_get_contents($url);
//     $resultado = json_decode($dados, true); // Decodifica como array associativo

//     // Verifica se houve algum erro na consulta
//     if (isset($resultado['error'])) {
//         return [];
//     }

//     // Retorna os itens (livros)
//     return $resultado['items'];
// }

// // Exemplo de uso:
// $titulo = "O Senhor dos Anéis";
// $resultados = buscarLivros($titulo);

// if ($resultados) {
//     foreach ($resultados->items as $livro) {
//         echo "Título: " . $livro->volumeInfo->title . "<br>";
//         echo "Autor(es): " . implode(", ", $livro->volumeInfo->authors) . "<br>";
//         echo "Número de Páginas: " . $livro->volumeInfo->pageCount . "<br>";
//         echo "Descrição: " . $livro->volumeInfo->description . "<br><br>";
//     }
// } else {
//     echo "Nenhum livro encontrado.";
// }
?>