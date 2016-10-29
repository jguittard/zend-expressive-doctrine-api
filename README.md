# Zend Expressive Doctrine API
This project is a skeleton application for building web APIs using Zend Expressive and Doctrine as data persistence layer.

It is (still) a **POC** *(Proof Of Concept)* and is under development.

## Context
The initiative came from Enrico Zimuel when he introduced [Zend Expressive API](https://github.com/ezimuel/zend-expressive-api) not long ago.
Based on this initiative, I decided to take it a step further by adding Doctrine features. Those spikes are aimed to be a playground for Apigility 2.0 release.
See [credits](#credits) for other contributions.

## Getting started

First, you need to use [Composer](http://getcomposer.org) to setup the project. Install dependencies by running the following command:
```sh
$ composer install
```

Upon completion, [Phing](http://phing.info) will be available. Get the list of available tasks by typing:
```sh
$ ./vendor/bin/phing
```

You have to create the database structure. Run the following:
```sh
$ ./vendor/bin/phing create-db
```

## Usage

Start the project by launching the embedded PHP webserver:
```sh
$ composer serve
```
You now have access to endpoints through `http://localhost:8080/api/blog`.
To make the calls, use any HTTP client you like. 

For the sake of this documentation, examples will be requested with [HTTPie](https://github.com/jkbrzt/httpie).

## The Web API example
I chose to demonstrate API CRUD operations through 2 resources: *Blog post* and *authors*.

First things first, let's create an `author`.
```
$ http POST http://localhost:8080/api/authors name=Julien twitter=julienguittard --json
```
Success response of a resource creation is a 201:
```
HTTP/1.1 201 Created
Connection: close
Content-Length: 0
Content-type: text/html; charset=UTF-8
Host: localhost:8080
Location: /api/authors/c2f11204-f9e4-4f87-8ae6-1a17dd729dea
```
*Note that instead of returning the entity representation, `location` header contains the URI from which you can then fetch it.*

Let's try to delete this author now:
```
$ http DELETE http://localhost:8080/api/authors/c2f11204-f9e4-4f87-8ae6-1a17dd729dea
```
Oops...
```
HTTP/1.1 405 Method Not Allowed
Allow: GET
Connection: close
Content-Length: 18
Content-type: text/html; charset=UTF-8
Host: localhost:8080

Method Not Allowed
```
Never mind, let's create a post:
```
$ http POST http://localhost:8080/api/posts title="Lorem ipsum" body="Once upon a time, there was a prince..." author=c2f11204-f9e4-4f87-8ae6-1a17dd729dea --json
```
So far, so good:
```
HTTP/1.1 201 Created
Connection: close
Content-Length: 0
Content-type: text/html; charset=UTF-8
Host: localhost:8080
Location: /api/posts/b454e1ea-06b8-453a-8f70-23cd521283c5
```
Should we want a list of all of them:
```
$ http GET http://localhost:8080/api/posts
```
## What's inside?
