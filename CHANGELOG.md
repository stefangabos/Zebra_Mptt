## version 2.3.5 (July 06, 2018)

- fixed [#5](https://github.com/stefangabos/Zebra_Mptt/issues/5) where `get_previous_sibling` was in fact returning the `next` sibling. Thanks [@kinnevo](https://github.com/kinnevo)!
- performance tweaks for `get_previous_sibling` and `get_next_sibling` methods
- escape custom table and column names; thanks [@dominikfiala](https://github.com/dominikfiala)!

## version 2.3.4 (May 20, 2017)

- unnecessary files are no more included when downloading from GitHub or via Composer

## version 2.3.3 (May 10, 2017)

- minor source code tweaks
- documentation is now available in the repository and on GitHub
- the home of the library is now exclusively on GitHub

## version 2.3.2 (January 19, 2016)

- fixed an issue with auto-loading when installed via Composer
- updated references to the minimum required PHP version

## version 2.3.0 (January 19, 2016)

- <strong style="color: #C40000">this version breaks compatibility with previous versions</strong>
- "get_children_count" and "get_descendats_count" methods were both replaced by the new [get_descendant_count](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodget_descendant_count) method
- "get_selectables" method was renamed to [to_select](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodto_select)
- added 3 new methods: [get_siblings](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodget_siblings), [get_next_sibling](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodget_next_sibling) and [get_previous_sibling](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodget_previous_sibling)
- the [move](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodmove) method can now be used to move nodes before and after another nodes (not just as a child of another node)
- dropped support for the deprecated "mysql" extension; the library now only works with the "mysqli" extension
- minimum required PHP version is now 5.0.5 instead of 4.4.9
- fixed some issues preventing the library from running pn PHP7; thanks **Jiri Melcak**
- improved compatibility with Composer
- some minor performance tweaks

## version 2.2.5 (November 14, 2013)

- added a new [update](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodupdate) method, useful if you want to change a node's name

## version 2.2.4 (September 14, 2013)

- fixed a bug with the [to_list](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodto_list) method when custom column names were used; thanks **hendra**

## version 2.2.3 (July 14, 2013)

- the "get_parent" method now returns all the properties of the parent node and not just the ID; thanks **Edgar Veiga**
- added a new method: [to_list](https://stefangabos.github.io/Zebra_Mptt/Zebra_Mptt/Zebra_Mptt.html#methodto_list) which can be used to generate HTML ordered or unordered lists for a given node; thanks to **Dino Sane Moreira** for suggesting
- project is now available on [GitHub](https://github.com/stefangabos/Zebra_Mptt) and as a [package for Composer](https://packagist.org/packages/stefangabos/zebra_mptt)

## version 2.2.2 (November 06, 2012)

- fixed a bug where the last node returned by the "get_path" method did not have the correct key; thanks to **Gus**

## version 2.2.1 (July 19, 2012)

- fixed a bug that escaped fixing in the previous release, where the get_selectables() method was triggering a "Strict Standards" notice in PHP 5.3+; thanks to **mrplugins**
- fixed a bug where the "copy" method was not working correctly; thanks to **Victor Hugo Contreras**

## version 2.2 (January 20, 2012)

- fixed an issue with some constructs in the code that would trigger a "Strict standards: Only variables should be passed by reference" warnings in PHP 5.3+; thanks **Juan Gutierrez**

## version 2.1 (June 15, 2011)

- fixed a bug where some of the methods were not working anymore if custom column names were used for the MySQL table (thanks to **hisham** for reporting)

## version 2.0 (June 11, 2011)

- entire code was audited and improved
- added new methods
- many documentation refinements

## version 1.0 (July 22, 2009)

- initial release
</dl>