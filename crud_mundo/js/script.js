function confirmarExclusao(){

    return confirm("Deseja realmente excluir este registro?");

}

function validarFormulario(){

    let campos = document.querySelectorAll("input[required], select[required]");

    for(let campo of campos){

        if(campo.value.trim() == ""){

            alert("Preencha todos os campos obrigatórios.");

            campo.focus();

            return false;

        }

    }

    return true;

}