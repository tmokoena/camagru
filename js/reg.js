function validate() {
    var username        =   document.getElementById('username');
    var email           =   document.getElementById('email');
    var pwd             =   document.getElementById('pwd');
    var cpwd            =   document.getElementById('cpwd');
    var err             =   document.getElementById('err');
    var strongRegex     = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    var emailRegEx      = new RegExp("^(([^<>()[]\.,;:s@]+(.[^<>()[]\.,;:s@]+)*)|(.+))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,}))$");

    if (username.value == '' || email.value == '' || pwd.value =='' || cpwd.value ==''){
        err.innerHTML ="Please type in your login details!";
        if (email.value ==''){email.style.borderColor = "red";}else{email.style.borderColor = "";}
        if (pwd.value == ''){pwd.style.borderColor = "red";}else{pwd.style.borderColor = "";}
        if (cpwd.value ==''){cpwd.style.borderColor = "red";}else{cpwd.style.borderColor = "";}
        if (username.value == ''){username.style.borderColor = "red";}else{username.style.borderColor = "";}
        return false;
    }

    if (!emailRegEx.test(email.value))
    {
        err.innerHTML ="Your E-mail is invalid!";
        return false;
    }

    // console.log(strongRegex.test(pwd.value));
    if(!strongRegex.test(pwd.value)){
        err.innerHTML = "Your password is not strong enough!"
        return false;
    }
    // console.log(!pwd.value.match(cpwd.value));
    if(!pwd.value.match(cpwd.value)){
        err.innerHTML ="Your Passwords don't match!";
        return false;
    }
    
    
}