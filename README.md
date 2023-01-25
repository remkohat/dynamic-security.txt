# dynamic-security.txt

Server-wide dynamically created security.txt and optionally signed with OpenPGP key using PHP.

https://domain.tld/security.txt

https://domain.tld/.well-known/security.txt

For now just for Apache.

***Features:***
- All available fields according to [RFC9116](https://www.rfc-editor.org/rfc/rfc9116) can be configured
  - except for **Canonical** which is generated automatically based on visited URL
  - and **Expires** which is generated automatically based on time of visit + 1 year
- Only configured fields will be shown
- Output is signed if a valid key is supplied
- When a website has a local security.txt the script will not be run, so your customers can create their own security.txt

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

### Enable Apache configuration

- Copy /var/www/securitytxt/conf/[apache.conf](securitytxt/conf/apache.conf) to /etc/apache2/conf-available/securitytxt.conf

- Check PHP handler and change if necessary

- Enable securitytxt.conf in Apache

  ```a2enconf securitytxt```

- Reload Apache

  ```systemctl reload apache2```

### Server-wide

- Add this to every website's vhost configuration:

  ```RewriteEngine on```
  
  ```RewriteOptions Inherit```

- If you use a management system like ISPConfig, Plesk etc. than add above to the vhost config that is used when adding or altering a website.

  Resync all websites after.
