divTelefone = document.getElementById("userPhone");

divTelefone.setAttribute("onkeydown", "autoCorrectPhone(event)");

function autoCorrectPhone(key){
    if (key.code.includes("Digit")){
        // check and correct input value
        divTelefone.value =  divTelefone.value.replace(/[^\s0-9()-]/ig,"");
        if (divTelefone.value.length > 2){
            if (divTelefone.value.includes("(") == false || divTelefone.value.includes(")") == false || divTelefone.value.includes(" ") == false){
                if (divTelefone.value.includes("(") == false){
                    divTelefone.value = `(${divTelefone.value}`;
                }else if (divTelefone.value.includes(")") == false){
                    divTelefone.value = `${divTelefone.value.substr(0,3)})${divTelefone.value.substr(3)}`;
                }else if (divTelefone.value.charAt(4) != " "){
                    divTelefone.value = `${divTelefone.value.substr(0,4)} ${divTelefone.value.substr(4)}`;
                }
            }
        }

        // Change the input value
        if (divTelefone.value.length == 2){
            if (divTelefone.value.includes("(") == false && divTelefone.value.includes(")") == false){
                divTelefone.value = `(${divTelefone.value.substr(0,2)}) ${divTelefone.value.charAt(2)}`;
            }
        }else if (divTelefone.value.length == 10){
            if (divTelefone.value.includes("-") == false){
                divTelefone.value = `${divTelefone.value.substr(0, divTelefone.value.length)}-`;
            }
        }
    }
}