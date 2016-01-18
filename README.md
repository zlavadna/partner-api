# ZlavaDna.sk partner API library
Suitable for ZlavaDna.sk, SlevaDne.cz and Boomer.sk.

## Installation

You can download source code directly from github or you can install library via composer:

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/zlavadna/partner-api-php"
        }
    ],
    "require": {
        "zlavadna/partner-api-php": "1.*"
    }
}
```

## Usage

For using API, you should get you "partner code", which looks similar to this:

```
6c1e55ec7c43dc51a37472ddcbd756fb
```

After that, you would need autoloading library's classes'. You could use composer's autoloader:

```
require __DIR__ . '/vendor/autoload.php';
```

You need one instance of Api class to communicate with one URL.
For example, if you want to send requests to ZlavaDna.sk API,
create instance of Api class and pass ZlavaDna.sk URL to constructor.

You can use one of URL constants:
- Api::ZLAVADNA_URL
- Api::BOOMER_URL
- Api::SLEVADNE_URL

```
use ZlavaDna\Api;
use ZlavaDna\Transport\Transport;

$api = new Api(Api::ZLAVADNA_URL, '6c1e55ec7c43dc51a37472ddcbd756fb', new Transport());
```

Second parameter is your partner code and third is class, which actually sends the requests.
By default, requests are send over https. For using HTTPS, you need openssl extension to be loaded.
If you want to use HTTP instead, just put URL starting with "http://" instead of "https://" to Api constructor.

```
$api = new Api('http://www.zlavadna.sk/api/index.php', ...
```

When you will be done with Api instance, you will able to call Api actions:

```
$api->queryCoupon('428366425503', 'FKRGKNQX');
```