import {FlashMessages} from "./classes/FlashMessages.js";
import { http } from "./classes/http.js";

const getBlockPermissions = async(e)=>{
    const idcargo = e.target.value.trim();

    const response = await http.post("/admin/configuracoes/getPermissionsBlocked", {id: idcargo});
    console.log(response);
    if(response.success){
        $("#permissions_container_form").html("");
        $("#permissions_container_form").append(`
            <span data-checked="false"  id="btn-selecionar-tudo" class="btn btn-secondary m-3 justify-self-start align-items-start">Marcar todos</span>
        `);
        response.data.forEach(permission =>{
            $("#permissions_container_form").append(`
                <div class="form-group d-flex flex-column bg-primary rounded p-2 text-white">
                    <div class="d-flex gap-1">
                        <label for="${permission.id}">${permission.surname}</label>
                        <input  id="${permission.id}" ${permission.idcargo ? "checked":""} type="checkbox" name="idpermission[]" class='form-checkbox-permission' value="${permission.id}" />
                    </div>
                    <span>
                        ${permission.description}
                    </span>
                </div>
            `)
        })
    }
}

$(document).on("input", "#form-block-permissions #idcargo", getBlockPermissions)

const checkOrUncheckAll = (check = true, allFormCheckbox, text)=>{
   
    allFormCheckbox.forEach(el =>{
        el.checked = check;
        $("#btn-selecionar-tudo").text(text)
        document.getElementById("btn-selecionar-tudo").dataset.checked = check;
    })
    
} 

const verifyIfIsToCheckAll = (e)=>{
    e.preventDefault();
    const allChecked = e.currentTarget.dataset.checked;
    const allFormCheckbox = document.querySelectorAll(".form-checkbox-permission")
    if(allChecked == 'false'){
        checkOrUncheckAll(true, allFormCheckbox, 'Desmarcar todos');
    }else if(allChecked == "true"){
        checkOrUncheckAll(false, allFormCheckbox, 'Marcar todos')
    }
}
$(document).on("click", "#btn-selecionar-tudo",verifyIfIsToCheckAll)
