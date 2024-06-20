export class CreateDateTime{

    static createDate(){
        const objDate = new Date();
        return objDate;
    }
    static getDate(){
        return CreateDateTime.createDate().toLocaleDateString("pt-br");
    }
    static getTime(){
        return CreateDateTime.createDate().toLocaleTimeString("pt-br");
    }
    static getDateTime(){
        return `${this.getDate(), this.getTime()}`;
    }
}