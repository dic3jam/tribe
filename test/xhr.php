<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Jim DiCesare">
        <link rel="stylesheet" href="../css/main.css">
        <title>TRIBE</title>
        <link rel="shortcut icon" type="image/ico" href="../images/boilerplatefavicon.ico">
    </head>
    <body>
  <?php
    class user {
      public $messageBoardID;
      function  __construct() {
        $this->messageBoardID = 1;
      }
    }
    $user = new user();
    ?>
  <script>var exports = {};</script>
  <script src='../js/messageboard.js'></script>
  <script>
    var xhr = new XMLHttpRequest();
    var url = "../src/get_messages.php?messageBoardID=<?php echo $user->messageBoardID?>";
    if(document.readyState !== 'loading') {
      console.log("ready state up");
      xhrOpen(xhr, url);
    } else { 
      document.addEventListener('DOMContentLoaded', (event) => {
        console.log("domcontentloaded");
        xhrOpen(xhr, url);
      });
    }
    xhr.onreadystatechange = () => {
      if (xhr.readyState == 4) {
        console.log("ready state 4!");
        let new_messages = JSON.parse(xhr.response);
        addPost(new_messages, 0, document.getElementById('mb'));
      }
    }; 
  </script>
  <h1 >UP!</h1>
  <div id='mb'></div>

</body>
</html>

