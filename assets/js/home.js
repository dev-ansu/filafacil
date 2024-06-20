import { getAverageWaitTime } from "./api/api.js";
import { http } from "./classes/http.js";

const setAverageTime = async()=>{
    const averageTime = await getAverageWaitTime();
    if(averageTime.success){
        const hora = averageTime.data.split(":")[0]
        const minutos = averageTime.data.split(":")[1]
        const segundos = averageTime.data.split(":")[2]
        let textTempo;

        if(hora != '00' || minutos != '00' || segundos != '00'){
            textTempo = `Tempo médio de espera ${hora != "00" ? hora+" hora(s),":""} ${minutos != "00" ? minutos+" minuto(s) e":""} ${segundos != "00" ? segundos+" segundo(s).":""}`
        }

        $("#container_show_pass #tempo_espera").html(`${textTempo ?? ''}`);
    }
}

const source = new EventSource('/filafacil/api/sendPassToFront');
const fetchCalledPrevious = async()=>{
    const previous = await http.get("/api/getAllPreviousCalled");

    if(previous.data){
        $("#previous_pass_container").html("");
        await setAverageTime();
        previous.data.forEach(el =>{
            $("#previous_pass_container").append(`
            <div class="card h-100 card_previous_pass bg-transparent border">
                <div class="card-body d-flex flex-column text-white text-center align-items-center justify-content-center">
                    <h4 class="fs-1 fw-bold">${el.pass_generated}</h4>
                    <h4 class="fs-2 fw-bold">${el.pc}</h4>
                </div>
            </div>
            `)
        })
    }
}

source.addEventListener("message", async (event)=>{
    let data = JSON.parse(event.data);
    $("#actual_pass").html(data.pass);
    $("#actual_guiche").html(data.guiche);
    await fetchCalledPrevious();
});