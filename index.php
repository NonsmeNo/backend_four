<?php
header('Content-Type: text/html; charset=UTF-8'); //кодировка для браузера

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  
  $messages = array(); //Массив для временного хранения сообщений пользователю

  //Выдаем сообщение об успешном сохранении
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);//удаление

    $messages[] = '<div class="saves">Спасибо, результаты сохранены!</div>';
  }

  // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['agree'] = !empty($_COOKIE['agree']);
  $errors['ability'] = !empty($_COOKIE['ability_error']);

  
  // Выдаем сообщения об ошибках.
  if ($errors['name']) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('name_error', '', 100000);
    // Выводим сообщение.
    $messages[] = '<div class="error">Введите имя</div>';
  }
  
  if ($errors['email']) {
    setcookie('email_error', '', 100000);

    $messages[] = '<div class="error">Введите E-mail</div>';
  }

  if ($errors['biography']) {
    setcookie('biography_error', '', 100000);

    $messages[] = '<div class="error">Добавьте вашу биографию</div>';
  }

  if ($errors['gender']) {
    setcookie('gender_error', '', 100000);

    $messages[] = '<div class="error">Выберите пол</div>';
  }

  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100000);

    $messages[] = '<div class="error">Выберите число конечностей</div>';
  }

  if ($errors['agree']) {
    setcookie('agree_error', '', 100000);

    $messages[] = '<div class="error">Вы не ознакомились с контрактом</div>';
  }

  if ($errors['ability']) {
    setcookie('ability_error', '', 100000);

    $messages[] = '<div class="error">Выберите сверхспособности</div>';
  }


  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();

  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];
  $values['ability'] = empty($_COOKIE['ability_value']) ? '' : ($_COOKIE['ability_value']);

  // Включаем содержимое файла form.php.
  // В нем будут доступны переменные $messages, $errors и $values для вывода 
  // сообщений, полей с ранее заполненными данными и признаками ошибок.
  include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name'])) {
    // Выдаем куку на день с флажком об ошибке в поле name.
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  // Сохраняем ранее введенное в форму значение на месяц.
  else {
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }

  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }



  if (empty($_POST['biography'])) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  }



  if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }



  if (empty($_POST['limbs'])) {
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
  }




  if (empty($_POST['agree'])) {
    setcookie('agree_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('agree_value', $_POST['agree'], time() + 30 * 24 * 60 * 60);
  }


  

  if (empty($_POST['ability'])) {
    setcookie('ability_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    setcookie('ability_value', $_POST['ability'], time() + 30 * 24 * 60 * 60);
  }

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('agree_error', '', 100000);
    setcookie('ability_error', '', 100000);
  }


  /*
  $date1="2004-01-01";
  $date=$_POST['birth'];

  if ($date>=$date1)
  {
    print('Выбрана некорректная дата &#128559;<br>');
    exit();
  }*/


   //-------------------------------Сохранение в базу данных.----------------------
  $db = new PDO('mysql:host=localhost;dbname=u52945', 'u52945', '3219665',
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

  try {
    $stmt = $db->prepare("INSERT INTO application (name, email, biography, gender, limbs, birth) 
    VALUES (:name, :email, :biography, :gender, :limbs, :birth)");
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':biography', $_POST['biography']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':limbs', $_POST['limbs']);
    $stmt->bindParam(':birth', $_POST['birth']);
    $stmt->execute();
    $application_id = $db->lastInsertId();

    foreach ($_POST['ability'] as $ability)
    {
      $stmt = $db->prepare("INSERT INTO application_ability (application_id, ability_id)
      VALUES (:application_id, (SELECT id FROM ability WHERE name=:ability_name))");
      $stmt->bindParam(':application_id', $application_id);
      $stmt->bindParam(':ability_name', $ability);
      $stmt->execute();
    }   

  }

  catch(PDOException $e) {
    print('ошибка при отправке данных: ' .$e->getMessage());
    exit();
  }

  //--------------------------------------------------------------------------

  // Сохраняем куку с признаком успешного сохранения.
  setcookie('save', '1');

  // Делаем перенаправление.
  header('Location: index.php');

}