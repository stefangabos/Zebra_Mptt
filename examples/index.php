<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

    <head>

        <title>Zebra_Mptt example</title>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8">

        <meta http-equiv="Content-Script-Type" content="text/javascript">

        <meta http-equiv="Content-Style-Type" content="text/css">

    </head>

    <body>

        <h2>Zebra_Mptt, database example</h2>

        <p>For this example, you need to first import the <strong>mptt.sql</strong> file from the <strong>install</strong>
        folder and to edit the <strong>example.php file and change your database connection related settings.</strong></p>

        <?php

        // database connection details
        $MySQL_host     = '';
        $MySQL_username = '';
        $MySQL_password = '';
        $MySQL_database = '';

        // if could not connect to database
        if (!($connection = @mysql_connect($MySQL_host, $MySQL_username, $MySQL_password))) {

            // stop execution and display error message
            die('Error connecting to the database!<br>Make sure you have specified correct values for host, username and password.');

        }

        // if database could not be selected
        if (!@mysql_select_db($MySQL_database, $connection)) {

            // stop execution and display error message
            die('Error selecting database!<br>Make sure you have specified an existing and accessible database.');

        }

        // first, clear everything in the database
        mysql_query('TRUNCATE TABLE mptt');

        // include the Zebra_Mptt class
        require '../Zebra_Mptt.php';

        // instantiate the Zebra_Mptt object
        $mptt = new Zebra_Mptt();

        // populate the table

        // add 'Food' as a topmost node
        $food = $mptt->add(0, 'Food');

        // 'Fruit' and 'Meat' are direct descendants of 'Food'
        $fruit = $mptt->add($food, 'Fruit');
        $meat = $mptt->add($food, 'Meat');

        // 'Red' and 'Yellow' are direct descendants of 'Fruit'
        $red = $mptt->add($fruit, 'Red');
        $yellow = $mptt->add($fruit, 'Yellow');

        // add a fruit of each color
        $mptt->add($red, 'Cherry');
        $mptt->add($yellow, 'Banana');

        // add two kinds of meat
        $mptt->add($meat, 'Beef');
        $mptt->add($meat, 'Pork');

        // get children of 'Red'
        print_r('<p>Children of "Red"');
        print_r('<pre>');
        print_r($mptt->get_children($red));
        print_r('</pre>');

        // get children of 'Meat'
        print_r('<p>Children of "Meat"');
        print_r('<pre>');
        print_r($mptt->get_children($meat));
        print_r('</pre>');

        // data in the database as a multidimensional array
        print_r('<p>The entire tree');
        print_r('<pre>');
        print_r($mptt->get_tree());
        print_r('</pre>');

        ?>

    </body>

</html>
