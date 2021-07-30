# Coffee Shop

### A RESTful Laravel application to managing a small coffee shop

- Laravel

- Sanctum

- Docker

#### Please make sure you have Docker and Docker Compose installed on your machine.

1. Clone the project


2. Config your mail server in `.env.example`

###### _Emails are not queued so to avoid getting error you should do this configuration or just add mails to queue._

```
   MAIL_MAILER=smtp
   
   MAIL_HOST=mailhog
   
   MAIL_PORT=1025
   
   MAIL_USERNAME=null
   
   MAIL_PASSWORD=null
   
   MAIL_ENCRYPTION=null
   
   MAIL_FROM_ADDRESS=null
   
   MAIL_FROM_NAME="${APP_NAME}"
```

3. Run `make setup` in the main folder.

#### Done.

```
Postman api collection =>
    https://www.getpostman.com/collections/f3438f0b8aef95dd554b    

http://localhost:81

http://localhost:8186 => phpMyAdmin

Manager =>
    email : manager@coffe.com
    password : password
Customer =>
    email : customer@coffe.com
    password : password
```

## APIs

#### Auth

```
login

register
```

#### Manager

_you should log in as a manager to have access to this folder._

```
- Change a waiting order
                       => manager can change an order's status.
- Cancle a waiting order
```

#### Public Apis

_you just need to log in._

```
- View Menu (list of products)

- Order at coffee shop with options =>
 
      you can order products via this api.
    
      each order can have multiple product.
      each product can have multiple *custom options* too.   
    
      you should enter your request as an json :
          {
           "order":
              {
                  "consume_location": "in shop",
                  "products": 
                      {                
                          "0": {
                              "product_id": "1",                  
                              "product_options": {
                                  "milk": "semi",
                                  "size": "small"
                              }
                          },
                          "1": {
                              ...
                          }              
                      }
              }
           }   
     
- View your order (product list, pricing & order status)
      => you are not allowed to see other ones orders.
    
- Cancle a waiting order
```

#### Tests
![alt](https://github.com/amirkhodabande/Coffe-Shop-Laravel/blob/master/Capture.PNG)