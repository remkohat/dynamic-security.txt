# dynamic-security.txt

Server-wide dynamically created security.txt and optionally signed with OpenPGP key using PHP.

https://domain.tld/security.txt

https://domain.tld/.well-known/security.txt

For Apache and Nginx.

***Features:***
- All available fields according to [RFC9116](https://www.rfc-editor.org/rfc/rfc9116) can be configured
  - except for **Canonical** which is generated automatically based on visited URL
  - and **Expires** which is generated automatically based on time of visit + 1 year
- Only configured fields will be shown
- Output will be signed if a valid key is supplied
- If a website has a local security.txt file present then the script will not run, so your customers can create their own security.txt file

## _Requirements_

- PHP >= 7.4
- PHP-gnupg extension
- GnuPG >= 2.0

## _How To Use_

### Copy

- Copy securitytxt folder to /var/www/

  <sup>(for any other location you need to alter apache.conf)</sup>

### Edit desired fields in /var/www/securitytxt/conf/[config.php](securitytxt/conf/config.php)

### When signing with OpenPGP key

- Create folder /var/www/.gnupg

  ```mkdir /var/www/.gnupg```

- Set folder permissions to Apache user

  ```chown www-data:www-data /var/www/.gnupg```

- The first time you not only need the public key but also the private key.
  
  Uncomment the relevant lines in /var/www/securitytxt/sign/[sign.php](securitytxt/sign/sign.php) and /var/www/securitytxt/conf/[config.php](securitytxt/conf/config.php).
  
  After the first successful run they can be commented again.

### Enable webserver configuration

### - _Apache_

- Copy /var/www/securitytxt/conf/[apache.conf](securitytxt/conf/apache.conf) to /etc/apache2/conf-available/securitytxt.conf

- Check PHP handler and change if necessary

- Enable securitytxt.conf in Apache

  ```a2enconf securitytxt```

- Reload Apache

  ```systemctl reload apache2```

### - _Nginx_

- Copy /var/www/securitytxt/conf/[nginx.conf](securitytxt/conf/nginx.conf) to /etc/nginx/snippets/securitytxt.conf

- Check PHP handler and change if necessary

- Reload Nginx

  ```systemctl reload nginx```

### Server-wide

- Add below to every website's vhost configuration.

- If you use a management system like ISPConfig, Plesk etc. than add below to the vhost config that is used when adding or altering a website.

  Resync all websites after.

### - _Apache_

  ```RewriteEngine on```
  
  ```RewriteOptions Inherit```

### - _Nginx_

  ```include /etc/nginx/snippets/securitytxt.conf;```
