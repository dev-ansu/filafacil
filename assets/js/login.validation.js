import {FlashMessages} from "./classes/FlashMessages.js";
import LoginValidation from "./classes/LoginValidation.js";
import {http} from "./classes/http.js";
import Validation from "./classes/Validation.js";

const validate = new Validation

validate.on("#user", "blur",async (e)=>{
    if(e.target.value){
        const user = await validate.custom(async(value)=>{
            return await http.post("/api/getUser", {user:value})
        }, e.target.value)
        if(user.success == false){
            FlashMessages.danger(`O usuário ${e.target.value} não foi encontrado. Digite um usuário válido.`).unique();
            $("#btn-login").attr("disabled",true);
        }else{
            $("#btn-login").removeAttr("disabled");
        }
    }
});

const auth = (e)=>{
    e.preventDefault();
    const validate = new LoginValidation;
        
    validate.validated();
    
    if(!validate.errors()){
        e.target.submit();
    }else{
        const errors = validate.errors();
        for(let error in errors){
            for(let message in errors[error]){
                FlashMessages.danger(errors[error][message]).unique(false);
            }
        }
    }
}

$(document).on("submit", "#form-login", auth)
