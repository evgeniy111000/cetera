<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet"  href="style/style.css" />
    <script src="js/script.js"></script>
    <title>Модуль приема отзывов от посетителей сайта</title>
</head>
<?php
    require_once 'db/connection.php';
    require_once 'model/functions.php';
?>
<body align="center">
<center>
    <form action="controller/controller.php" name="form"
          onsubmit="return onValidate()" id="form" method="post">
        <fieldset>
            <legend id="formLegend"><h2>Модуль приема отзывов от посетителей сайта</h2></legend>
            <p>
                <label for="fio" id="labelFio">ФИО: </label>
                <input type="text" size="30" name="fio"
                       title="Пожалуйста, введите в данное поле свою Фамилию, Имя
                       и Отчество русскими буквами. Ограничение поля: 50 символов."
                       id="fio" value="" onchange="onValidate()"/>
            </p>
            <p>
                <label for="email" id="labelEmail">E-mail: </label>
                <input type="email" size="30"
                       title="Пожалуйста, введите в данное поле свой E-mail адрес.
                       Ограничение поля: 35 символов. Вводить нужно корректный E-mail адрес."
                       name="email" id="email" value="" onchange="onValidate()"/>
            </p>
            <p>
                <label for="categoryReview" id="labelCategoryReview">Категория отзыва: </label>
                <select id="categoryReview" name="categoryReview[]" size="2" multiple="true" required="true">
                    <?php echo selectAllCategoryReviews(); ?>
                </select>
            </p>
            <p>
                <label for="review" id="labelReview">Отзыв: </label>
                <textarea name="review" id="review"
                          title="Пожалуйста, введите в данное поле свой отзыв.
                          Ограничение поля: 100 символов."
                          onchange="onValidate()"></textarea>
            </p>
            <p>
                <input type="submit" name="doReview" id="doReview" value="Отправить"/>
            </p>
        </fieldset>
    </form>
</center>
</body>
</html>