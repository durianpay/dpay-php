# Durianpay-PHP
---

## API Documentations
For full documentations regarding Durianpay APIs, visit [our docs](https://durianpay.id/docs/api).

## Getting started
If you already set up `composer` in your project, then type the command below:

```bash
composer require durianpay/dpay-php
```

## Using the SDK
Set up the SDK by passing your dashboard **API key** to Durianpay class.

```php
use Durianpay\Durianpay;

Durianpay::setApiKey('<YOUR_API_KEY>');
```

To find your API key, go to your dashboard [settings](https://dashboard.durianpay.id/#/settings) and click on **API keys**.

## Features and Resources

### Orders
For detailed information regarding Order APIs, visit our [docs](https://durianpay.id/docs/api/orders/overview/).

#### 1. Create Order
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

#### 2. Fetch Orders
```php
$res = \Durianpay\Resources\Order:fetch($queryParams);
```

Note: Passing `$queryParams` is optional. If `limit` property is not specified in the `$queryParams`, then the SDK immediately limits the amount of orders returned to the **five** latest ones.

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
    
var_dump($res);
```

#### 3. Fetch a Single Order
```php
$res = \Durianpay\Resources\Order:fetchOne($id);
```

Pass **order id** as an argument to the function.

Example call:
```php
$res = \Durianpay\Resources\Order::fetchOne('ord_JYF9EqFOiJ8812');
var_dump($res);
```

#### 4. Create a Payment Link
```php
$res = \Durianpay\Resources\Order:createPaymentLink($body);
```

Pass order details to function. This function will automatically append property `'is_payment_link' => true` to the request body.

Example call:
```php
$res = \Durianpay\Resources\Order::createPaymentLink(
    [
        'amount' => '10000',
        'currency' => 'IDR',
        'customer' => [
            'given_name' => 'John Doe',
            'email' => 'john_doe@nomail.com',
            'mobile' => '01234567890',
            'given_name' => 'John Doe'
        ],
        'items' => [[
            'name' => 'LED Television',
            'qty' => 1,
            'price' => '10000',
            'logo' => 'https://merchant.com/product_001/tv_image.jpg'
        ]]
    ]
);
    
var_dump($res);
```

---
### Payments
For detailed information regarding Payment APIs, visit our [docs](https://durianpay.id/docs/api/payments/overview/).

#### 1. Create Payment Charge
```php
$res = \Durianpay\Resources\Payment:charge($type, $request);
```

Pass order details to function. 

Example call:
```php
$type = 'EWALLET'; // EWALLET, VA, RETAILSTORE, ONLINE_BANKING, BNPL, or QRIS

$res = \Durianpay\Resources\Payment::charge($type, [
    'order_id' => 'ord_xrc0BvcVIF1680',
    'wallet_type' => 'DANA',
    'mobile' => '08112165688',
    'amount' => '15000'
]);
    
var_dump($res);
```

#### 2. Fetch Payments
```php
$res = \Durianpay\Resources\Payment:fetch($queryParams);
```

Note: Passing `$queryParams` is optional. If `limit` property is not specified in the `$queryParams`, then the SDK immediately limits the amount of payments returned to the **five** latest ones.

Example call:
```php
$res = \Durianpay\Resources\Payment::fetch();
var_dump($res);
```

#### 3. Fetch a Single Payment
```php
$res = \Durianpay\Resources\Payment:fetchOne($id);
```

Pass **payment id** as an argument to the function.

Example call:
```php
$res = \Durianpay\Resources\Order::fetchOne('pay_7UnK1zvIjB5787');
var_dump($res);
```

#### 4. Check Payment Status
```php
$res = \Durianpay\Resources\Payment:checkStatus($id);
```

The function will return the current state of the payment (completed, processing, cancelled, or failed).

Example call:
```php
$res = \Durianpay\Resources\Order::checkStatus('pay_7UnK1zvIjB5787');
var_dump($res);
```

#### 5. Verify Payments
```php
$res = \Durianpay\Resources\Payment:verify($id, $verificationSignature);
```

Example call:
```php
$signature = 'adf9a1a37af514c91225f6680e2df723fefebb7638519bcc7e7c9de02f2a3ab2';
$res = \Durianpay\Resources\Order::checkStatus('pay_7UnK1zvIjB5787', $signature);
var_dump($res);
```

#### 6. Cancel Payment
```php
$res = \Durianpay\Resources\Payment:cancel($id);
```

Will immediately set the payment status to **cancelled**.

Example call:
```php
$res = \Durianpay\Resources\Order::cancel('pay_7UnK1zvIjB5787');
var_dump($res);
```

#### 7. Calculate MDR Fees
```php
$res = \Durianpay\Resources\Payment:calculateMDRFees($queryParams);
```

Example call:
```php
$res = \Durianpay\Resources\Order::calculateMDRFees(['amount' => '50000']);
var_dump($res);
```



## Error Handling
Our SDK comes with various exception handlers. Whenever you call a function, it is recommended to always wrap it inside a `try-catch` block.

```php
use Durianpay\Exceptions\RequestException;

try {
    // Some Durianpay functions
} catch(RequestException $error) {
    $errorDesc = $error->getDetailedErrorDesc();
    
    echo $error;
    var_dump($errorDesc);
}
```