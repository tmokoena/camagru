
function validate() {
    var email       =   document.getElementById('email');
    var pwd         =   document.getElementById('pwd');
    var err         =   document.getElementById('err');

    if (email.value =='' || pwd.value == ''){
        err.innerHTML ="Please type in your login details!";
        if (email.value ==''){email.style.borderColor = "red";}else{email.style.borderColor = ''}
        if (pwd.value == ''){pwd.style.borderColor = "red";}else{pwd.style.borderColor = "";}
        return false;
    }
}