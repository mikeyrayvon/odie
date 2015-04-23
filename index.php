<!--
  Odie
  mexico city 2015
  https://github.com/mikeyrayvon/odie
-->
<?php
  $url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
  $query = (parse_url($url, PHP_URL_QUERY));
  parse_str($query);

  if ($u) {

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);
    if(! $conn )
    {
      die('Could not connect: ' . mysql_error());
    }
    $table = 'users';
    $sql = "SELECT url, title, description FROM $table WHERE username = '$u'";

    mysql_select_db('odie');
    $retval = mysql_query( $sql, $conn );
    if(! $retval )
    {
      die('Could not get data: ' . mysql_error());
    }
    while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
    {
        $publishedDocUrl = $row['url'];
        $title = $row['title'];
        $description = $row['description'];
    } 
    mysql_close($conn);

    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $publishedDocUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $html = curl_exec($ch);
    curl_close($ch);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $dom->preserveWhiteSpace = false;
    $dom->validateOnParse = true;
    $contents = $dom->saveHTML($dom->getElementById('contents'));

  } else {
    $title = 'Odie';
    $description = 'gdocs-cms network';
  }
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
    <style type="text/css"> 
    html, body {margin: 0; padding: 0; width: 100%;height: 100%;} 
    #contents {width: 1100px;margin: 50px auto;} 
    section {width: 49%; display: inline-block; vertical-align: top}
    h1 {font-size: 2em} input {width: 300px;} img {max-width: 100%} 
    @media screen and (max-width: 1000px) { #contents {width: 90%;margin: 5% auto;} } 
    @media screen and (max-width: 700px) { section {width: 100%;} input {width: 100%;} span, img, iframe { max-width: 100% !important;width: auto !important;height: auto !important;}} 
    </style>
  </head>
  <body>
    <?php if ($contents) { echo $contents; } else { ?>
    <div id="contents" class='center'>
      <h1>Odie</h1>
      <section>
        <pre><code>
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
        </code></pre>
        <form action="insert.php" method="post" id='new-user'>
          <p><input type="text" name="username" id="username" placeholder="username"></p>
          <p><input type="text" name="url" id="url" placeholder="gdocs url"></p>
          <p><input type="text" name="title" id="title" placeholder="title"></p>
          <p><input type="text" name="description" id="description" placeholder="description"></p>
          <input type="submit" value="XD">
        </form>
        <div id="response"></div>
      </section>
      <section>
      </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">
        var insertPHP = $('form').attr('action');
        $('form').on('submit', function() {
          var username = $('input#username').val(),
          url = $('input#url').val(),
          title = $('input#title').val(),
          description = $('input#description').val(),
          dataString = 'username='+ username + '&url=' + url + '&title=' + title + '&description=' + description;
          $.ajax({
            type: "POST",
            url: insertPHP,
            data: dataString,
            success: function(response) {
              var accountUrl = window.location.href + '?u=' + username
              $('#response').html(response + '<br><a href="' + accountUrl + '">' + accountUrl + '</a>');
            }
          });
          return false;
        });
    </script>
  <?php } ?>
  </body>
</html>