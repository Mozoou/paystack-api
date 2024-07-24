<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Test the Payment Initialization Endpoint

1.  **Open Postman** and create a new request.
    
2.  **Set the request method to `POST`**.
    
3.  **Enter the URL** for your endpoint:

    `https://nameless-reef-15409-45cc60f1c5ef.herokuapp.com/api/pay`

**In the Body tab**:

-   Select **raw**.
-   Set the type to **JSON**.
-   Enter the following request payload:

        {
	        "email": "test@example.com",
	        "domain": "example.com",
	        "amount": 1500
        }
**Send the request** and check the response.


## Test the Payment Callback Endpoint

1.  **Open Postman** and create a new request.
    
2.  **Set the request method to `GET`**.
    
3.  **Enter the URL** for your endpoint:
    
    `https://nameless-reef-15409-45cc60f1c5ef.herokuapp.com/api/pay/callback`

**Add query parameters** to simulate Paystack's callback:

-   `status=success`
-   `reference=test_reference`

Your complete URL should look like this:

    `https://nameless-reef-15409-45cc60f1c5ef.herokuapp.com/api/pay/callback?status=success&reference=test_reference`

**Send the request** and check the response.
