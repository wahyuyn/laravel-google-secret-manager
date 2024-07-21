# Laravel - Google Secret Manager

A Laravel package to manage and integrating environment secrets using Google Secrets Manager (GSM)

## Installation

You can install the package via composer:

```bash
composer require wyn/laravel-google-secret-manager
```

Publish Config:

```bash
php artisan vendor:publish --provider="wyn\GoogleSecretManager\GoogleSecretManagerServiceProvider"
```

## Configuration

#### Set Up Google Cloud Project:

* Ensure you have a Google Cloud project set up.
* Enable the Secret Manager API for your project.
* Create secrets in the Secret Manager as needed.

#### Add Environment Variables:

Add your Google Cloud project ID and secret ID to your .env file:

```
GOOGLE_PROJECT_ID=your-google-cloud-project-id
GOOGLE_SECRET_ID=your-secret-id
```

#### Google Credentials:

Ensure your application has access to your Google Cloud credentials. You can set the GOOGLE_APPLICATION_CREDENTIALS environment variable to point to your service account JSON key file:

```
GOOGLE_APPLICATION_CREDENTIALS=/path/to/your/service-account-file.json
```

## Usage

#### Injecting Secrets into Environment Variables

You can inject secrets into environment variables using the injectSecretToEnv method.

```
use Illuminate\Support\Facades\App;$secretManager = App::make('google.secret.manager');
// Inject the secret into environment variables
$secretManager->injectSecretToEnv(env('GOOGLE_PROJECT_ID'), env('GOOGLE_SECRET_ID'), 'YOUR_ENV_KEY');
```

#### Injecting Secrets into Laravel Configuration

You can inject secrets into Laravel configuration settings using the injectSecretToConfig method.

```
use Illuminate\Support\Facades\App;$secretManager = App::make('google.secret.manager');
// Inject the secret into Laravel configuration
$secretManager->injectSecretToConfig(env('GOOGLE_PROJECT_ID'), env('GOOGLE_SECRET_ID'), 'config.key');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
