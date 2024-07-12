I have included a helper command to generate a key for you:

php artisan jwt:secret

This will update your .env file with something like JWT_SECRET=foobar

It is the key that will be used to sign your tokens. How that happens exactly will depend on the algorithm that you choose to use.
Generate certificate

For generating certificates the command

php artisan jwt:generate-certs

can be used. The .env file will be updated, to use the newly created certificates. 
