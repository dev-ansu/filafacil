export class FlashMessages{
    onlyOne = false;
    static defaultTime = 7;

    static messageTemplate(message, time, type) {
        return `
            <span style="transition: all 0.6s ease-in-out;" class="alert alert-${type} d-flex flex-column">
                <span class="d-flex justify-content-between align-items-center">
                    ${message}
                    <span class="btn mx-1 btn-close"></span>
                </span>
                <div style="font-size:12px;min-height:12px;background:#ccc" class="rounded">
                    <span class="tempo-decorrido rounded bg-${type}" data-time="${time}">${this.defaultTime}s</span>                    
                </div>
            </span>
        `;
    }

    btnClose(alertElement, intervalId) {
        const btn = alertElement.querySelector(".btn-close");
        btn.addEventListener("click", () => {
            clearInterval(intervalId);
            alertElement.remove();
        });
    }

    static updateProgress(alertElement, time) {
        const progressBar = alertElement.querySelector(".tempo-decorrido");
        let tempoRestante = time;
        const intervalId = setInterval(() => {
            if (tempoRestante >= 0) {
                progressBar.style.width = `${(tempoRestante / time) * 100}%`;
                progressBar.textContent = `${tempoRestante}s`;
                tempoRestante -= 1;
            } else {
                clearInterval(intervalId);
                alertElement.remove();
            }
        }, 1000);

        return intervalId;
    }

    static print(message, time = FlashMessages.defaultTime, type = 'danger') {
        FlashMessages.showMessage(message, time, type);
    }

    static showMessage(message, time, type) {
        FlashMessages.ensureContainerExists();
        const mensagemInformacional = document.getElementById("mensagem-informacional");
        const messageHtml = FlashMessages.messageTemplate(message, time, type);
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = messageHtml;

        // Adicionar mensagem sem recriar todas
        if (FlashMessages.onlyOne) {
            mensagemInformacional.innerHTML = '';
        }
        mensagemInformacional.appendChild(tempDiv.firstElementChild);

        // Get the newly added alert element
        const newAlert = mensagemInformacional.lastElementChild;
        if (newAlert) {
            const intervalId = FlashMessages.updateProgress(newAlert, time);
            const flash = new FlashMessages();
            flash.btnClose(newAlert, intervalId);
        } else {
            console.error("Failed to find the newly added alert element.");
        }
    }

    static ensureContainerExists() {
        if (!document.getElementById("mensagem-informacional")) {
            const div = document.createElement("div");
            div.id = "mensagem-informacional";
            div.style.overflowY = "auto";
            div.style.maxHeight = "100vh";
            div.classList.add("d-flex", "flex-column", "align-items-end");
            document.body.appendChild(div);
        }
    }


        /**
     * ${1:Description placeholder}
     *
     * @static
     * @param {*} message
     */
    static success(message, time = FlashMessages.defaultTime){
        FlashMessages.print(message, time, 'success')
        return FlashMessages;
    }

        /**
     * ${1:Description placeholder}
     *
     * @static
     * @param {*} message
     */
    static primary(message, time = FlashMessages.defaultTime){
        FlashMessages.print(message, time, 'primary')
        return FlashMessages;
    }
        
        /**
     * ${1:Description placeholder}
     *
     * @static
     * @param {*} message
     */
    static danger(message, time = FlashMessages.defaultTime){
        FlashMessages.print(message, time, 'danger')
        return FlashMessages;
    }

        /**
     * ${1:Description placeholder}
     *
     * @static
     * @param {*} message
     */
    static warning(message, time = FlashMessages.defaultTime){
        FlashMessages.print(message, time, 'warning')
        return FlashMessages;
    }
    static unique(value = true){
        FlashMessages.onlyOne = value;
    }
}