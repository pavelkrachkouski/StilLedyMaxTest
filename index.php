<?php
	require_once 'people_list.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
</head>
<body>

<hr>
<form action='?add=true' method='post'>
    <input type='text' name='name' placeholder='Имя' value='' />
    <input type='text' name='surname' placeholder='Фамилия' value='' />
    <input type='text' name='dateofbirth' placeholder='Дата рождения' value='' />
    <input type='text' name='gender' placeholder='Пол' value='' />
    <input type='text' name='cityofbirth' placeholder='Город рождения' value='' />
    <input type='submit' value='Добавить человека в базу'>
</form>
<hr>

<?php

    $a = new PeopleList();
    $array = $a->getArrayObjects();

    /**
     * Добавляем запись, если нужно.
     */
    if (isset($_GET['add'])) {
        new PeopleDatabase($_POST['name'], $_POST['surname'], $_POST['dateofbirth'], $_POST['gender'], $_POST['cityofbirth']);
        header("Location: index.php");
    }

    /**
     * Удаляем запись, если нужно.
     */
    if (isset($_GET['id'])) {
        $people = new PeopleDatabase('', '','', '','', $_GET['id']);
        $people->deletePeople($_GET['id']);
        header("Location: index.php");
    }

    /**
     * Выводим все записи
     */
    foreach ($array as $val) {
        $val->displayInfo();
    }

?>
 
</body>
</html>