<?php
    require_once '../config/config.php';
    require_once '../db/connection.php';
    require_once '../model/functions.php';

    if ($_POST['doReview']){
        $labelFio = 'ФИО: ';
        $labelEmail = 'E-mail: ';
        $labelCategoryReview = 'Категория отзыва: '
            .selectCategoriesReviewsById($_POST['categoryReview']);
        $labelReview = 'Отзыв: ';

        $validationFieldsResult = onValidationFields(
            $_POST, $labelFio, $labelEmail, $labelReview
        );
        require_once '../view/registrationReview.php';
    } else {
        header('Location: ../index.php');
    }
?>
