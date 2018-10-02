# GAME load-balancer

# Routes

 Client- `127.0.0.1:8000`
 
 Clear cache- `127.0.0.1:8002/clear`

# Installation

_Windows environment_ 

**Requirement**

`Composer`

 **Run central server( centerServer folder)**
 
     cd centerServer
     
     composer install
     
     php bin/console server:run 127.0.0.1:8008

 **Run proxy( root folder)**
 
`php -S 127.0.0.1:8009 proxy.php`

 **Run API servers( API folder)**
 
    cd api
    
    composer install

 For multiple API servers run on different terminal

    php bin/console server:run 127.0.0.1:8002
    
    php bin/console server:run 127.0.0.1:8003
    
    php bin/console server:run 127.0.0.1:8004


  **Run Client( Client folder)**
 
    cd client
    
    composer install
    
    php bin/console server:run 127.0.0.1:8000
    
    
    
 **UML**
 
 ![infrastructure without db](https://user-images.githubusercontent.com/18429697/46334913-7778c980-c62e-11e8-9722-1c0d53ab18ff.png)
