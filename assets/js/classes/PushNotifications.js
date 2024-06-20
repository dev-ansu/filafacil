import config from "../config.js";

export class PushNotifications{
    #ws;
    constructor(id, message){
        this.id = id;
        this.message = message;
        this.#ws = new WebSocket(config[0].URL_WS);
    }
    send(){
        let dados = {
            id: this.id,
            message: this.message,
        }
        this.#ws.send(JSON.stringify(dados));
    }
    message(){
        this.#ws.onmessage = (msg)=>{
            return msg;
        }
    }
}