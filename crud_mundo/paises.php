<?php
require_once("auth.php");
exigirLogin();
include("conexao.php");

if (isset($_POST['salvar']) || isset($_GET['excluir']) || isset($_GET['editar'])) exigirTipoA();

if(isset($_GET['excluir'])){
    $id=(int)$_GET['excluir'];
    mysqli_query($conexao,"DELETE FROM tb_paises WHERE id_pais=$id");
    header("Location: paises.php"); exit();
}

$id_pais=$id_continente=$nome=$area=$populacao=$idioma=$id_governante=$clima=$regime=$moeda="";
$editar=false;
if(isset($_GET['editar'])){
    $editar=true; $id=(int)$_GET['editar'];
    $r=mysqli_query($conexao,"SELECT * FROM tb_paises WHERE id_pais=$id");
    if($d=mysqli_fetch_assoc($r)){
        $id_pais=$d['id_pais']; $id_continente=$d['id_continente']; $nome=$d['nome']; $area=$d['area'];
        $populacao=$d['populacao']; $idioma=$d['idioma']; $id_governante=$d['id_governante'];
        $clima=$d['clima']; $regime=$d['regime']; $moeda=$d['moeda'];
    }
}

if(isset($_POST['salvar'])){
    $id=$_POST['id_pais']; $continente=$_POST['id_continente']; $nome=$_POST['nome'];
    $area=$_POST['area']; $populacao=$_POST['populacao']; $idioma=$_POST['idioma'];
    $governante=$_POST['id_governante']==="" ? "NULL" : "'".(int)$_POST['id_governante']."'";
    $clima=$_POST['clima']; $regime=$_POST['regime']; $moeda=$_POST['moeda'];

    if($id===""){
        mysqli_query($conexao,"INSERT INTO tb_paises(id_continente,nome,area,populacao,idioma,id_governante,clima,regime,moeda)
        VALUES('$continente','$nome','$area','$populacao','$idioma',$governante,'$clima','$regime','$moeda')");
    }else{
        mysqli_query($conexao,"UPDATE tb_paises SET id_continente='$continente',nome='$nome',area='$area',populacao='$populacao',
        idioma='$idioma',id_governante=$governante,clima='$clima',regime='$regime',moeda='$moeda' WHERE id_pais='$id'");
    }
    header("Location: paises.php"); exit();
}
?>
<!DOCTYPE html><html lang="pt-br"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Países</title><link rel="stylesheet" href="css/css_mundo.css"><script src="js/script.js"></script>
</head><body>
<header><h1>Cadastro de Países</h1></header>
<nav><ul><li><a href="index.php">Início</a></li><li><a href="continentes.php">Continentes</a></li><li><a href="paises.php">Países</a></li><li><a href="cidades.php">Cidades</a></li><li><a href="governantes.php">Governantes</a></li></ul></nav>

<?php if(ehAdministrador()): ?>
<form method="POST" onsubmit="return validarFormulario();">
<input type="hidden" name="id_pais" value="<?=htmlspecialchars($id_pais)?>">
<label>Nome do País</label><input type="text" name="nome" required value="<?=htmlspecialchars($nome)?>">
<label>Continente</label><select name="id_continente" required><option value="">Selecione</option>
<?php $r=mysqli_query($conexao,"SELECT * FROM tb_continentes ORDER BY nome"); while($c=mysqli_fetch_assoc($r)): ?>
<option value="<?=$c['id_continente']?>" <?=$id_continente==$c['id_continente']?'selected':''?>><?=htmlspecialchars($c['nome'])?></option>
<?php endwhile; ?></select>
<label>População</label><input type="number" name="populacao" required value="<?=htmlspecialchars($populacao)?>">
<label>Área (km²)</label><input type="number" step="0.01" name="area" required value="<?=htmlspecialchars($area)?>">
<label>Idioma</label><input type="text" name="idioma" required value="<?=htmlspecialchars($idioma)?>">
<label>Governante</label><select name="id_governante"><option value="">Selecione</option>
<?php $r=mysqli_query($conexao,"SELECT * FROM tb_governantes ORDER BY nome"); while($g=mysqli_fetch_assoc($r)): ?>
<option value="<?=$g['id_governante']?>" <?=$id_governante==$g['id_governante']?'selected':''?>><?=htmlspecialchars($g['nome'])?></option>
<?php endwhile; ?></select>
<label>Clima</label><input type="text" name="clima" required value="<?=htmlspecialchars($clima)?>">
<label>Regime Político</label><input type="text" name="regime" required value="<?=htmlspecialchars($regime)?>">
<label>Moeda</label><input type="text" name="moeda" required value="<?=htmlspecialchars($moeda)?>">
<button type="submit" name="salvar"><?=$editar?'Atualizar País':'Cadastrar País'?></button>
</form>
<?php endif; ?>

<table><tr><th>ID</th><th>País</th><th>Continente</th><th>População</th><th>Idioma</th><th>Governante</th><?php if(ehAdministrador()): ?><th>Ações</th><?php endif;?></tr>
<?php $sql=mysqli_query($conexao,"SELECT tb_paises.*,tb_continentes.nome AS continente,tb_governantes.nome AS governante
FROM tb_paises LEFT JOIN tb_continentes ON tb_paises.id_continente=tb_continentes.id_continente
LEFT JOIN tb_governantes ON tb_paises.id_governante=tb_governantes.id_governante ORDER BY tb_paises.nome");
while($d=mysqli_fetch_assoc($sql)): ?>
<tr><td><?=$d['id_pais']?></td><td><?=htmlspecialchars($d['nome'])?></td><td><?=htmlspecialchars($d['continente'])?></td>
<td><?=number_format($d['populacao'],0,",",".")?></td><td><?=htmlspecialchars($d['idioma'])?></td><td><?=htmlspecialchars($d['governante']??'')?></td>
<?php if(ehAdministrador()): ?><td><a class="editar" href="paises.php?editar=<?=$d['id_pais']?>">Editar</a> | <a class="excluir" href="paises.php?excluir=<?=$d['id_pais']?>" onclick="return confirmarExclusao();">Excluir</a></td><?php endif;?></tr>
<?php endwhile;?></table>
<p style="text-align:center;margin:20px;"><a href="index.php">Voltar ao início</a> | <a href="logout.php">Sair</a></p>
</body></html>
