# Composer services

## Description

A set of services working with Composer and Composer's configuration files.

## Installation

```bash
php composer.phar require constup/composer-services
```

## Features and Documentation

## Usage

All classes in this package are built as **services** which can be **autowired**.

You can read more about autowiring here:

- Laravel: [Automatic Resolution](https://laravel.com/docs/4.2/ioc#automatic-resolution).
- Symfony: [Autowiring](https://symfony.com/doc/current/service_container/autowiring.html) 

#### Example using dependency injection and autowiring

```php
use Constup\ComposerServices\ComposerFileServiceInterface;

class YourClass
{
    private ComposerFileServiceInterface $composerFileService;
    
    public function __construct(ComposerFileServiceInterface $composerFileService)
    {
        $this->composerFileService = $composerFileService;
    }
    
    public function getComposerFileService(): ComposerFileServiceInterface
    {
        return $this->composerFileService;
    }

    public function yourMethod(string $yourSourceDirectory): string
    {
        $composerJsonObject = $this->getComposerFileService()
            ->findAndFetchComposerJson($yourSourceDirectory);
        ...
    }   
}
```

#### Example using a class directly

```php

use Constup\ComposerServices\ComposerFileService;

class YourClass
{
    public function yourMethod(string $yourSourceDirectory): string
    {
        $composerJsonObject = (new ComposerFileService())
            ->findAndFetchComposerJson($yourSourceDirectory);
        ...
    }
}
```

## License

[MIT License](./LICENSE) 