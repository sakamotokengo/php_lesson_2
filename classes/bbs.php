<?php

class Bbs
{
  public $pdo;

  public function __construct()
  {
      try
      {
          $this -> pdo = new PDO( PDO_DSN, DATABASE_USER, DATABASE_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
      }
      catch (PDOException $e)
      {
          echo 'error' . $e->getMessage();
          die();
      }
    }

  public function savePost($data)
  {
    $errors = $this ->_validation($data);
    if(!empty($errors)) return $errors;

    $results = array();
    $smt = $this -> pdo -> prepare('insert into post (name,comment,created_at) values(:name,:comment,now())');
    $smt -> bindParam(':name',$data['name'], PDO::PARAM_STR);
    $smt -> bindParam(':comment',$data['comment'], PDO::PARAM_STR);
    $smt -> execute();

    $result['success'] = 'ひとことを投稿しました';
    return $result;
  }

  public function getPosts()
  {
    $smt = $this -> pdo -> prepare('select * from post order by created_at DESC limit 50');
    $smt -> execute();
    $result = $smt -> fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  public function deletePost($data)
  {
    $result = array();
    $smt = $this -> pdo -> prepare('delete from post where id = :id');
    $smt -> bindParam(':id', $data['id'],PDO::PARAM_INT);
    $smt -> execute();

    $result['success'] = 'ひとことを入力しました';
    return $result;
  }

  private function _validation($data)
  {
    $errors = array ();

    if (mb_strlen($data['name']) > 10)
    {
      $errors['name'] = '名前は10文字以内で入力してください';
    }
    if (empty($data['comment']))
    {
      $errors['comment'] = 'ひとことを入力してください';
    }
    else if(mb_strlen($data['comment']) > 20)
    {
      $errors['comment'] = 'ひとことは20文字以内で入力して下い';
    }
    return $errors;
  }

}
