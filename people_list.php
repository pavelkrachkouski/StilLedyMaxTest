<?php

require_once 'people_database.php';
if (class_exists('PeopleDatabase')) {
    echo 'Все классы найдены...OK<br>';
} else {
    echo 'Класс для работы с базой данных людей не найден!';
    exit;
}

class PeopleList
{

    private $array = [];



    function __construct($array = [])
    {
        $this->getPeopleId();
    }



    private function getPeopleId()
    {
        $conn = mysqli_connect('localhost', 'root', '', 'people');
        if ($conn === false) {
          die('Ошибка: ' . mysqli_connect_error());
        } 
        //echo 'Подключение успешно установлено. ';

        $sql = "SELECT * FROM people";

        if ($result = $conn->query($sql)) {
            foreach ($result as $row) {
                array_push($this->array,  $row['id']);
            }
            $result->free();
        } else {
            echo "Ошибка: " . $conn->error;
        }
        $conn->close();
    }



    public function getArrayObjects()
    {
        $arrayObject = [];
        foreach ($this->array as $value) {
            array_push($arrayObject,   new PeopleDatabase('', '', '', 0, '', $value));
        }
        return $arrayObject;
    }

}






