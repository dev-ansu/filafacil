import {FlashMessages} from "./classes/FlashMessages.js";
import StoreUserValidation from "./classes/StoreUserValidation.js";
import {http} from "./classes/http.js";
import Validation from "./classes/Validation.js";

const validate = new Validation



validate.on("#user", "blur",async (e)=>{
    if(e.target.value){ 
        const user = await validate.custom(async(value)=>{
            return await http.post("/api/getUser", {user:value})
        }, e.target.value)
        if(user.success == true){
            FlashMessages.warning(`O usuário ${e.target.value} já existe. Escolha outro!`).unique();
            $("#btn-create-user").attr("disabled",true);
        }else{
            $("#btn-create-user").removeAttr("disabled");
        }
    }
});

const store = (e)=>{
    e.preventDefault();
         
    const validate = new StoreUserValidation;
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

$(document).on("submit", "#form-store-user", store)
