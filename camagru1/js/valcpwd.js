function valcpwd(){
    var npwd      = document.getElementById('2');
    var eerror      = document.getElementById('eerror');
    if (npwd.value == ""){
        npwd.style.borderColor = "red";        
        eerror.style.color = "red";
        eerror.textContent = "this feild can't be empty!!";
        npwd.focus();
        return false;}else{npwd.style.borderColor = ""; eerror.textContent = ""; }
}

function same() {
    var newpwd      = document.getElementById('2');
    var conpwd      = document.getElementById('3');
    var nerror      = document.getElementById('eerror');



    if (newpwd.value.localeCompare(conpwd.value) != 0){
        nerror.style.color = "red"; 
        nerror.textContent = "Your Passwords dont match!"
        newpwd.style.borderColor = "red"; 
        conpwd.style.borderColor = "red";
        document.getElementById('mit').disabled = true;

        
    }else{        
        nerror.textContent = "";
        newpwd.style.borderColor = "white"; 
        conpwd.style.borderColor = "white";
        document.getElementById('mit').disabled = false;
        if (newpwd.value.length < 5){
            newpwd.style.borderColor = "red";
            nerror.style.color = "red"; 
            nerror.textContent = "Password length of over 4 charactors is required!"; 
            document.getElementById('mit').disabled = true;
        }else{newpwd.style.borderColor = "";nerror.textContent = "";document.getElementById('mit').disabled = false;}
    }
}