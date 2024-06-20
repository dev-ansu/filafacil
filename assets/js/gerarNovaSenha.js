import {getNewPass} from "./api/api.js";

const gerarNovaSenha = $("#gerarNovaSenha")

$(document).on("shown.bs.modal", "#gerarNovaSenha", async()=>{
    $(gerarNovaSenha).find("#gerarNovaSenhaLabel").html('Gerando senha...');
    $("#btnGerarNovaSenha").attr("disabled", true);
    const response = await getNewPass();
    if(response.success){
        $(gerarNovaSenha).find("#senhaGerada").html(response.data);
        $(gerarNovaSenha).find("#gerarNovaSenhaLabel").html('Senha gerada');
        $("#btnGerarNovaSenha").removeAttr("disabled");
    }else{
        $(gerarNovaSenha).find("#senhaGerada").html(response.message);
        $("#btnGerarNovaSenha").removeAttr("disabled");
    }
});

$(document).on("hidden.bs.modal", "#gerarNovaSenha", ()=>{
    $(gerarNovaSenha).find("#senhaGerada").html('');
});


