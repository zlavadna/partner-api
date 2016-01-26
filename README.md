# ZlavaDna.sk partner API library
Suitable for projects ZlavaDna.sk, SlevaDne.cz and Boomer.sk.

## Installation

You can download source code directly from GitHub or you can install the library via composer:

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

For using the Api, you will need your unique "partner code".
Your partner codes are different on each project.
Working test codes in examples are for project ZlavaDna.sk.
Example of partner's code for testing:


```
6c1e55ec7c43dc51a37472ddcbd756fb
```

After that, you would need autoload the classes. You could use composer's autoloader:

```
require __DIR__ . '/vendor/autoload.php';
```

You need one instance of the Api class to communicate with one URL.
For example, if you want to send requests to ZlavaDna.sk Api,
create instance of the Api class and pass ZlavaDna.sk URL to the constructor.

You can use one of URL constants:
- Api::ZLAVADNA_URL
- Api::BOOMER_URL
- Api::SLEVADNE_URL

```
use ZlavaDna\Api;
use ZlavaDna\Transport\Transport;
use ZlavaDna\Transport\Response;

require __DIR__ . '/vendor/autoload.php';

$api = new Api(Api::ZLAVADNA_URL, '6c1e55ec7c43dc51a37472ddcbd756fb', new Transport(new Response()));
```

Second parameter is your partner code and third is class, which actually sends the requests.
By default, requests are send over https. For using HTTPS, you need the openssl extension to be loaded.
If you want to use HTTP instead, just put URL starting with "http://" instead of "https://" to Api constructor.

```
$api = new Api('http://www.zlavadna.sk/api/index.php', ...
```

When you will be done with Api instance, you will be able to call Api actions:

```
$api->queryCoupon('428366425503', 'FKRGKNQX');
```

All of the examples use the test data so that they are working.