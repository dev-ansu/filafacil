import {http} from "./http.js";

export const in_array = (haystack, needle, strict = false)=>{
    if(typeof haystack === 'object'){
        const values = Object.values(haystack);
        if(strict) return values.some((value) => value === needle);
        return values.some((value) => value == needle);
    }else if(Array.isArray(haystack)){
        if(strict) return haystack.some((value) => value === needle);
        return haystack.some((value) => value == needle);
    }
    const type = typeof haystack;
    throw new Error('Type of haystack needle to be Array or Object. ' + type.toUpperCase() + ' passed.');
}

export const getUser = async (user)=>{
    return await http.post("/api/getUser", {user})
}