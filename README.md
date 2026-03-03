# Laravel GChat Alert

Send Laravel application error alerts directly to Google Chat using
Incoming Webhooks.

This package integrates with Laravel's logging system and sends log
events to a Google Chat space.

Supports Laravel 8, 9, 10, 11 and 12.

------------------------------------------------------------------------

## 🚀 Features

-   Google Chat webhook integration
-   Custom Monolog logging driver
-   Supports Laravel 8--12
-   Environment-based log level filtering
-   Auto-discovery support
-   Works with HTTP & CLI errors
-   Compatible with Monolog 2 & 3
-   Plug & Play configuration

------------------------------------------------------------------------

## 📦 Installation

Install via Composer:

    composer require savan/gchat-error-alert

------------------------------------------------------------------------

## 🔧 Step 1: Create Google Chat Webhook

1.  Open Google Chat
2.  Go to the Space where you want alerts
3.  Click Space name → Manage Webhooks
4.  Click **Add Webhook**
5.  Copy the generated Webhook URL

Example webhook:

    https://chat.googleapis.com/v1/spaces/XXXX/messages?key=XXX&token=XXX

------------------------------------------------------------------------

## ⚙ Step 2: Publish Configuration

Run:

    php artisan vendor:publish --tag=gchat-alert-config

This will create:

    config/gchat-alert.php

------------------------------------------------------------------------

## 🧾 Step 3: Configure Environment Variables

Add to your `.env` file:

    GCHAT_ALERT_ENABLED=true
    GCHAT_ALERT_WEBHOOK=https://chat.googleapis.com/v1/spaces/XXXX/messages?key=XXX&token=XXX
    GCHAT_ALERT_LEVEL=error

------------------------------------------------------------------------

## 📝 Step 4: Configure Logging

Open:

    config/logging.php

Add this channel inside `channels`:

    'gchat' => [
        'driver' => 'gchat',
    ],

Then add it to your stack:

    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'gchat'],
    ],

Make sure your default log channel is:

    LOG_CHANNEL=stack

------------------------------------------------------------------------

## 🔥 Step 5: Clear Configuration Cache

    php artisan config:clear
    php artisan cache:clear

------------------------------------------------------------------------

## 🧪 Testing

Create a test route:

    use Illuminate\Support\Facades\Log;

    Route::get('/test-alert', function () {
        Log::error('Test error from Laravel GChat Alert');
        return 'Alert Sent';
    });

Visit:

    /test-alert

You should receive a Google Chat alert.

------------------------------------------------------------------------

## 📊 Log Levels

Available levels (highest to lowest severity):

-   emergency
-   alert
-   critical
-   error
-   warning
-   notice
-   info
-   debug

If `GCHAT_ALERT_LEVEL=error`, it will send:

-   error
-   critical
-   alert
-   emergency

------------------------------------------------------------------------

## 🖥 CLI & Queue Support

This package captures:

-   HTTP request errors
-   Artisan command errors
-   Queue worker failures
-   Scheduled task errors
-   Runtime CLI exceptions

------------------------------------------------------------------------

## 🛠 Requirements

-   PHP 7.4+
-   Laravel 8 -- 12
-   Google Chat Incoming Webhook

------------------------------------------------------------------------

## ❌ Troubleshooting

If you are not receiving alerts, check:

1.  `LOG_CHANNEL=stack`
2.  `GCHAT_ALERT_ENABLED=true`
3.  Webhook URL is correct
4.  Log level is set correctly
5.  Configuration cache is cleared

Run:

    php artisan config:clear
    composer dump-autoload

------------------------------------------------------------------------

## 🏷 Versioning

This package follows Semantic Versioning:

-   v1.0.0 -- Initial release
-   v1.1.0 -- Feature update
-   v1.1.1 -- Bug fix

------------------------------------------------------------------------

## 📜 License

MIT License

------------------------------------------------------------------------

## 👤 Author

Savan Rathod

------------------------------------------------------------------------

## ⭐ Support

If you find this package useful, please consider giving it a star on
GitHub.