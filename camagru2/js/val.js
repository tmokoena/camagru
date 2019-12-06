function val() {
    var eerror      = document.getElementById('eerror');
    var email       = document.getElementById('email');
    if (email.value == ""){
        email.style.borderColor = "red";        
        eerror.style.color = "red";
        eerror.textContent = "this feild can't be empty!!";
        email.focus();
        return false;}else{email.style.borderColor = ""; eerror.textContent = ""; }
} 