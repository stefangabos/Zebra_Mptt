<!doctype html>
<html>

    <head>
        <title>Zebra_Mptt example</title>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    </head>

    <body>

        <h2>Zebra_Mptt, database example</h2>

        <p>For this example, you need to first import the <strong>mptt.sql</strong> file from the <strong>install</strong>
        folder and to edit the <strong>example.php file and change your database connection related settings.</strong></p>

        <?php

        // database connection details
        $mysql_host     = '';
        $mysql_username = '';
        $mysql_password = '';
        $mysql_database = '';

        // if could not connect to database
        ($connection = @mysqli_connect($mysql_host, $mysql_username, $mysql_password)) or

            // stop execution and display error message
            die('Error connecting to the database!<br>Make sure you have specified correct values for host, username and password.');

        // if database could not be selected
        @mysqli_select_db($connection, $mysql_database) or

            // stop execution and display error message
            die('Error selecting database!<br>Make sure you have specified an existing and accessible database.');

        // first, clear everything in the database
        mysqli_query($connection, 'TRUNCATE TABLE mptt');

        // include the Zebra_Mptt class
        require '../Zebra_Mptt.php';

        // instantiate the Zebra_Mptt object
        $mptt = new Zebra_Mptt($connection);

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
        $cherry = $mptt->add($red, 'Cherry');
        $banana = $mptt->add($yellow, 'Banana');

        // add a color, but in the wrong position
        $orange = $mptt->add($banana, 'Orange');

        // now move it to fruits, after the "red" node
        $orange = $mptt->move($orange, $red, 'after');

        // add two kinds of meat
        $meat = $mptt->add($meat, 'Beef');
        $pork = $mptt->add($meat, 'Pork');

        // get descendants of 'Red'
        print_r('<p>Descendants of "Red"');
        print_r('<pre>');
        print_r($mptt->get_descendants($red, false));
        print_r('</pre>');

        // get descendants of 'Meat'
        print_r('<p>Descendants of "Meat"');
        print_r('<pre>');
        print_r($mptt->get_descendants($meat, false));
        print_r('</pre>');

        // data in the database as a multidimensional array
        print_r('<p>The entire tree');
        print_r('<pre>');
        print_r($mptt->get_tree());
        print_r('</pre>');

        ?>

    </body>
</html>
