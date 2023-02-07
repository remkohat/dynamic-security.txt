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
- Only works for websites which use https
- Output will be signed if a valid key is supplied
- If a website has a local security.txt file present then the script will not run, so your customers can create their own security.txt file

## _Requirements_

- PHP >= 7.4
- PHP-gnupg extension
- GnuPG >= 2.0

## _How To Use_

### Copy

- Copy securitytxt folder to /var/www/

  <sup>(for any other location you need to alter apache.conf or nginx.conf)</sup>

### Edit desired fields in /var/www/securitytxt/conf/[config.php](securitytxt/conf/config.php)

- Fields are explained here:
  
  [https://www.rfc-editor.org/rfc/rfc9116#name-field-definitions](https://www.rfc-editor.org/rfc/rfc9116#name-field-definitions)

### When signing with OpenPGP key

- Create folder /var/www/.gnupg

  ```mkdir /var/www/.gnupg```

- Set folder permissions to Apache user

  ```chown www-data:www-data /var/www/.gnupg```

- The first time you not only need the public key but also the private key.
  
  Uncomment the relevant lines in /var/www/securitytxt/sign/[sign.php](securitytxt/sign/sign.php) and /var/www/securitytxt/conf/[config.php](securitytxt/conf/config.php).
  
  After the first successful run they can be commented again.

### Enable webserver configuration

#### _Apache_

- Copy /var/www/securitytxt/conf/[apache.conf](securitytxt/conf/apache.conf) to /etc/apache2/conf-available/securitytxt.conf
  
  Or create a symlink in /etc/apache2/conf-available
  
  ```ln -s /var/www/securitytxt/conf/apache.conf securitytxt.conf```

- Check PHP handler and change if necessary

- Enable securitytxt.conf in Apache

  ```a2enconf securitytxt```

- Reload Apache

  ```systemctl reload apache2```

#### _Nginx_

- Copy /var/www/securitytxt/conf/[nginx.conf](securitytxt/conf/nginx.conf) to /etc/nginx/snippets/securitytxt.conf
  
  Or create a symlink in /etc/nginx/snippets
  
  ```ln -s /var/www/securitytxt/conf/nginx.conf securitytxt.conf```

- Check PHP handler and change if necessary

- Reload Nginx

  ```systemctl reload nginx```

### Server-wide

- Add below to every website's vhost configuration.

- If you use a management system like ISPConfig, Plesk etc. than add below to the vhost config that is used when adding or altering a website.

  Resync all websites after.

#### _Apache_

  ```RewriteEngine on```
  
  ```RewriteOptions Inherit```

#### _Nginx_

  ```include /etc/nginx/snippets/securitytxt.conf;```

## _Example output_

```
-----BEGIN PGP SIGNED MESSAGE-----
Hash: SHA512

# Canonical URL
Canonical: https://domain.tld/.well-known/security.txt

# Our security address
Contact: https://domain.tld/report-vulnerability
Contact: mailto:security@domain.tld

# Our security policy
Policy: https://domain.tld/policy

# Hall of fame
Acknowledgments: https://domain.tld/hall-of-fame

# Jobs for you
Hiring: https://domain.tld/jobs

# These are the languages we speak
Preferred-Languages: en

# Our OpenPGP key
Encryption: https://domain.tld/public.key
Encryption: openpgp4fpr:BAB0EC5B0A8A52D5F4C9D0E8D5DC1526068283E3

# You shouldn't trust this file, once it has expired (like bad milk)
Expires: 2025-01-01T00:00:00Z

-----BEGIN PGP SIGNATURE-----

iQIzBAEBCgAdFiEEgREAlEyU6YeEspGsbER6wYJfdlUFAmPRjzEACgkQbER6wYJf
dlWSYw//ZwtgU6P1NywSaWUPhidnqXw1in9iRqCo6YOn+oynDb/J9GLR3mD8zEli
LXiYk23PVKgwFDyWfDNY65/Bj81t2+9OpAT22rhswm2sL2tHx8uUB4VZM9R9OShO
SQ8fehKCU9/eTHIVjM/RH/Cn9bcgaZamGKXyPTrMgUnB+koVbRxzOrz7lfmxHgdr
0vJ2nrgtOMQg+hi/w6nNkkC/XO2yGDe41xoxaAAOlxZGk8guZWk2z8llKzNVLP7/
3kTlP9NqHFZ7aZa3Z5TUjUzcYIZtNolicpzamaJdAxNfeTlYpZjT8z0Q4KtBLqop
THDuxA9CAuRTbOYLCBKtcu2wknNX9zGApnqsBdQ1UGzuYvmh2mgGslJNHiYyDCNi
/8e02oOdrNsMCRoYZR8kpwRMuvIEg/O+yprVKmzqLJrBeH+YPv6NmNNX0spyP7Q8
IvonbIzh1skWd8U06VKo7+gLhDGBDiRfD6qQ7Cqd0YhSS4k3/Wz8/ohc/JKaGQhP
BBsCLFPQbOEHpJC+YetXZlw00Wf52vpeRMDked2Y8Pu7c7hz3iubZBNfxGYT/gFU
hbcDZrexjYPLkJTaQrZ9PKnBwazrSNmRvXNMPZ0OJotdcEqHOUgF7+nMA6/qAbJF
5YL4NLvINXwqExlx9ZUCd+nj2SNygl+VzX5zVHz4EUteXJheRvo=
=Dhpc
-----END PGP SIGNATURE-----
```
