<!--
  Odie
  mexico city 2015
  https://github.com/mikeyrayvon/odie
-->
<?php

  $title = 'Odie';
  $description = 'gdocs-cms network';

  $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
  $query = (parse_url($url, PHP_URL_QUERY));
  parse_str($query);

  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = 'root';
  $conn = mysqli_connect($dbhost, $dbuser, $dbpass, 'odie');
  if(! $conn ) { die('Could not connect: ' . mysqli_error()); }

  $table = 'users';

  global $u;
  global $conn;
  global $table;

  if ($u) {    
    // GET ODIE
    include('partials/get.php');
  }

  // RANDOM ODIE
  include('partials/rand.php');

  // ODIE OF THE DAY
  include('partials/daily.php');

  mysqli_close($conn); 
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:description" content="<?php echo $description; ?>" />
    <meta property="og:type" content="website" />
    <link rel='stylesheet' href='css/site.min.css' type='text/css' media='all' />
  </head>
  <body>
    <?php echo $random_output; ?>
    <?php if ($contents) { echo $contents; } else { ?>
    <div id="contents">
      <?php if ($error) { echo $error; } ?>
      <h1>Odie</h1>
      <section>
        
        <pre>
        _.._   _..---.
     .-"    ;-"       \
    /      /           |
   |      |       _=   |
   ;   _.-'\__.-')     |
    `-'      |   |    ;
             |  /;   /      _,
           .-.;.-=-./-""-.-` _`
          /   |     \     \-` `,
         |    |      |     |
         |____|______|     |
          \0 / \0   /      /
       .--.-""-.`--'     .'
      (#   )          ,  \
      ('--'          /\`  \
       \       ,,  .'      \
        `-._    _.'\        \
            `""`    \        \
        </pre>
      </section>
      <section class="u-border">
        <h2>Make a new Odie</h2>
        <p>
          Your username is for the Odie subdomain, like username.odie.us
        </p>
        <p>
          Open your google doc and File > Publish to the web. The link in that dialog is your published doc url
        </p>
        <form action="partials/insert.php" method="post" id='new-user'>
          <p><input type="text" name="username" id="username" placeholder="username"></p>
          <p><input type="text" name="url" id="url" placeholder="published doc url"></p>
          <p><input type="text" name="title" id="title" placeholder="title"></p>
          <p><input type="text" name="description" id="description" placeholder="description"></p>
          <button type="submit">Odie!</button>
        </form>
        <div id="response"></div>
      </section>
      <section>
        <h2>What is Odie?</h2>
        <p>
          Odie makes a webpage with the content of a published google doc and gives it an Odie subdomain
        </p>
        <hr>
        <h2>Odie of the Day</h2>
        <p>
          <?php echo $daily_output; ?>
        </p>
      </section>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.min.js"></script>
  <?php } ?>
  </body>
</html>