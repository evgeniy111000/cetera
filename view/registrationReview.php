<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet"  href="../style/style.css" />
    <title>Модуль приема отзывов от посетителей сайта</title>
</head>
<body align="center">
<center>
    <?php
        $registrationReviewTitle = '';
        $backLink = '';
        if ($validationFieldsResult){
            $registrationReviewTitle = 'Ваш отзыв успешно добавлен!';
        } else {
            $registrationReviewTitle = '<b><span style="color:red">'
                .'К сожалению, ваш отзыв не добавлен ((</span></b>';
            $backLink = '<h3><b><a href="../index.php">Вернуться к форме с отзывом</a></b></h3>';
        }
    ?>
    <h1><?php echo $registrationReviewTitle; ?></h1>
    <h3>Ваши данные: </h3>
    <h4>
        <p>
            <?php
                echo $labelFio.'<br/>';
                echo $labelEmail.'<br/>';
                echo $labelCategoryReview.'<br/>';
                echo $labelReview.'<br/>';
            ?>
        </p>
    </h4>
    <?php echo $backLink; ?>
</center>
</body>
</html>