import {FlashMessages} from "./classes/FlashMessages.js";
import StoreGuicheValidation from "./classes/StoreGuicheValidation.js";
const validate = new StoreGuicheValidation;



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

validate.on("#form-guiche-store", "input",(e)=>{
    let $value = validate.custom((e)=>{
        return e.target.value ? e.target.value.replace(/\D/g, ''):'';
    }, e);
    if(!$value){
        FlashMessages.warning("O campo 'número do guichê' deve ser um inteiro");
    }
    e.target.value = $value;
});

$(document).on("submit", "#form-guiche-store", store)
