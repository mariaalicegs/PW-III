<?php
require_once("auth.php"); exigirLogin(); include("conexao.php");
if(isset($_POST['salvar'])||isset($_GET['excluir'])||isset($_GET['editar'])) exigirTipoA();

if(isset($_GET['excluir'])){$id=(int)$_GET['excluir'];mysqli_query($conexao,"DELETE FROM tb_governantes WHERE id_governante=$id");header("Location: governantes.php");exit();}
$editar=false;$id_governante=$nome=$partido=$dt_nascimento=$idade=$inicio_mandato=$fim_mandato="";
if(isset($_GET['editar'])){$editar=true;$id=(int)$_GET['editar'];$r=mysqli_query($conexao,"SELECT * FROM tb_governantes WHERE id_governante=$id");if($d=mysqli_fetch_assoc($r)){foreach(['id_governante','nome','partido','dt_nascimento','idade','inicio_mandato','fim_mandato'] as $f)$$f=$d[$f];}}
if(isset($_POST['salvar'])){
$id=$_POST['id'];$nome=$_POST['nome'];$partido=$_POST['partido'];$dt_nascimento=$_POST['dt_nascimento'];$idade=(int)$_POST['idade'];$inicio_mandato=$_POST['inicio_mandato'];
$fim_mandato=$_POST['fim_mandato']===""?"NULL":"'".$_POST['fim_mandato']."'";
if($id==="")mysqli_query($conexao,"INSERT INTO tb_governantes(nome,partido,dt_nascimento,idade,inicio_mandato,fim_mandato) VALUES('$nome','$partido','$dt_nascimento',$idade,'$inicio_mandato',$fim_mandato)");
else mysqli_query($conexao,"UPDATE tb_governantes SET nome='$nome',partido='$partido',dt_nascimento='$dt_nascimento',idade=$idade,inicio_mandato='$inicio_mandato',fim_mandato=$fim_mandato WHERE id_governante=$id");
header("Location: governantes.php");exit();}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Governantes</title>
<link rel="stylesheet" href="css/css_mundo.css"><script src="js/script.js"></script></head><body>
<header><h1>Cadastro de Governantes</h1></header>
<nav><ul><li><a href="index.php">Início</a></li><li><a href="continentes.php">Continentes</a></li><li><a href="paises.php">Países</a></li><li><a href="cidades.php">Cidades</a></li><li><a href="governantes.php">Governantes</a></li></ul></nav>
<?php if(ehAdministrador()):?><main><form method="post" onsubmit="return validarFormulario();"><input type="hidden" name="id" value="<?=htmlspecialchars($id_governante)?>">
<label>Nome</label><input type="text" name="nome" required value="<?=htmlspecialchars($nome)?>">
<label>Partido</label><input type="text" name="partido" required value="<?=htmlspecialchars($partido)?>">
<label>Data de Nascimento</label><input type="date" name="dt_nascimento" required value="<?=htmlspecialchars($dt_nascimento)?>">
<label>Idade</label><input type="number" name="idade" required value="<?=htmlspecialchars($idade)?>">
<label>Início do Mandato</label><input type="date" name="inicio_mandato" required value="<?=htmlspecialchars($inicio_mandato)?>">
<label>Fim do Mandato (Opcional)</label><input type="date" name="fim_mandato" value="<?=htmlspecialchars($fim_mandato??'')?>">
<button type="submit" name="salvar"><?=$editar?"Atualizar Governante":"Cadastrar Governante"?></button></form></main><?php endif;?>
<table><tr><th>ID</th><th>Nome</th><th>Partido</th><th>Idade</th><th>Início Mandato</th><th>Fim Mandato</th><?php if(ehAdministrador()):?><th>Ações</th><?php endif;?></tr>
<?php $sql=mysqli_query($conexao,"SELECT * FROM tb_governantes ORDER BY nome");while($d=mysqli_fetch_assoc($sql)):?>
<tr><td><?=$d['id_governante']?></td><td><?=htmlspecialchars($d['nome'])?></td><td><?=htmlspecialchars($d['partido'])?></td><td><?=$d['idade']?> anos</td><td><?=date('d/m/Y',strtotime($d['inicio_mandato']))?></td><td><?=$d['fim_mandato']?date('d/m/Y',strtotime($d['fim_mandato'])):'Em exercício'?></td>
<?php if(ehAdministrador()):?><td><a class="editar" href="governantes.php?editar=<?=$d['id_governante']?>">Editar</a> | <a class="excluir" href="governantes.php?excluir=<?=$d['id_governante']?>" onclick="return confirmarExclusao();">Excluir</a></td><?php endif;?></tr>
<?php endwhile;?></table><p style="text-align:center;margin:20px;"><a href="index.php">Voltar ao início</a> | <a href="logout.php">Sair</a></p></body></html>
