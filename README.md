##Zebra_Mptt

####A PHP library providing an implementation of the modified preorder tree traversal algorithm

MPTT is a fast algorithm for storing hierarchical data (like categories and their subcategories) in a relational database. This is a problem that most of us have had to deal with, and for which we’ve used an adjacency list, where each item in the table contains a pointer to its parent and where performance will naturally degrade with each level added as more queries need to be run in order to fetch a subtree of records.

The aim of the modified preorder tree traversal algorithm is to make retrieval operations very efficient. With it you can fetch an arbitrary subtree from the database using just two queries. The first one is for fetching details for the root node of the subtree, while the second one is for fetching all the children and grandchildren of the root node.

The tradeoff for this efficiency is that updating, deleting and inserting records is more expensive, as there’s some extra work required to keep the tree structure in a good state at all times. Also, the modified preorder tree traversal approach is less intuitive than the adjacency list approach because of its algorithmic flavour.

For more information about the modified preorder tree traversal method, read this excellent article called Storing Hierarchical Data in a Database Article.

**What is Zebra_Mptt?**

Zebra_Mptt is a PHP library that provides an implementation of the modified preorder tree traversal algorithm making it easy to implement the MPTT algorithm in your PHP applications.

It provides methods for adding nodes anywhere in the tree, deleting nodes, moving and copying nodes around the tree and methods for retrieving various information about the nodes.

Zebra\_Mptt uses table locks making sure that database integrity is always preserved and that concurrent MySQL sessions don’t compromise data integrity. Also, Zebra_Mptt uses a caching mechanism which has as result the fact that regardless of the type, or the number of retrieval operations, the database is read only once per script execution!

##Features

- provides methods for adding nodes anywhere in the tree, deleting nodes, moving and copying nodes around the tree and methods for retrieving various information about the nodes
- uses a caching mechanism which has as result the fact that regardless of the type, or the number of retrieval operations, the database is read only once per script execution
- uses table locks making sure that database integrity is always preserved and that concurrent MySQL sessions don’t compromise data integrity
- has comprehensive documentation
- code is heavily commented and generates no warnings/errors/notices when PHP’s error reporting level is set to E_ALL

## Requirements

PHP 4.4.9+, MySQL 4.1.22+

## How to use

```php
<?php

// include the Zebra_Mptt class
require 'path/to/Zebra_Mptt.php';

// instantiate a new object
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

// move 'Banana' to 'Meat'
$mptt->move($banana, $meat);

// get a flat array of descendants of 'Meat'
$mptt->get_children($meat);

// get a multidimensional array (a tree) of all the data in the database
$mptt->get_tree();

?>
```

Visit the **[project's homepage](http://stefangabos.ro/php-libraries/zebra-mptt/)** for more information.