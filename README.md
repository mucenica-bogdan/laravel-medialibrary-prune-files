# Media library prune

Laravel package to prune stale files created by [spatie medialibrary](https://github.com/spatie/laravel-medialibrary)

# Install

```
composer require falcon/laravel-medialibrary-prune-files
```

# Run

```
php artisan media-library:prune-files
```

If you want to just check what files are going to be deleted, you can use the `--dry-run` command option

```
php artisan media-library:prune-files --dry-run
```

# Change log

## v1.0.0 - 29-04-2020
- Initial release