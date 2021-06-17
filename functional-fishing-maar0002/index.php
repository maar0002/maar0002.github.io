<?php include 'functional-fishing.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Functional Fishing with PHP</title>
  <link rel="stylesheet" href="functional-fishing.css">
</head>

<body>
  <h1>Functional Fishing</h1>
  <div id="response" class="response">
    <?php if (isset($_SESSION['functional_fishing']['response'])) : ?>
      <?php echo getResponse(); ?>
    <?php else : ?>
      <?php echo updateResponse(help()); ?>
    <?php endif; ?>
  </div>
  <form method = "POST">
    <input type="text" name="command" class="command" autofocus>
  </form>
  <a class="clear" href="?clear">Clear Session</a>
  <script src="functional-fishing.js"></script>
</body>

</html>