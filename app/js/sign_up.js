/** Get translation of error messages by ajax */
function t(str, target, mod = 0) {
    $.post(root.value + 'translator/t', {str: str}, function (res) {
        if (mod === 0) {
            target.innerHTML = JSON.parse(res);
        } else {
            target.innerHTML += JSON.parse(res);
        }
    });
}

/** Verify that the login is correct */
function validLogin(mod = 0) {
    let loginVal = login.value;
    let patt = /^[a-z0-9_-]+$/i;
    if (loginVal === "") {
        t('FILL_FIELD_LOGIN', err_log);
        return false;
    } else if (!patt.test(loginVal)) {
        t('LOGIN_INVALID', err_log);
        return false;
    } else if (mod === 0){
        $.post(root.value + 'user/valid-login', {login: loginVal}, function(r){
            let obj = JSON.parse(r);
            if (obj.res === true) {
                err_log.innerHTML = loginVal + ' ';
                t('NAME_USED', err_log, 1);
                return false;
            }
        })
    }
    err_log.innerHTML = "";
    return true;
}

/** Synchronous check of uniqueness of login */
function validUniqLogin() {
    let loginVal = login.value;
    let ajax =
    $.ajax({
        type: 'POST',
        url: root.value + 'user/valid-login',
        data: {login: loginVal},
        dataType: 'json',
        async:false
    });
    a = JSON.parse(ajax.responseText);
    if (a.res) {
        t('NAME_USED', err_log);
    }
    return a.res;
}

/** Verify that the password is correct */
function validPass1() {
    let passVal = password.value;
    if (passVal === "") {
        t('ENTER_PASS', err_pass1);
        return false;
    } else {
        let patt = /^[a-z0-9_-]{6,}$/;
        if (!patt.test(passVal)) {
            t('PASS_TO_EASY', err_pass1);
            return false;
        }
    }
    err_pass1.innerHTML = "";
    return true;
}

/** Checking the correctness of re-entering the password */
function validPass2() {
    let pass1 = password.value;
    let pass2 = password2.value;

    if (pass1 !== "" )
        if (pass1 !== pass2) {
            t('CONFIRM_PASS_MATCH_PASS', err_pass);
            return false;
        }
    err_pass.innerHTML = "";
    return true;
}

/** Checking the correctness of the email input */
function validEmail() {
    let emailVal = email.value;
    let patt = /^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/;

    if (!patt.test(emailVal) && emailVal !== "") {
        t('INVALID_EMAIL', err_email);
        return false;
    }
    err_email.innerHTML = "";
    return true;
}

/** Checking the correctness of entering a full name */
function validSnp() {
    let snpVal = snp.value;
    let pattern1 = /^[а-яёa-z ]+$/i;

    if (snpVal === "") {
        t('FILL_SNP', err_snp);
        return false;
    } else if (!pattern1.test(snpVal) && snpVal !== "") {
        t('CONTAIN_ONLY_LETTERS', err_snp);
        return false;
    }
    err_snp.innerHTML = "";
    return true;
}

/** Full check of the form before sending */
function validForm() {
    let no_error = true;

    if (validUniqLogin()) no_error = false;
    if (!validLogin(1)) no_error = false;
    if (!validPass1()) no_error = false;
    if (!validPass2()) no_error = false;
    if (!validEmail()) no_error = false;
    if (!validSnp()) no_error = false;

    return no_error;
}
