- Service Providers should be added to the `providers` array in "app/config/app.php".
  ```
  'Lockr\Report\ServiceProvider',
  'Lockr\Client\ServiceProvider',
  'Lockr\Export\ServiceProvider',
  'Lockr\Statement\ServiceProvider',
  'Lockr\Store\ServiceProvider'
  ```
- Routes should be included in "app/routes.php"
  ```php
  include('lockr/report/routes.php');
  include('lockr/client/routes.php');
  include('lockr/export/routes.php');
  include('lockr/statement/routes.php');
  ```
- Code should be autoloaded via PSR-4 in "composer.json".
  ```json
  "autoload": {
    "psr-4": {
      "Lockr\\": "app/lockr"
    }
  }
  ```
