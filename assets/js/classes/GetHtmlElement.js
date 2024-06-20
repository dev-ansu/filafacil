export class GetHtmlElement{
    #el;
    constructor(tag, isClass = false){
        this.tag = tag;
        this.isClass = isClass;
        this.getElement();
    }

    get(){
        return this.#el;
    }

    getElement(){
        if(this.isClass){
            let el = document.querySelectorAll(this.tag)
            this.#el = el;
        }else{
            let el = document.querySelector(this.tag);
            this.#el = el;
        }
    }
    
}