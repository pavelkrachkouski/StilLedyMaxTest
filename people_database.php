<?php

class PeopleDatabase
{

    private $id;
    private $name;
    private $surname;
    private $dateofbirth;
    private $gender;
    private $cityofbirth;



    /**
     * Конструктор класса либо создает человека в БД с заданной информацией, либо берет информацию из БД по id (предусмотреть валидацию данных)
     */
    function __construct($name, $surname, $dateofbirth, $gender, $cityofbirth, $id = 0)
    {
        if ($id == 0) {
            echo 'Добавляем в базу. ';
            $this->id = $id;
            $this->name = $name;
            $this->surname = $surname;
            $this->dateofbirth = $dateofbirth;
            $this->gender = $gender;
            $this->cityofbirth = $cityofbirth;
            $this->savePeople();
        } else {
            $this->selectPeople($id);
        }
    }

    

    /**
     * Информация об экземляре класса
     */
    public function displayInfo()
    {
        echo "<br>id: $this->id;<br>";
        echo "Name: $this->name;<br>";
        echo "Surname: $this->surname;<br>";
        echo "Date of birth: $this->dateofbirth (" . self::getAge($this) . " лет);<br>";
        echo "Gender: $this->gender (" . self::getGender($this) . ");<br>";
        echo " City of birth: $this->cityofbirth.<br>";
        echo "<a href='?id=$this->id'>Удалить</a><br>";
        echo "<hr>";
    }



    /**
     * Сохранение полей экземпляра класса в БД
     */
    private function savePeople()
    {
        $conn = mysqli_connect('localhost', 'root', '', 'people');
        if ($conn === false) {
          die('Ошибка: ' . mysqli_connect_error());
        } 
        //echo 'Подключение успешно установлено. ';

        $sql = "INSERT INTO people (name, surname, dateofbirth, gender, cityofbirth) VALUES ('$this->name', '$this->surname', '$this->dateofbirth', $this->gender, '$this->cityofbirth')";
       
        if ($conn->query($sql)) {
            //echo 'Данные успешно добавлены.';
        } else {
            echo 'Ошибка: ' . $conn->error;
        }
        $conn->close();
    }



    /**
     * Берем информацию из БД по id
     */
    private function selectPeople($id)
    {
        $conn = mysqli_connect('localhost', 'root', '', 'people');
        if ($conn === false) {
          die('Ошибка: ' . mysqli_connect_error());
        } 
        //echo 'Подключение успешно установлено.';

        $sql = "SELECT * FROM people WHERE id = '$id'";

        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                foreach ($result as $row) {
                    $this->id = $row['id'];
                    $this->name = $row['name'];
                    $this->surname = $row['surname'];
                    $this->dateofbirth = $row['dateofbirth'];
                    $this->gender = $row['gender'];
                    $this->cityofbirth = $row['cityofbirth'];
                }
            } else {
                //echo 'Пользователь не найден.';
            }
            $result->free();
        } else{
            echo 'Ошибка: ' . $conn->error;
        }
        $conn->close();
    }

    

    /**
     * Удаление человека из БД в соответствии с id объекта
     */
    public function deletePeople($id)
    {
        $conn = mysqli_connect('localhost', 'root', '', 'people');
        if ($conn === false) {
          die('Ошибка: ' . mysqli_connect_error());
        } 
        //echo 'Подключение успешно установлено. ';

        $sql = "DELETE FROM people WHERE id = '$id'";

        if ($conn->query($sql)) {
            //echo 'Запись успешно удалена.';
        } else {
            echo 'Ошибка: ' . $conn->error;
        }
        $conn->close();  
    }



    /**
     * static преобразование даты рождения в возраст (полных лет)
     */
    public static function getAge($people)
    {
        $birthday_timestamp = strtotime($people->dateofbirth);
        $age = date('Y') - date('Y', $birthday_timestamp);
        if (date('md', $birthday_timestamp) > date('md')) {
          $age--;
        }
        return $age;
    }



    /**
     * static преобразование пола из двоичной системы в текстовую (муж, жен)
     */
    public static function getGender($people)
    {
        if ($people->gender == 1) {
            return 'муж';
        } else {
            return 'жен';
        }
    }

}

/* Форматирование человека с преобразованием возраста и (или) пола (п.3 и п.4) в зависимотси от параметров (возвращает новый экземпляр StdClass со всеми полями изначального класса). */