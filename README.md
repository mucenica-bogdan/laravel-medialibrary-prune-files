# Media library prune

Laravel package to prune stale files created by [spatie medialibrary](https://github.com/spatie/laravel-medialibrary)

# Install

```
composer require falcon/laravel-medialibrary-prune-files
```

# Run

Basic ussage

```
php artisan media-library:prune-files app/public
```

Checks for media folders inside of a filesystem disk that do not have a media library record in the database. 

A folder is an *"media folder"* if:
- the folder name is numeric AND
- the folder contains only files OR the directories within the are either `responsive-images` or `conversions`

If you want to just check what files are going to be deleted, you can use the `--dry-run` command option

```
php artisan media-library:prune-files app/public --dry-run
```

BY default the package will use the `local` disk. To change it use the `--disk` option 

```
php artisan media-library:prune-files media-libary --dry-run --disk=public
```

# Change log

## v1.0.0 - 29-04-2020
- Initial release
