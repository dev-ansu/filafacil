import { getAverageWaitTime } from "./api/api.js";


export const setAverageTime = async(selector)=>{
    $(selector).ready(async()=>{
        let averageTime = await getAverageWaitTime();
        if(averageTime.success){
            $(selector).html(averageTime.data);
        }
    });
}

$("#card-tempo-espera #tempo_espera").ready(async()=>{
    await setAverageTime("#card-tempo-espera #tempo_espera");
})