AfterHours.FM code snippets
=========

Various code snippets for Afterhours.fm

Files
-----------

Below are the included files with their purpose.

* listeners.php - a CLI PHP script to calculate total number of ShoutCast 2.0 users on multiple servers and mounts.
* nowplaying.php - a CLI PHP script to generate forum URLs according to the titles and forum data provided with ability to override default URL in case there are no matches for the show.

####listeners.php
--------------

```php
Populate Server Array in the following format

$servers = array
    		(
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
				'198.27.74.214' => array('port' => '9000', 'sid' => '1'),
			);

IP Address or a hostname defines array item. Each item contains two parameters: server port and mount id. 

```
---
####nowplaying.php
--------------

```php

Initialize using 

$link = new Link();
In this case it will default URL to http://ah.fm if there is no match for current and next show.

$link = new Link('http://ah.fm/other_special_url');
In this case it will default URL to http://ah.fm/other_special_url if there is no match for current and next show.

```

License
----

MIT

*Free Software, Hell Yeah!*

  [john gruber]: http://daringfireball.net/
  [@thomasfuchs]: http://twitter.com/thomasfuchs
  [1]: http://daringfireball.net/projects/markdown/
  [Marked]: https://github.com/chjj/marked
  [ace editor]: http://ace.ajax.org
  [node.js]: http://nodejs.org
  [Twitter Bootstrap]: http://twitter.github.com/bootstrap/
  [keymaster.js]: https://github.com/madrobby/keymaster
  [jQuery]: http://jquery.com  
  [@tjholowaychuk]: http://twitter.com/tjholowaychuk
  [express]: http://expressjs.com
  
    