<?php
require_once("auth.php"); exigirLogin(); include("conexao.php");
if(isset($_POST['salvar'])||isset($_GET['excluir'])||isset($_GET['editar'])) exigirTipoA();

if(isset($_GET['excluir'])){$id=(int)$_GET['excluir'];mysqli_query($conexao,"DELETE FROM tb_cidades WHERE id_cidade=$id");header("Location: cidades.php");exit();}

$editar=false;$id_cidade=$nome=$id_pais=$populacao=$id_governante=$clima=$dt_fundacao="";
if(isset($_GET['editar'])){
 $editar=true;$id=(int)$_GET['editar'];$r=mysqli_query($conexao,"SELECT * FROM tb_cidades WHERE id_cidade=$id");
 if($d=mysqli_fetch_assoc($r)){foreach(['id_cidade','nome','id_pais','populacao','id_governante','clima','dt_fundacao'] as $f)$$f=$d[$f];}
}
if(isset($_POST['salvar'])){
 $id=$_POST['id'];$nome=$_POST['nome'];$id_pais=(int)$_POST['id_pais'];$populacao=(int)$_POST['populacao'];
 $id_governante=$_POST['id_governante']===""?"NULL":(int)$_POST['id_governante'];$clima=$_POST['clima'];$dt_fundacao=$_POST['dt_fundacao'];
 if($id==="") mysqli_query($conexao,"INSERT INTO tb_cidades(nome,id_pais,populacao,id_governante,clima,dt_fundacao) VALUES('$nome',$id_pais,$populacao,$id_governante,'$clima','$dt_fundacao')");
 else mysqli_query($conexao,"UPDATE tb_cidades SET nome='$nome',id_pais=$id_pais,populacao=$populacao,id_governante=$id_governante,clima='$clima',dt_fundacao='$dt_fundacao' WHERE id_cidade=$id");
 header("Location: cidades.php");exit();
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Cidades</title>
<link rel="stylesheet" href="css/css_mundo.css"><script src="js/script.js"></script></head><body>
<header><h1>Cadastro de Cidades</h1></header>
<nav><ul><li><a href="index.php">Início</a></li><li><a href="continentes.php">Continentes</a></li><li><a href="paises.php">Países</a></li><li><a href="cidades.php">Cidades</a></li><li><a href="governantes.php">Governantes</a></li></ul></nav>
<?php if(ehAdministrador()): ?><main><form method="post" onsubmit="return validarFormulario();"><h2><?=$editar?"Editar Cidade":"Cadastrar Cidade"?></h2>
<input type="hidden" name="id" value="<?=htmlspecialchars($id_cidade)?>">
<label>Nome da Cidade</label><input type="text" name="nome" required value="<?=htmlspecialchars($nome)?>">
<label>País</label><select name="id_pais" required><option value="">Selecione um País</option>
<?php $r=mysqli_query($conexao,"SELECT id_pais,nome FROM tb_paises ORDER BY nome");while($p=mysqli_fetch_assoc($r)):?><option value="<?=$p['id_pais']?>" <?=$p['id_pais']==$id_pais?'selected':''?>><?=htmlspecialchars($p['nome'])?></option><?php endwhile;?></select>
<label>População</label><input type="number" name="populacao" required value="<?=htmlspecialchars($populacao)?>">
<label>Governante / Prefeito (Opcional)</label><select name="id_governante"><option value="">Selecione um Governante</option>
<?php $r=mysqli_query($conexao,"SELECT id_governante,nome FROM tb_governantes ORDER BY nome");while($g=mysqli_fetch_assoc($r)):?><option value="<?=$g['id_governante']?>" <?=$g['id_governante']==$id_governante?'selected':''?>><?=htmlspecialchars($g['nome'])?></option><?php endwhile;?></select>
<label>Clima</label><input type="text" name="clima" required value="<?=htmlspecialchars($clima)?>">
<label>Data de Fundação</label><input type="date" name="dt_fundacao" required value="<?=htmlspecialchars($dt_fundacao)?>">
<button type="submit" name="salvar"><?=$editar?"Atualizar Cidade":"Cadastrar Cidade"?></button></form></main><?php endif;?>
<table><tr><th>ID</th><th>Cidade</th><th>País</th><th>População</th><th>Clima</th><th>Governante</th><?php if(ehAdministrador()):?><th>Ações</th><?php endif;?></tr>
<?php $sql=mysqli_query($conexao,"SELECT tb_cidades.*,tb_paises.nome AS pais,tb_governantes.nome AS governante FROM tb_cidades LEFT JOIN tb_paises ON tb_cidades.id_pais=tb_paises.id_pais LEFT JOIN tb_governantes ON tb_cidades.id_governante=tb_governantes.id_governante ORDER BY tb_cidades.nome");while($d=mysqli_fetch_assoc($sql)):?>
<tr><td><?=$d['id_cidade']?></td><td><?=htmlspecialchars($d['nome'])?></td><td><?=htmlspecialchars($d['pais'])?></td><td><?=number_format($d['populacao'],0,",",".")?></td><td><?=htmlspecialchars($d['clima'])?></td><td><?=htmlspecialchars($d['governante']??'Não informado')?></td>
<?php if(ehAdministrador()):?><td><a class="editar" href="cidades.php?editar=<?=$d['id_cidade']?>">Editar</a> | <a class="excluir" href="cidades.php?excluir=<?=$d['id_cidade']?>" onclick="return confirmarExclusao();">Excluir</a></td><?php endif;?></tr>
<?php endwhile;?></table><p style="text-align:center;margin:20px;"><a href="index.php">Voltar ao início</a> | <a href="logout.php">Sair</a></p></body></html>
