function enable_text()
{
    var stat = document.getElementById('chk');
    var txt = document.getElementsByClassName("pass");
    var t = Array.from(txt);

    if (stat.checked == 1)
        t.forEach(tx => {
            tx.disabled = false;
        });
    else
        t.forEach(tx => {
            tx.disabled = true;
        });
}

function validate() {
    var username    = document.getElementById('11');
    var email       = document.getElementById('22');
    var stat        = document.getElementById('chk');
    var oldpwd      = document.getElementById('1');
    var newpwd      = document.getElementById('2');
    var conpwd      = document.getElementById('3');

    if (username.value == ""){username.style.borderColor = "red"; return false;}else{username.style.borderColor = "";}
    if (username.value.length < 5){username.style.borderColor = "red"; return false;}else{username.style.borderColor = "";}
    if (email.value == ""){email.style.borderColor = "red"; return false;}else{email.style.borderColor = "";}
    if (stat.checked == 1)
    {
        if (oldpwd.value == ""){oldpwd.style.borderColor = "red"; return false;}else{oldpwd.style.borderColor = "";}
        if (newpwd.value == ""){newpwd.style.borderColor = "red"; return false;}else{newpwd.style.borderColor = "";}
        if (newpwd.value.length < 5){
            newpwd.style.borderColor = "red";
            nerror.style.color = "red"; 
            nerror.textContent = "Password length of over 4 charactors is required!"; 
             document.getElementById('mit').disabled = true;
             return false;
        }else{newpwd.style.borderColor = "";nerror.textContent = "";document.getElementById('mit').disabled = false;}
        if (conpwd.value == ""){conpwd.style.borderColor = "red"; return false;}else{conpwd.style.borderColor = "";}
    }
}

function same() {
    var newpwd      = document.getElementById('2');
    var conpwd      = document.getElementById('3');
    var nerror      = document.getElementById('nerror');
    var cerror      = document.getElementById('cerror');



    if (newpwd.value.localeCompare(conpwd.value) != 0){
        cerror.style.color = "red"; 
        newpwd.style.borderColor = "red"; 
        conpwd.style.borderColor = "red";
        cerror.textContent = "Your Passwords dont match!"
        document.getElementById('mit').disabled = true;

        
    }else{        
        cerror.textContent = "";
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