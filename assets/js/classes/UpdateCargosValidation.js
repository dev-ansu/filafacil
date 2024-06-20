import Validation from "./Validation.js";

/**
 * Classe de validação dos campos do formulário de login
 * @function rules - método que retorna as regras de validação dos campos
 * @function messages - método que define as mensagens que deverão aparecer para o usuário
 * quando os campos forem validados
 * @example 
 * // Exemplo de uso
 * rules(){
 *   return{
 *      user: 'required|minlen:3',
 *      password:'required'
 *   }
 * }
 * messages(){
 *       return {
 *           "user.required":"O campo usuário é obrigatório.",
 *           "user.minlen":"O campo usuário deve ter no mínimo 3 caracteres",
 *           "password.required":"O campo senha é obrigatório.",
 *       }
 *   }
 */
export default class UpdateCargosValidation extends Validation{

    /**
     * @function validated
     * @description Chama o método validate() passando como parâmetro o objeto this
     * @example
     * // Exemplo de uso
     * const validation = new LoginValidation()
     * validation.validated()
     * @returns void
     */
    validated(){
        this.validate(this);
    }

    /**
     * Método que retorna as regras de validação 
     * @returns object
     */
    rules(){
        return {
            'id':'required',
            'cargo': 'required',
            'salario':'required'
        };
    }
    /**
     * @function messages
     * @description Define as mensagens que deverão ser apresentadas ao usuário
     * quando a validação dos campos terminar
     * @returns object
     */
    messages(){
        return {
            "cargo.required":"O campo cargo é obrigatório.",
            "salario.required":"O campo salário é obrigatório."
        }
    }

}