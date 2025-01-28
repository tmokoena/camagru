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
    var err             = document.getElementById('uerror');
    var username        = document.getElementById('11');
    var email           = document.getElementById('22');
    var stat            = document.getElementById('chk');
    var oldpwd          = document.getElementById('1');
    var newpwd          = document.getElementById('2');
    var conpwd          = document.getElementById('3');
    var strongRegex     = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    var emailRegEx      = new RegExp("^(([^<>()[]\.,;:s@]+(.[^<>()[]\.,;:s@]+)*)|(.+))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,}))$");

    if (username.value == ""){username.style.borderColor = "red"; err.innerHTML = "Username shouldn't be empty!"; return false;}else{username.style.borderColor = "";err.innerHTML = "";}
    if (username.value.length < 5){username.style.borderColor = "red"; return false;}else{username.style.borderColor = "";}
    if (email.value == ""){email.style.borderColor = "red"; err.innerHTML = "E-mail shouldn't be empty!"; return false;}else{email.style.borderColor = ""; err.innerHTML = "";}
    if(emailRegEx.test(email.value) == false){email.style.borderColor = "red"; err.innerHTML = "Your E-mail is Invalid!"; return false;}else{email.style.borderColor = ""; err.innerHTML ='';}
    if (stat.checked == 1)
    {
        if (oldpwd.value == ""){oldpwd.style.borderColor = "red"; err.innerHTML = "Please Insert Your Old Password!"; return false;}else{oldpwd.style.borderColor = ""; err.innerHTML ='';}
        if (newpwd.value == ""){newpwd.style.borderColor = "red"; err.innerHTML = "Please Insert Your New Password!"; return false;}else{newpwd.style.borderColor = ""; err.innerHTML ='';}
        if (newpwd.value.length < 5){
            newpwd.style.borderColor = "red";
            err.textContent = "Password length of over 4 charactors is required!"; 
             document.getElementById('mit').disabled = true;
             return false;
        }else{newpwd.style.borderColor = "";err.textContent = "";document.getElementById('mit').disabled = false;}
        if (conpwd.value == ""){conpwd.style.borderColor = "red"; return false;}else{conpwd.style.borderColor = "";}
        if(strongRegex.test(newpwd.value) == false){
            newpwd.style.borderColor = "red";
            err.textContent = "Your Password is not Strong!"; 
            document.getElementById('mit').disabled = true;
            return false;
        }else{newpwd.style.borderColor = "";err.textContent = "";document.getElementById('mit').disabled = false;}
    }
}

function same() {
    var err             = document.getElementById('uerror');
    var newpwd      = document.getElementById('2');
    var conpwd      = document.getElementById('3');
    var nerror      = document.getElementById('nerror');
    var cerror      = document.getElementById('cerror');


    if (newpwd.value.localeCompare(conpwd.value) != 0){
        err.textContent = "Your Passwords dont match!"
        newpwd.style.borderColor = "red"; 
        conpwd.style.borderColor = "red";
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
        }else{newpwd.style.borderColor = "";err.textContent = "";document.getElementById('mit').disabled = false;}
    }
}


