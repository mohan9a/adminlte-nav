## Menu Builder for Adminlte

Menu Builder is a Laravel package for adminlte that allow the create and manage navigation in an easy way.

## **Quick Installation**

Begin by installing this package through Composer.

You can run:

```
composer require mohan9a/adminlte-nav 1.*
```

Or edit your project's composer.json file to require mohan9a/adminlte-nav.

```
    "require": {
        "mohan9a/adminlte-nav": "1.*"
    }
```

Next, update Composer from the Terminal:

```
composer update
```

Once the package's installation completes, the final step is to add the service provider. Open  `config/app.php`, and add a new item to the providers array:

```
Mohan9a\AdminlteNav\AdminlteNavServiceProvider::class,
```

Finally Publish package's configuration file:

```
php artisan vendor:publish --provider="Mohan9a\AdminlteNav\AdminlteNavServiceProvider" --tag="config"
```

Publish package's configuration file:

```
php artisan vendor:publish --provider="Mohan9a\AdminlteNav\AdminlteNavServiceProvider" --tag="migrations"
```

Finally run migration:

```
php artisan migrate
```


Then the file  `config/adminltenav.php`  will be created.

Define your own prefix and middlware in config/adminltenav.php file.

That's it! You're ready to go. 

Run Laravel app:

```
php artisan serve
```

You can access the menus at with URL: http://127.0.0.1/admin/menus 


## **Contribute and share ;-)**

If you like this little piece of code share it with you friends and feel free to contribute with any improvements.