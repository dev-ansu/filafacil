import {getNewPass} from "./api/api.js";
import { setAverageTime } from "./averageTime.js";
import { FlashMessages } from "./classes/FlashMessages.js";
import { http } from "./classes/http.js";

const chamarSenha = $("#chamarSenha")





$(document).on("shown.bs.modal", "#chamarSenha", async()=>{
    $(chamarSenha).find("#chamarSenhaLabel").html('Chamando senha...');
    $("#btnchamarSenha").attr("disabled", true);
    const response = await http.get('/admin/home/callNewPass');
    if(response.success){
        $(chamarSenha).find("#senhaChamada").html(response.data);
        $(chamarSenha).find("#chamarSenhaLabel").html('Senha chamada');
        FlashMessages.success(response.message);
        $("#btnchamarSenha").removeAttr("disabled");
        await setAverageTime("#card-tempo-espera #tempo_espera");
    }else{
        $(chamarSenha).find("#senhaChamada").html(response.message);
        $(chamarSenha).find("#chamarSenhaLabel").html('Senha chamada');
        $("#btnchamarSenha").removeAttr("disabled");
    }
});

$(document).on("hidden.bs.modal", "#chamarSenha", ()=>{
    $(chamarSenha).find("#senhaChamada").html('');
});


