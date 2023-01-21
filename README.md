# Directory Helper

## How to install?

composer require lump1k/directory

## How to use?

```php
use \Lump1k\Directory\Helper as DirHelper;

$dir = __DIR__ . DIRECTORY_SEPARATOR . 'test';

$isEmpty = DirHelper::isEmpty($dir);

$files = DirHelper::getFiles($dir);

DirHelper::delete($dir);
```
