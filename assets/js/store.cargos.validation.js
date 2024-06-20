import {FlashMessages} from "./classes/FlashMessages.js";
import StoreCargosValidation from "./classes/StoreCargosValidation.js";
const validate = new StoreCargosValidation;



const store = (e)=>{
    e.preventDefault();
    validate.validated();

    if(!validate.errors()){
        e.target.submit();
    }else{
        const errors = validate.errors();
        for(let error in errors){
            for(let message in errors[error]){
                FlashMessages.danger(errors[error][message]);
            }
        }
    }
}

$('#form-cargos-store #salario').mask('#0.00', {reverse: true});

$(document).on("submit", "#form-cargos-store", store)
