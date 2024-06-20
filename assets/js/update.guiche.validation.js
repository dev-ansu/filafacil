import {FlashMessages} from "./classes/FlashMessages.js";
import { http } from "./classes/http.js";
import UpdateGuichesValidation from "./classes/UpdateGuichesValidation.js";
const validate = new UpdateGuichesValidation;
const editarGuiche = document.getElementById('editarGuiche')



const update = async(e)=>{
    e.preventDefault();
    validate.validated();

    if(!validate.errors()){
        const _csrf = await http.get("/api/csrf");
        const formData = new FormData(e.target);

        formData.append("_csrf", _csrf);

        const res = await http.post("/admin/guiches/update", formData);
        if(res.success){
            FlashMessages.success(res.message);
            $('#guiches-table').DataTable().ajax.reload();
        }else{
            FlashMessages.danger(res.message);
            console.log(res.errors)
            if(res.errors){
                for(let error in res.errors){
                    for(let message in res.errors[error]){
                        FlashMessages.danger(res.errors[error][message]);
                    }
                }
            }
        }
    }else{
        const errors = validate.errors();
        for(let error in errors){
            for(let message in errors[error]){
                FlashMessages.danger(errors[error][message]);
            }
        }
    }
}

if (editarGuiche) {
    editarGuiche.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id')
        const guiche = button.getAttribute('data-bs-guiche')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const inputId = editarGuiche.querySelector('.modal-body #id')
        const inputGuiche = editarGuiche.querySelector('.modal-body #guiche')

        inputId.value = id
        inputGuiche.value = guiche;

    })  
}

validate.on("#form-guiche-update", "input",(e)=>{
    let $value = validate.custom((e)=>{
        return e.target.value ? e.target.value.replace(/\D/g, ''):'';
    }, e);
    if(!$value){
        FlashMessages.warning("O campo 'número do guichê' deve ser um inteiro");
    }
    e.target.value = $value;
});

$(document).on("submit", "#form-guiche-update", update)
