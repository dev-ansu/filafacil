import {FlashMessages} from "./classes/FlashMessages.js";
import UpdateCargosValidation from "./classes/UpdateCargosValidation.js";
import {http} from "./classes/http.js";
const validate = new UpdateCargosValidation;
const editarCargo = document.getElementById('editarCargo')


const update = async (e)=>{
    e.preventDefault();
    validate.validated();

    if(!validate.errors()){
        const _csrf = await http.get("/api/csrf");
        const formData = new FormData(e.target);

        formData.append("_csrf", _csrf);

        const res = await http.post("/admin/cargos/update", formData);
        if(res.success){
            FlashMessages.success(res.message);
            $('#cargos-table').DataTable().ajax.reload();
        }else{
            FlashMessages.danger(res.message);
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

if (editarCargo) {
    editarCargo.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const idcargo = button.getAttribute('data-bs-idcargo')
        const cargo = button.getAttribute('data-bs-cargo')
        const salario = button.getAttribute('data-bs-salario')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const inputIdCargo = editarCargo.querySelector('.modal-body #idcargo')
        const inputCargo = editarCargo.querySelector('.modal-body #cargo')
        const inputSalario = editarCargo.querySelector('.modal-body #salario')

        inputIdCargo.value = idcargo
        inputCargo.value = cargo;
        inputSalario.value = salario;
    })  
}

$('#form-cargos-update #salario').mask('#0.00', {reverse: true});

$(document).on("submit", "#form-cargos-update", update)
