<?php
    function checkQueryResult($queryResult){
        if (!$queryResult){
            echo 'Ошибка запроса: ' .@mysql_error();
            return 0;
        }
        return 1;
    }

    function insertIdsReviewsCategory($idReviews, $arrayIdsCategories){
        $result = 1;
        for($i = 0; $i < count($arrayIdsCategories); $i++){
            $query = 'INSERT INTO reviews_category SET Id_reviews=\''.$idReviews.'\', ';
            $query .= 'Id_category=\''.$arrayIdsCategories[$i].'\'';
            $result *= @mysql_query($query);
        }
        return $result;
    }

    function makeQueryForSelectCategories($arrayIdsCategories){
        $query = 'SELECT * FROM category WHERE ';
        for($i = 0; $i < count($arrayIdsCategories); $i++){
            $query .= 'ID_category=\''.$arrayIdsCategories[$i].'\'';
            $query .= ' or ';
        }
        $query = @substr($query, 0, strlen($query) - 4);
        return $query;
    }

    function selectCategoriesReviewsById($arrayIdsCategoriesReviews){
        $resultMysqlQuery = @mysql_query(
            makeQueryForSelectCategories($arrayIdsCategoriesReviews)
        );
        checkQueryResult($resultMysqlQuery);
        $result = '';
        while($item = @mysql_fetch_object($resultMysqlQuery)){
            $result .= $item->Category_name;
            $result .= ', ';
        }
        $result = @substr($result, 0, strlen($result) - 2);
        return $result;
    }

    function selectAllCategoryReviews(){
        $resultMysqlQuery = @mysql_query('SELECT * FROM category');
        checkQueryResult($resultMysqlQuery);

        $result = '';
        while($item = @mysql_fetch_object($resultMysqlQuery)){
            $result .= '<option value="'.$item->ID_category.'">'
                .$item->Category_name.'</option>';
        }
        return $result;
    }

    function onValidationFields($post, &$labelFio, &$labelEmail, &$labelReview){
        $resultValidationField = 1;
        $resultValidationField *= fieldValidationFio(
            $post['fio'], $labelFio, FIO_LENGTH
        );
        $resultValidationField *= fieldValidationEmail(
            $post['email'],  $labelEmail, EMAIL_LENGTH
        );
        $resultValidationField *= fieldValidationReview(
            $post['review'], $labelReview, REVIEW_LENGTH
        );

        if ($resultValidationField){
            return insertReview($post);
        }
        return false;
    }

    function fieldValidationFio($fio, &$labelFio, $fioLength){
        $labelFio .= compareFieldValue($fio);
        $resultValidationFio = 1;
        $resultValidationFio *= validateOnEmpty(
            $resultValidationFio, $fio, $labelFio
        );
        $resultValidationFio *= validateOnSize(
            $resultValidationFio, $fio, $labelFio, $fioLength
        );
        $resultValidationFio *= validateOfRegularExpression(
            $resultValidationFio, '/[а-яА-Я]/', $fio, $labelFio,
            'Вводить можно только русские буквы'
        );
        compareFieldLabel($resultValidationFio, $labelFio);
        return $resultValidationFio;
    }

    function fieldValidationEmail($email, &$labelEmail, $emailLength){
        $labelEmail .= compareFieldValue($email);
        $resultValidationEmail = 1;
        $resultValidationEmail *= validateOnEmpty(
            $resultValidationEmail, $email, $labelEmail
        );
        $resultValidationEmail *= validateOnSize(
            $resultValidationEmail, $email, $labelEmail, $emailLength
        );
        $resultValidationEmail *= validateOnEmail(
            $resultValidationEmail, '/([a-zA-Z0-9.@_-]+)/is', $email, $labelEmail
        );
        $resultValidationEmail *= validateOnExistEmail(
            $resultValidationEmail, $email, $labelEmail
        );
        compareFieldLabel($resultValidationEmail, $labelEmail);

        return $resultValidationEmail;
    }

    function fieldValidationReview($review, &$labelReview, $reviewLength){
        $labelReview .=  compareFieldValue($review);
        $resultValidationReview = 1;
        $resultValidationReview *= validateOnEmpty(
            $resultValidationReview, $review, $labelReview
        );
        $resultValidationReview *= validateOnSize(
            $resultValidationReview, $review, $labelReview, $reviewLength
        );
        compareFieldLabel($resultValidationReview, $labelReview);

        return $resultValidationReview;
    }

    function compareFieldLabel($resultValidation, &$fieldLabel){
        if (!$resultValidation){
            $fieldLabel = '<span style=\'color: red\'>'.$fieldLabel.'</span>';
        }
    }

    function compareFieldValue($fieldValue){
        return @htmlspecialchars(trim($fieldValue));

    }

    function validateOnEmail($resultValidation, $regularExpression,
                             $fieldValue, &$fieldLabel){
        if ((!((strpos($fieldValue, '.') > 0) && (strpos($fieldValue, '@') > 0))
            || !preg_match($regularExpression, $fieldValue)) && $resultValidation){
            $fieldLabel .= ' <br><b>Введен некорректный E-mail адрес</b>';
            return 0;
        }
        return 1;
    }

    function validateOnExistEmail($resultValidation, $email, &$labelEmail){
        $querySelectEmail = 'SELECT Email FROM reviews WHERE Email=\''.$email.'\'';
        $resultQuery = @mysql_query($querySelectEmail);
        if (!checkQueryResult($resultQuery) && $resultValidation) {
            $labelEmail .= ' <br><b>Ошибка проверки E-mail адреса</b>';
            return 0;
        }
        $object = @mysql_fetch_object($resultQuery);
        if (!empty($object) && $resultValidation){
            $labelEmail .= ' <br><b>Введенный E-mail адрес уже существует в базе данных</b>';
            return 0;
        }
        return 1;
    }

    function validateOfRegularExpression($resultValidation, $regularExpression,
                                         $fieldValue, &$fieldLabel, $message){
        if (!preg_match($regularExpression, $fieldValue) && $resultValidation){
            $fieldLabel .= ' <br><b>('.$message.')</b>';
            return 0;
        }
        return 1;
    }

    function validateOnSize($resultValidation, $fieldValue, &$fieldLabel, $fieldSize){
        if (strlen($fieldValue) > $fieldSize && $resultValidation){
            $fieldLabel .= ' <br><b>(Размер поля превышает '.$fieldSize.' символов)</b>';
            return 0;
        }
        return 1;
    }

    function validateOnEmpty($resultValidation, $fieldValue, &$fieldLabel){
        if ($fieldValue == '' && $resultValidation == 1){
            $fieldLabel .= ' <b>(Поле пустое)</b>';
            return 0;
        }
        return 1;
    }

    function selectIdReviews($email){
        $query = 'SELECT ID_reviews FROM reviews WHERE Email=\''.$email.'\'';
        $queryResult = @mysql_query($query);

        checkQueryResult($queryResult);
        $objectResult = @mysql_fetch_object($queryResult);

        return $objectResult->ID_reviews;
    }

    function insertReview($post){
        $query = 'INSERT INTO reviews SET '
            .'Fio=\''.$post['fio'].'\', Email=\''.$post['email'].'\', '
            .'Review=\''.$post['review'].'\'';
        $resultQueryInsertReview = @mysql_query($query);
        checkQueryResult($resultQueryInsertReview);

        $idReviews = selectIdReviews($post['email']);
        $resultQueryInsertIds = insertIdsReviewsCategory($idReviews, $post['categoryReview']);
        checkQueryResult($resultQueryInsertIds);

        if ($resultQueryInsertReview && $resultQueryInsertIds) return true;

        return false;
    }
?>