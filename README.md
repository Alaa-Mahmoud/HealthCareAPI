# Health Care Center APP
API endpoints to serve a HealthCare center application. 
The Health care center provides medical services with different types through scheduled appointments to patients. 
Patients could browse through thousands of medial services provided by the center and contact any of the health care center’s agents to schedule an appointment for them for the selected services. 
The agent could issue an invoice for the patient for one or multiple services that have been scheduled and provided.
At issuing an invoice the agent could also set a discount which could be a percentage or a flat discount if applicable.
Once an invoice has been issued the patient should receive both an email and an SMS to inform the user that the invoice has been issued and that it’s pending his/her payment. 
The patient could pay the invoice online using any of the following payment providers “PaymentX” or “PaymentY”. 
If the invoice wasn’t paid within 2 days from being issued the patient should receive a reminder through his email to pay the invoice.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

You need to have PHP an composer installed on your machine 

### Installing

A step by step series of examples that tell you how to get a development env running after cloning the project
in your directory.

First you will find .env.example rename it to .env and set your env values
Then to install project dependencies run the following command

```
$ composer install
```

Then generate the project key

```
$ php artisan key:generate
```

We need to migrate the database

```
$ php artisan migrate
```

Then to prepare Passport for use
```
$ php artisan passport:install
```

Then seed sample data to the database

```
$ php artisan db:seed
```
Then generate API documentation (SWAGGER)
```
$ php artisan l5-swagger:generate
```

Then run the server

```
$ php artisan serve
```

And go to http://localhost:8000/api/documentation

Note: 

## agent account
````
email: mark@gmail.com password: 123456
````

## patient accounts
````
email: maria@gmail.com password: 123456 
```` 
````
email: jack@gmail.com  password: 123456 
````
````
email: noha@gmail.com  password: 123456
```` 

That's it.
