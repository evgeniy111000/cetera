const FIO_LENGTH = 50;
const EMAIL_LENGTH = 35;
const REVIEW_LENGTH = 100;

var countIncorrectFields = 0;

function onValidate(){
    countIncorrectFields = 0;
    var fio         = document.getElementById('fio');
    var labelFio    = document.getElementById("labelFio");

    var email       = document.getElementById('email');
    var labelEmail  = document.getElementById("labelEmail");

    var review      = document.getElementById('review');
    var labelReview = document.getElementById("labelReview");

    var result = 1;

    result *= fieldValidationFio(fio, labelFio, FIO_LENGTH);
    result *= fieldValidationEmail(email, labelEmail, EMAIL_LENGTH);
    result *= fieldValidationReview(review, labelReview, REVIEW_LENGTH);

    if (result) return true

    return false;
}

function checkField(resultValidation, field, label){
    if (resultValidation == 1) toggleField(false, field, label);
}

function fieldValidationFio(fio, labelFio, fioLength){
    labelFio.innerText = "ФИО:";
    var resultValidationFio = 1;
    resultValidationFio *= validateOnEmpty(resultValidationFio, fio, labelFio);
    resultValidationFio *= validateOnSize(resultValidationFio, fio, labelFio, fioLength);

    resultValidationFio *= validateOfRegularExpression(resultValidationFio, /[^а-яА-Я\s]/,
        fio, labelFio, "Вводить можно только русские буквы");

    checkField(resultValidationFio, fio, labelFio);
    return resultValidationFio;
}

function fieldValidationEmail(email, labelEmail, emailLength){
    labelEmail.innerText = "E-mail:";
    var resultValidationEmail = 1;
    resultValidationEmail *= validateOnEmpty(resultValidationEmail, email, labelEmail);
    resultValidationEmail *= validateOnSize(resultValidationEmail, email, labelEmail, emailLength);

    resultValidationEmail *= validateOnEmail(resultValidationEmail, /[^a-zA-Z0-9.@_-]/, email, labelEmail);

    checkField(resultValidationEmail, email, labelEmail);
    return resultValidationEmail;
}

function fieldValidationReview(review, labelReview, reviewLength){
    labelReview.innerText = "Отзыв:";
    var resultValidationReview = 1;
    resultValidationReview *= validateOnEmpty(resultValidationReview, review, labelReview);
    resultValidationReview *= validateOnSize(resultValidationReview, review, labelReview, reviewLength);

    checkField(resultValidationReview, review, labelReview);
    return resultValidationReview;
}

function validateOnEmpty(resultValidation, field, label){
    if (field.value == '' && resultValidation){
        countIncorrectFields += 1;
        toggleField(true, field, label);
        label.innerText += " Поле пустое";
        return 0;
    }
    return 1;
}

function validateOnSize(resultValidation, field, label, fieldLength){
    if (field.value.length > fieldLength && resultValidation){
        countIncorrectFields += 1;
        toggleField(true, field, label);
        label.innerText += " Размер поля превышает " + fieldLength + " символов";
        return 0;
    }
    return 1;
}

function validateOnEmail(resultValidation, regExp, field, label){
    if ((!((field.value.indexOf('.') > 0) && (field.value.indexOf('@') > 0))
            || regExp.test(field.value)) && resultValidation){
        countIncorrectFields += 1;
        toggleField(true, field, label);
        label.innerText += " Введен некорректный E-mail адрес";
        return 0;
    }
    return 1;
}

function validateOfRegularExpression(resultValidation, regExp, field, label, message){
    if (regExp.test(field.value) && resultValidation){
        countIncorrectFields += 1;
        toggleField(true, field, label);
        label.innerText += " " + message;
        return 0;
    }
    return 1;
}

function toggleField(toggle, field, label){
    if (toggle){
        field.style.border = "1px solid red";
        label.style.color = "red";
        toggleDoReview(true);
    } else {
        field.style.border = "1px solid dodgerblue";
        label.style.color = "black";
    }
    if (!toggle && countIncorrectFields == 0){
        toggleDoReview(false);
    }
}

function toggleDoReview(toggle){
    var doReview = document.getElementById('doReview');
    if (toggle){
        doReview.disabled = true;
        doReview.style.border = "1px solid gray";
        doReview.style.cursor = "default";
    } else {
        doReview.disabled = false;
        doReview.style.border = "1px solid dodgerblue";
        doReview.style.cursor = "pointer";
    }
}




