<?php
  require_once('./config/db.php');
  require_once('./classes/bbs.php');

  $bbs = new Bbs();
  $results = array();
  if ($_SERVER['REQUEST_METHOD'] === 'POST')
  {
    $event = $_POST['event'];
    switch ($event)
    {
      case 'create':
      $results = $bbs -> savePost($_POST);
      break;

      case 'delete':
      $results = $bbs -> deletePost($_POST);
      break;

      default:
      break;
    }
  }

  $getResults = $bbs -> getPosts();

  // $text = new Bbs();
  // $text-> setMessage('こんにちは');
  //
  // echo $text -> getMessage();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>22ch</title>
</head>
<body>
  <h1>22ch</h1>
  <?php if (count($results) > 0) { ?>
  <ul>
    <?php foreach ($results as $result) { ?>
      <li>
        <?php echo $result; ?>
      </li>
    <?php } ?>
  </ul>
<?php } ?>
  <form action="index.php" method="post">
    <dl>
      <dt><label for="name">名前：</label></dt>
      <dd><input type="text" name="name" id="name"></dd>
      <dt><label for="comment">ひとこと：</label></dt>
      <dd><textarea name="comment" id="comment"></textarea></dd>
    </dl>
    <input type="hidden" name="event" value="create">
    <input type="submit" name="submit" value="送信">
  </form>
  <ul>
  <?php foreach ($getResults as $value) { ?>
    <li>
      <?php echo $value['name']; ?>
      <?php echo $value['comment']; ?>
      - <?php echo $value['created_at']; ?>
    </li>
    <form action="index.php" method="post">
      <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
      <input type="hidden" name="event" value="delete">
      <input type="submit" name="delete" value="削除">
    </form>
  <?php } ?>
</ul>
</body>
</html>
