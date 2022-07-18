# Durianpay-PHP
Hello fellow developers!

---
## API Documentations
For full documentations regarding Durianpay APIs, visit [our docs](https://durianpay.id/docs/api).

---
## Getting started
If you already set up `composer` in your project, then type the command below:

```bash
composer require durianpay/dpay-php
```

---
## Using the SDK
Set up the SDK by passing your dashboard **API key** to Durianpay class.

```php
use Durianpay\Durianpay;

Durianpay::setApiKey('<YOUR_API_KEY>');
```

To find your API key, go to your dashboard [settings](https://dashboard.durianpay.id/#/settings) and click on **API keys**.

---
## Features and Resources

### Orders
For detailed information regarding Order APIs, visit our [docs](https://durianpay.id/docs/api/orders/overview/).

##### 1. Create Order
```php
$res = \Durianpay\Resources\Order:create($body);
```

Pass order details to function. 

Example call:
```php
$res = \Durianpay\Resources\Order::create(
        [
            'amount' => '10000',
            'payment_option' => 'full_payment',
            'currency' => 'IDR',
            'order_ref_id' => 'order_ref_001',
            'customer' => [
                'customer_ref_id' => 'cust_001',
                'given_name' => 'Jane Doe',
                'email' => 'jane_doe@nomail.com',
                'mobile' => '85722173217',
            ],
            'items' => [
                [
                    'name' => 'LED Television',
                    'qty' => 1,
                    'price' => '10000',
                    'logo' => 'https://merchant.com/product_001/tv_image.jpg',
                ],
            ]
        ]
    );
    
var_dump($res);
```

##### 2. Fetch Orders
```php
$res = \Durianpay\Resources\Order:fetch($queryParams);
```

Note: Passing `$queryParams` is optional. If `limit` property is not specified in the `$queryParams`, then the package immediately limits the amount of orders returned to 5.

Example call:
```php
$res = \Durianpay\Resources\Order::fetch(
        [
            'from' => '2021-01-01',
            'to' => '2022-12-31',
            'skip' => '0',
            'limit' => '8'
        ]
    );
```