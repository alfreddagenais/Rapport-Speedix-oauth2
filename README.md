# Rapport Speedix - OAuth2 - Library

Hello and welcome to the Rapport-Speedix-oauth2 Library! 👋

---

## About This Project 🌟

This project was born out of a [personal need](https://rapportspeedix.com) and a gap I noticed in the Laravel community. As a developer working with Laravel and Laravel Passport, I found myself in search of a simple, straightforward solution for implementing OAuth2 connections. To my surprise, such a solution was hard to come by. 🤔

That's when I decided to take matters into my own hands. 💡 The goal was clear: to create something that was not only useful for my own needs but also beneficial for the broader Laravel community. I wanted to build a tool that was easy to use, simple to integrate, and effective in managing OAuth2 authentication.

The result? The Rapport-Speedix-oauth2 Library - a warm contribution to the Laravel ecosystem, aimed at simplifying the OAuth2 integration process. 🚀

This project is more than just code. It's a testament to the power of community-driven development. By sharing this library, I hope to help fellow developers easily test and implement OAuth2 connections in their Laravel applications, saving them time and hassle. 🛠️

I believe in the power of open-source software and the magic that happens when we collaborate and share knowledge. So, dive in, explore the library, and let's make our Laravel journey more secure and efficient together! 🌍

Happy coding! 😊

---

## Introduction

The Rapport-Speedix-oauth2 Library is a streamlined solution for integrating OAuth2 authentication in [Laravel](https://laravel.com) applications. Utilizing [Laravel Passport](https://laravel.com/docs/10.x/passport), this library simplifies the process of securing API endpoints with robust OAuth2 standards. It's designed for developers seeking an efficient and secure way to implement API authentication in their Laravel applications.

---

## Features

- **Easy Integration**: Seamlessly integrates with Laravel 10, offering a straightforward setup process.
- **Laravel Passport Compatibility**: Fully compatible with the latest Laravel Passport version, ensuring up-to-date security practices.
- **Secure Authentication**: Implements OAuth2 standards to provide a secure authentication layer for your APIs.
- **Customizable**: Offers flexibility to customize authentication flows to suit your application's needs.

---

## Installation

```bash
docker-compose -f docker-compose.yml up -d

docker-compose -f docker-compose.yml build --no-cache
```

### Env file `.env.example`

Copy `.env.example` to `.env`. Edit the configuration you need

### Laravel Passport

Please install [Laravel Passport](https://laravel.com/docs/10.x/passport#installation) before.

Don't forget to generated the [keys](https://laravel.com/docs/10.x/passport#deploying-passport) before use the passport : `php artisan passport:keys`

### Laravel Table `oauth_clients`

For the `grant_type` = `authorization_code` for me whe need :

- `personal_access_client = 0`;
- `password_client = 0`;

This is an example of the sql insert

```sql
INSERT INTO `oauth_clients` (`user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`)
VALUES
  (NULL, 'Test OAuth2 - authorization_code', 'k3pl46ix....5o7yvq2', 'users', 'http://localhost:9030/signin.php', 0, 0, 0, NOW(), NOW());
```

---

## Usage

- Run the container and go to `index.php`
- try `Sign-In` or `Sign-In, and get code Only`

For the `code` only is for tool to help to build an API Client like [Bruno](https://www.usebruno.com) or [Postman](https://www.postman.com/)

### API Client with `code`

```bash
curl --request POST \
  --url https://laravel.local/oauth/token \
  --data code=def50200fa43e....8 \
  --data grant_type=authorization_code \
  --data 'client_id=2' \
  --data 'redirect_uri=http://localhost:9030/signin.php' \
  --data 'client_secret=k3pl46ix....5o7yvq2'
```

Response will be

```json
{
  "token_type": "Bearer",
  "expires_in": 31622400,
  "access_token": "eyJ0eXA.......jtw7mzdrnI",
  "refresh_token": "def502f.......1345dfbbd9b"
}
```

Now you can use this with [Bruno](https://www.usebruno.com) in the [Script Tab](https://docs.usebruno.com/scripting/introduction.html):

```js
if (res.body.access_token && res.body.refresh_token) {
  bru.setEnvVar("oauthAccessToken", res.body.access_token);
  bru.setEnvVar("oauthRefreshToken", res.body.refresh_token);
}
```

And now you can use this for your API request as normal

```bash
curl --request POST \
  --url https://laravel.local/api/oauth/test
  -H "Accept: application/json"
  -H "Authorization: Bearer eyJ0eXA.......jtw7mzdrnI"
```

---

## Contributing

Contributions are welcome! Please feel free to submit pull requests or open issues to improve the library.

---

## Disclaimer

This package is a wrapper for [Laravel Passport](https://laravel.com/docs/10.x/passport) and base on [php-oauth2-example
](https://github.com/XeroAPI/php-oauth2-example)

### Others links for documentation

```text
https://oauth2-client.thephpleague.com/usage/

https://gist.github.com/asika32764/b204ff4799d577fd4eef

https://github.com/nursit/php-oauth2-client
```

---

## License

MIT
