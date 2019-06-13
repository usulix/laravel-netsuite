# usulix/laravel-netsuite

[ryanwinchester/netsuite-php](https://github.com/ryanwinchester/netsuite-php) is a php package which 
wraps the [NetSuite PHP Toolkit](http://www.netsuite.com/portal/developers/resources/suitetalk-sample-applications.shtml)
in an easier to use API. ryanwinchester/netsuite-php targets NetSuite WebServices.
 
This package wraps ryanwinchester/netsuite-php in a standard Laravel 5 package and also adds a basic
API for targeting NetSuite RESTlets

## Installation

Will use the latest `ryanwinchester/netsuite-php` version up to `v2018.2.0` 

```
    composer require usulix/laravel-netsuite:dev-master
```
if an older version say `v2017.1.1` or `v2016.2.0` is required
 ```
     composer require ryanwinchester/netsuite-php v2017.1.1
 ```


Register the package

- Laravel 5.5 and up Uses package auto discovery feature, no need to edit the `config/app.php` file.

- Laravel 5.4 and below Register the package with laravel in `config/app.php` under `providers` with the following:

```
   'providers' => [
   /*
   * Laravel Framework Service Providers...
   
   Usulix\NetSuite\Providers\NetSuiteServiceProvider::class,
   Usulix\NetSuite\Providers\NetSuiteApiProvider::class,
```

NetSuiteServiceProvider - provides access to the ryanwinchester/netsuite-php WebServices 
Interface 

NetSuiteApiProvider - provides access to the RESTlet API

## Set Configuration in .env
  using NlAuth (account, email, password and role required for either WebServices or RESTlets)
  
  _note_ (NETSUITE_ENDPOINT, NETSUITE_WEBSERVICES_HOST, NETSUITE_APP_ID) needed for WebServices
  
  _note_ (NETSUITE_RESTLET_HOST) needed for RESTlets
  
```
  NETSUITE_ENDPOINT=2018_2 
  NETSUITE_HOST=https://webservices.sandbox.netsuite.com
  NETSUITE_ACCOUNT=123456
  NETSUITE_EMAIL=sample@sample.com
  NETSUITE_PASSWORD=sup3rs3cr3t
  NETSUITE_ROLE=3
  NETSUITE_APP_ID=FFFFFFFF-1111-AAAA-9999-000000000000
```
or
```
  NETSUITE_HOST=https://rest.sandbox.netsuite.com/app/site/hosting/restlet.nl
```

using Token (account, consumer_key, consumer_secret, token, token_secret required for either WebServices or RESTlets)
  
```
  NETSUITE_ENDPOINT=2016_1 
  NETSUITE_HOST=https://webservices.sandbox.netsuite.com
  NETSUITE_ACCOUNT=123456
  NETSUITE_CONSUMER_KEY=aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
  NETSUITE_CONSUMER_SECRET=bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
  NETSUITE_TOKEN=cccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc
  NETSUITE_TOKEN_SECRET=dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd
```
or
```
  NETSUITE_HOST=https://rest.sandbox.netsuite.com/app/site/hosting/restlet.nl
```

Add values to .env which correspond to either token based authentication OR NlAuth based authentication but not both!

The presence of a NETSUITE_PASSWORD in .env is used as a flag for setting NlAuth as authentication method.

What if you need token for WebServices and NlAuth for RESTlets - or you need different accounts for each...

Submit a feature request as an issue or a pull request with a solution. 

My experience with NetSuite is based upon a single integration, so coverage of all situations is 
probably not happening very well initially, but the project is public in order to obtain help in 
developing a more useful and time-saving solution.

## Instantiate an instance of the service and make NetSuite call using the service

using a WebService

```
  use NetSuite\Classes\GetRequest;
  use NetSuite\Classes\RecordRef;
  
  $myWebService =  app('NetSuiteWebService');
  
  $request = new GetRequest();
  $request->baseRef = new RecordRef();
  $request->baseRef->internalId = "123";
  $request->baseRef->type = "customer";
  
  $getResponse = $myWebService->get($request);
  
  if ( ! $getResponse->readResponse->status->isSuccess) {
    echo "GET ERROR";
  } else {
    $customer = $getResponse->readResponse->record;
  }

```

using a RESTlet

```
    $myRESTletService = app('NetSuiteApiService');
    
    /**
    * You can set processing on the response Body returned
    * 'raw' - just return the stream retrieved (default)
    * 'singleDecode' - return json_decode($body, true)
    * 'doubleDecode' - return json_decode(json_decode($body,  true), true)
    * 'responseData' - return json_decode(json_decode($body,  true), true)['data']
    *
    * Your mileage may vary based upon how your NetSuite RESTlet is coded
    */
    
    $myRESTletService->setReturnProcessing('singleDecode');
    
    /**
    * You can set the Request Method (default is 'POST')
    */
    
    $myRESTletService->setMethod('POST');
    
    /**
    * retrieve your response by calling getNetsuiteData with your RESTlet Id and
    * any payload in an array
    */
    
    $myResults = $myRESTletService->getNetsuiteData('123', 
       ['action' => 'myAction', 'user'=>'212121']
    );
    
    foreach($myResults as $res){
                $this->doSomething($res);
    }
```
