<img src="https://github.com/stefangabos/zebrajs/blob/master/docs/images/logo.png" alt="zebrajs" align="right">

# Zebra Mptt &nbsp;[![Tweet](https://img.shields.io/twitter/url/http/shields.io.svg?style=social)](https://twitter.com/intent/tweet?text=A+PHP+library+providing+an+implementation+of+the+modified+preorder+tree+traversal+(MPTT)+algorithm&url=https://github.com/stefangabos/Zebra_Mptt&via=stefangabos&hashtags=php,mptt)

*A PHP library providing an implementation of the modified preorder tree traversal (MPTT) algorithm*

[![Latest Stable Version](https://poser.pugx.org/stefangabos/zebra_mptt/v/stable)](https://packagist.org/packages/stefangabos/zebra_mptt) [![Total Downloads](https://poser.pugx.org/stefangabos/zebra_mptt/downloads)](https://packagist.org/packages/stefangabos/zebra_mptt) [![Monthly Downloads](https://poser.pugx.org/stefangabos/zebra_mptt/d/monthly)](https://packagist.org/packages/stefangabos/zebra_mptt) [![Daily Downloads](https://poser.pugx.org/stefangabos/zebra_mptt/d/daily)](https://packagist.org/packages/stefangabos/zebra_mptt) [![License](https://poser.pugx.org/stefangabos/zebra_mptt/license)](https://packagist.org/packages/stefangabos/zebra_mptt)

## What is Modified Preorder Tree Traversal

MPTT is a fast algorithm for storing hierarchical data (like categories and their subcategories) in a relational database. This is a problem that most of us have had to deal with, and for which we've used an [adjacency list](http://mikehillyer.com/articles/managing-hierarchical-data-in-mysql/), where each item in the table contains a pointer to its parent and where performance will naturally degrade with each level added as more queries need to be run in order to fetch a subtree of records.

The aim of the modified preorder tree traversal algorithm is to make retrieval operations very efficient. With it you can fetch an arbitrary subtree from the database using just two queries. The first one is for fetching details for the root node of the subtree, while the second one is for fetching all the children and grandchildren of the root node.

The tradeoff for this efficiency is that updating, deleting and inserting records is more expensive, as there's some extra work required to keep the tree structure in a good state at all times. Also, the modified preorder tree traversal approach is less intuitive than the adjacency list approach because of its algorithmic flavour.

For more information about the modified preorder tree traversal method, read this excellent article called [Storing Hierarchical Data in a Database](https://www.sitepoint.com/hierarchical-data-database/).

## What is Zebra Mptt

**Zebra Mptt** is a PHP library that provides an implementation of the modified preorder tree traversal algorithm making it easy to implement the MPTT algorithm in your PHP applications.

It provides methods for adding nodes anywhere in the tree, deleting nodes, moving and copying nodes around the tree and methods for retrieving various information about the nodes.

Zebra Mptt uses [table locks](http://dev.mysql.com/doc/refman/8.0/en/lock-tables.html) making sure that database integrity is always preserved and that concurrent MySQL sessions don't compromise data integrity. Also, Zebra Mptt uses a caching mechanism which has as result the fact that regardless of the type, or the number of retrieval operations, **the database is read only once per script execution!**

## Features

- provides methods for adding nodes anywhere in the tree, deleting nodes, moving and copying nodes around the tree and methods for retrieving various information about the nodes
- uses a caching mechanism which has as result the fact that regardless of the type, or the number of retrieval operations, **the database is read only once per script execution**
- uses [table locks](http://dev.mysql.com/doc/refman/8.0/en/lock-tables.html) making sure that database integrity is always preserved and that concurrent MySQL sessions don't compromise data integrity
- uses **mysqli** extension
- has [awesome documentation](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html)
- code is heavily commented and generates no warnings/errors/notices when PHP's error reporting level is set to [E_ALL](https://www.php.net/manual/en/function.error-reporting.php)

## :notebook_with_decorative_cover: Documentation

Check out the [awesome documentation](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html)!

## 🎂 Support the development of this project

Your support is greatly appreciated and it keeps me motivated continue working on open source projects. If you enjoy this project please star it by clicking on the star button at the top of the page. If you're feeling generous, you can also buy me a coffee through PayPal or become a sponsor.
**Thank you for your support!** 🎉

[<img src="https://img.shields.io/github/stars/stefangabos/zebra_mptt?color=green&label=star%20it%20on%20GitHub" width="132" height="20" alt="Star it on GitHub">](https://github.com/stefangabos/Zebra_Mptt) [![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=49VT6G7L5GPAS) [<img src="https://img.shields.io/badge/-Sponsor-fafbfc?logo=GitHub%20Sponsors">](https://github.com/sponsors/stefangabos)

## Requirements

PHP 5.0.0+, MySQL 4.1.22+

## Installation

You can install Zebra Mptt via [Composer](https://packagist.org/packages/stefangabos/zebra_mptt)

```bash
# get the latest stable release
composer require stefangabos/zebra_mptt

# get the latest commit
composer require stefangabos/zebra_mptt:dev-master
```

Or you can install it manually by downloading the latest version, unpacking it, and then including it in your project

```php
require_once 'path/to/Zebra_Mptt.php';
```

## Install MySQL table

Notice a directory called *install* containing a file named *mptt.sql*. This file contains the SQL code that will create the table used by the class to store its data. Import or execute the SQL code using your preferred MySQL manager (like phpMyAdmin or the fantastic Adminer) into a database of your choice.

## How to use

```php
// include the Zebra_Mptt class
// (you don't need this if you are using Composer)
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
$cherry = $mptt->add($red, 'Cherry');
$banana = $mptt->add($yellow, 'Banana');

// add two kinds of meat
$mptt->add($meat, 'Beef');
$mptt->add($meat, 'Pork');

// move 'Banana' to 'Meat'
$mptt->move($banana, $meat);

// get a flat array of descendants of 'Meat'
$mptt->get_descendants($meat);

// get a multidimensional array (a tree) of all the data in the database
$mptt->get_tree();
```
