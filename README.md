# Emercoin RPC Tools


[![License](https://img.shields.io/packagist/l/azhuravlov/emercoin-rpc-tools.svg)](https://packagist.org/packages/azhuravlov/emercoin-rpc-tools)
[![Version](https://img.shields.io/packagist/vpre/azhuravlov/emercoin-rpc-tools.svg)](https://packagist.org/packages/azhuravlov/emercoin-rpc-tools)
[![Build status on Linux](https://img.shields.io/travis/azhuravlov/emercoin-rpc-tools/master.svg)](http://travis-ci.org/azhuravlov/emercoin-rpc-tools)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/azhuravlov/emercoin-rpc-tools.svg)](https://scrutinizer-ci.com/g/azhuravlov/emercoin-rpc-tools/)
[![Total Downloads](https://poser.pugx.org/azhuravlov/emercoin-rpc-tools/downloads)](https://packagist.org/packages/azhuravlov/emercoin-rpc-tools)

Documentation
-------------

Documentation is available [here](https://github.com/azhuravlov/emercoin-rpc-tools/blob/master/doc/INDEX.md)

##### Simple example of usage below

```php
$connection = new StdConnection('username', 'userpass', '127.0.0.1', 'https', '6662');
try {
  $response = $connection->query('getinfo');
  $arrayData = $response->getResult();
  print 'Version: ' . $arrayData['version'] . "\n";
} catch (TransportException $e) {
  print $e->getMessage() . "\n";
}
```

Bug Tracking
------------

If you want to report a bug or suggest an idea, please use [GitHub issues](https://github.com/azhuravlov/emercoin-rpc-tools/issues).

MIT License
-----------

This package is completely free and released under the [MIT License](https://github.com/azhuravlov/emercoin-rpc-tools/blob/master/LICENSE).

Authors
-----------
* [Artem Zhuravlov](https://github.com/azhuravlov)
* [Sergii Vakula](https://github.com/snvakula)
* And other [contributors](https://github.com/azhuravlov/emercoin-rpc-tools/graphs/contributors)
