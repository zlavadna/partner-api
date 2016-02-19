# ZlavaDna.sk partner API library
Suitable for projects ZlavaDna.sk, SlevaDne.cz and Boomer.sk.
This Api can be used to check state of coupons and mark coupons as: consumed, unconsumed, reserved or unreserved.

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

To use this Api, you need your unique "partner code".
**Your partner code is different for each project.**
Coupons and partner code for testing purposes in this documentation are for ZlavaDna.sk project.
Coupons and partner code for Boomer.sk and SlevaDne.cz are at the botom of this documentation.

###Basic usage:
1. Check validity and state of the coupon with **queryCoupon** action and if it returns True, parse response data to validate dealID/dealItemID/variant\[id\] (what is applicable for your offer)
2. (Optional) if you have reservations or you ship goods, you can call **reserveCoupon** action to mark coupon as reserved or shipped
3. If the coupon is **valid** and is for **your current deal/dealItem/variant** (check dealID/dealItemID/variant\[id\] in response data) you call **consumeCoupon** action and check it's response

**Test partner code (ZlavaDna.sk):**

```
6c1e55ec7c43dc51a37472ddcbd756fb
```

**Test coupons (ZlavaDna.sk):**

| Code          | Secret   |
| ------------- | -------- |
| 428366425503  | FKRGKNQX |
| 385908803252  | BPVWWACZ |
| 301889958733  | RCXWMUNW |

Once you have your partner code, you need to autoload the classes. You can use composer's autoloader:

```
require __DIR__ . '/vendor/autoload.php';
```

You need one instance of the Api class to communicate with one URL (Project). If you have deals on multiple projects,
you will need multiple Api instances to check coupon on all our projects.
For example, if you want to send requests to ZlavaDna.sk Api,
create instance of the Api class by constructor and pass: ZlavaDna.sk URL as the first parameter, the second parameter
is your partner code for specific project (ZlavaDna.sk in this example) and the third is class,
which actually sends the requests.

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

By default, requests are send over HTTPS. For using HTTPS, you need openssl extension to be loaded.
If you want to use HTTP instead, just put URL starting with "http://" instead of "https://" to Api constructor,
or change the URL constants.

```
$api = new Api('http://www.zlavadna.sk/api/index.php', ...
```
After initializing the Api instance, you can call all Api actions.

##Api actions
Once we have our Api instance, we can start with calling appropriate Api actions. Api actions are used to check state
of the coupons and mark them as: consumed, unconsumed, reserved or unreserved. All actions return response with
same structured object (described in last chapter of Api actions). Possible parameters for actions are:
$code - coupon number
$secret - password
You can find these information on each coupon from customer.
Example of ZlavaDna.sk coupon as stated above:
```
$code = '428366425503';
$secret = 'FKRGKNQX';
```
Api actions list and how to use them:

###queryCoupon
This action checks if given coupon data are correct and if this coupon exists in our Project. When called only with
the first parameter (code), it checks whether a coupon with this code exists in our Project. When called with
both parameters (code and secret) it also checks whether the pair code-secret is right and this coupon exists in our Project.
If the coupon is valid (result is True), you should check DealID/DealItemID/Variant\[id\] (based on your deal presentation
on our Project) in response to confirm that this coupon is for your current deal, dealItem or variant. **This is important
especially when you are selling more than one deal at the same time, or your deal has more dealitems/variants.** See image
in Api action response section.

```
$response = $api->queryCoupon('428366425503', 'FKRGKNQX');
if ($response->getResult() == TRUE) {
    //coupon exists and is not consumed
    $responseData = $response->getData();
    if($responseData['dealItemID'] == 'YourCurrentDealItemID') {
        //coupon is for your current dealItem. Or check variant if you have any
    }
}
```

###consumeCoupon
Action used for consuming coupon. Both parameters are required.

```
$api->consumeCoupon('428366425503', 'FKRGKNQX');
```

###unConsumeCoupon
Action used for un-consuming coupon. Both parameters are required.

```
$api->unConsumeCoupon('428366425503', 'FKRGKNQX');
```

###reserveCoupon
Action used for coupon reservation. Both parameters are required. If you sell goods and send them by Post, you can also use
this action to mark coupon/goods as shipped.

```
$api->reserveCoupon('428366425503', 'FKRGKNQX');
```

###unReserveCoupon
Action used for canceling coupon reservation or shipment. Both parameters are required.

```
$api->unReserveCoupon('428366425503', 'FKRGKNQX');
```

###Api action response
Each Api action returns the same structured object. Object contains 4 private variables: result, data, errorCode and errorMessage. You can access them with these methods:

####getResult()
Returns bool value of Api action result.

```
$response->getResult();
```
Response (bool):
* True - success
* False - failure

####getData()
Returns information about inquired coupon.

```
$response->getData();
```
Response structure (array):
```
  [
      'teamId' => '54635', // deprecated, use dealItemID instead
      'parentTeamId' => '54635',  // deprecated, use dealID instead
      'dealItemID' => '54635',
      'dealID' => '54635',
      'teamShortTitle' => 'test deal', //deprecated, use dealItemTitle instead
      'dealItemTitle' => 'test deal',
      'validFrom' => '2013-09-13T00:00:00+02:00',
      'validTo' => '2020-03-23T23:59:59+01:00',
      'variantName' => [
          0 => [
              'id' => '61449',
              'text' => 'Red',
              'title' => 'Color'
          ],
          1 => [
              'id' => '61453',
              'text' => '1.9.2013 - 7.9.2013',
              'title' => 'Date'
          ]
      ]
      'partnerAddressName' => 'test',
      'price' => '0.00',
      'reservation' => 'booked'
  ]
```
Description:
Deal is presentation of your offer. Deal contains deal items that our customers can buy. They can have different prices,
titles, valid times and variants.
Variants of deal items define more specifically information about deal items. For example variants can be
different color or size of your product (deal item).
You receive dealID, dealItemIDs and VariantIDs (if applicable) from our merchant before the beginning of your offer on
our projects. Each project has different IDs for the same offer.

![alt text](https://raw.githubusercontent.com/zlavadna/partner-api-php/master/api_readme.png "Deal/dealItem/variant explanation")

Response array:
* dealID - ID of deal on our project
* dealItemID - ID of item, customers buy items
* dealItemTitle - short name of deal item
* validFrom - deal item start date
* validTo - deal item end date
* variantName - array with variant information about coupon
* partnerAddressName - partner address
* price - price of coupon/deal item
* reservation - information about reservation/shipment

####getErrorCode()
If an error occurs, it will return the error code. Otherwise it returns 0.

```
$response->getErrorCode();          //response for example: int 3
```

Table of error codes:
```
[
    1 => 'wrong coupon',
    2 => 'wrong password',
    3 => 'used coupon',
    4 => 'canceled coupon',
    5 => 'offline coupon',
    6 => 'expired coupon',
    7 => 'wrong action or no action specified',
    8 => 'wrong or missing parameters',
    9 => 'partner and coupon mismatch, wrong coupon code or partner code',
    11 => 'coupon consume went wrong',
    13 => 'coupon unconsume went wrong',
    14 => 'invalid login credentials',
    15 => 'secure communication is needed',
    16 => 'coupon reserve went wrong',
    17 => 'coupon already reserved',
    18 => 'coupon unreserve went wrong',
    19 => 'coupon is not reserved'
]
```

####getErrorMessage()
If an error occurs, it will returns the error message. Otherwise it returns empty string ''.
List of error messages is in the section of method ```getErrorCode()```.
```
$response->getErrorMessage();           //response for example: string 'used coupon'
```

##Boomer.sk and SlevaDne.cz test coupons and partner code

###Boomer.sk

**Test partner code:**

```
b607ba543ad05417b8507ee86c54fcb7
```

**Test coupons:**

| Code          | Secret   |
| ------------- | -------- |
| 972852822519  | YVUEQEKL |
| 868694988285  | VXANNZLJ |
| 375514170686  | PRAWAORT |

###SlevaDne.cz

**Test partner code:**

```
e1696007be4eefb81b1a1d39ce48681b
```

**Test coupons:**

| Code          | Secret   |
| ------------- | -------- |
| 867361825063  | DGLVXRQS |
| 770532907656  | ELNJYTYT |
| 976497961214  | JJFEPBAH |
