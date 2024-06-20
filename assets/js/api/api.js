import { http } from "../classes/http.js";

export const getNewPass = async()=>{
    const response = await http.get("/admin/home/getNewPass");
    return response;
}

export const getAverageWaitTime = async()=>{
    const averageTime = await http.get("/api/getAverageWaitTime");
    return averageTime;
}
