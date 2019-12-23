# Backend code test

Get started by initialising the project as you would normally.

There are migrations to be run, and also a database seeder. Make sure you run those.

There is an artisan command that has been created to make a user for you to test with (CreateUserCommand).
This creates a user with the credentials: `test@test.com` / `password`

## There are a few tasks that we would like you to complete.

1. Create an endpoint to create an organisation. A few files will need to be completed for this to work.
    - Criteria for completion:
        - Request must be validated.
        - A user must be logged in to complete the request.
        - Organisations should be created with trial period of 30 days.
        - An email should be triggered upon organisation creation that send the logged in user a confirmation. (just a plaintext email with the details is perfect for this test.)
        - The JSON response should include the user inside of the organisation. Half of this has been completed, you will need to create a transformer for the User and include the data that you believe to be relevant.

2. Fix the code that outputs a collection of organisations
    - Use the transformer to return the data (hint: transformCollection)
    - The endpoint should be able to take a http query param of filter, which can be `subbed`, `trial` or `all`. If not included, `all` is the default case.
    - Abstract the controller logic into the service


## Global acceptance criteria

- Code must adhere to PSR12 standards.
- All datetimes returned must be in unix timestamps.
- Code should include docblocks.

## Packages installed.

- Laravel Passport
- Fractal (for transformers)
