<?php

$turma = $_POST['turma'];

$nomes = $_POST['nome'];
$nota1 = $_POST['nota1'];
$nota2 = $_POST['nota2'];
$trabalho = $_POST['trabalho'];

$totalAlunos = count($nomes);

$aprovados = 0;
$recuperacao = 0;
$reprovados = 0;

$maiorMedia = 0;
$menorMedia = 10;

$somaMedias = 0;
$somaTotalNotas = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">

    <title>Relatório Estatístico</title>

    <link rel="stylesheet" href="css/css_estatistica.css">

</head>

<body>

<div class="container">

    <h1>Relatório Estatístico da Turma</h1>

    <h2><?php echo $turma; ?></h2>

    <table>

        <tr>
            <th>Aluno</th>
            <th>Nota 1</th>
            <th>Nota 2</th>
            <th>Trabalho</th>
            <th>Média</th>
            <th>Raiz da Soma</th>
            <th>Diferença</th>
            <th>Situação</th>
        </tr>

        <?php

        for($i = 0; $i < $totalAlunos; $i++){

            $media =
            (
                $nota1[$i] +
                $nota2[$i] +
                $trabalho[$i]
            ) / 3;

            $raiz =
            sqrt(
                $nota1[$i] +
                $nota2[$i] +
                $trabalho[$i]
            );

            $maiorNota =
            max(
                $nota1[$i],
                $nota2[$i],
                $trabalho[$i]
            );

            $menorNota =
            min(
                $nota1[$i],
                $nota2[$i],
                $trabalho[$i]
            );

            $diferenca =
            abs(
                $maiorNota -
                $menorNota
            );

            if($media >= 7){

                $situacao = "Aprovado";
                $aprovados++;

            }
            elseif($media >= 5){

                $situacao = "Recuperação";
                $recuperacao++;

            }
            else{

                $situacao = "Reprovado";
                $reprovados++;

            }

            $somaMedias += $media;

            if($media > $maiorMedia){
                $maiorMedia = $media;
            }

            if($media < $menorMedia){
                $menorMedia = $media;
            }

            $somaTotalNotas +=
                $nota1[$i] +
                $nota2[$i] +
                $trabalho[$i];

        ?>

        <tr>

            <td><?php echo $nomes[$i]; ?></td>

            <td>
                <?php echo number_format($nota1[$i],2,',','.'); ?>
            </td>

            <td>
                <?php echo number_format($nota2[$i],2,',','.'); ?>
            </td>

            <td>
                <?php echo number_format($trabalho[$i],2,',','.'); ?>
            </td>

            <td>
                <?php echo number_format($media,2,',','.'); ?>
            </td>

            <td>
                <?php echo number_format($raiz,2,',','.'); ?>
            </td>

            <td>
                <?php echo number_format($diferenca,2,',','.'); ?>
            </td>

            <td>
                <?php echo $situacao; ?>
            </td>

        </tr>

        <?php
        }
        ?>

    </table>

    <?php

    $mediaGeral =
    $somaMedias / $totalAlunos;

    $percentualAprovacao =
    ($aprovados / $totalAlunos) * 100;

    ?>

    <div class="stats">

        <h2>Relatório da Turma</h2>

        <p>
            <strong>Média Geral:</strong>
            <?php echo number_format($mediaGeral,2,',','.'); ?>
        </p>

        <p>
            <strong>Maior Média:</strong>
            <?php echo number_format($maiorMedia,2,',','.'); ?>
        </p>

        <p>
            <strong>Menor Média:</strong>
            <?php echo number_format($menorMedia,2,',','.'); ?>
        </p>

        <p>
            <strong>Aprovados:</strong>
            <?php echo $aprovados; ?>
        </p>

        <p>
            <strong>Recuperação:</strong>
            <?php echo $recuperacao; ?>
        </p>

        <p>
            <strong>Reprovados:</strong>
            <?php echo $reprovados; ?>
        </p>

        <p>
            <strong>Percentual de Aprovação:</strong>
            <?php echo number_format($percentualAprovacao,2,',','.'); ?>%
        </p>

        <p>
            <strong>Soma Total das Notas:</strong>
            <?php echo number_format($somaTotalNotas,2,',','.'); ?>
        </p>

    </div>

    <?php

    if($percentualAprovacao >= 80){

        echo "
        <div class='msg msg-sucesso'>
            Excelente desempenho da turma!
        </div>
        ";

    }
    elseif($percentualAprovacao >= 60){

        echo "
        <div class='msg msg-alerta'>
            Bom desempenho da turma.
        </div>
        ";

    }
    else{

        echo "
        <div class='msg msg-erro'>
            A turma necessita de reforço pedagógico.
        </div>
        ";

    }

    ?>

</div>

</body>
</html>