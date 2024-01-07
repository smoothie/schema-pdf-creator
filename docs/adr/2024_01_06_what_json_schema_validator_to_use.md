# What JSON Schema Validator to Use?

* Status: accepted
* Date: 2024-01-06

## Context and Problem Statement

JSON Schema is the vocabulary that helps us keep consistency, validity and interoperability at scale
when working with JSON.

There are a couple of PHP implementations. The question is, which one to choose and how to work with
it?

## Decision Drivers

* Stability
* Maintainability
* Ease of use
* JSON Schema draft independence

## Considered Options

**Out of scope**

- Multi-file support
    - Define schema in multiple files
    - As well as reading from multiple files
    - Those features might get interesting at some point but for now it's not needed

### 1. justinrainbow/json-schema

Use the composer package: `justinrainbow/json-schema`.

Supports: draft-3 and draft-4

* Good, because it works for draft-3 and draft-4
    * Note: for some reason OpenAPI (draft-5) validation works
* Good, because it has quite a simple API and is really nice written
* Good, because it is used by the majority - due to that it is likely it keeps "kinda" maintained
* Bad, because draft-5 and later is not officially supported
* Bad, because we can not convert JSON to an associative array (json_decode)
* Bad, because we need to decode the JSON file before validating
* Bad, because custom context-based messages are hard achievable (but somehow they are)

### 2. ergebnis/json-schema-validator

Use the composer package: `ergebnis/json-schema-validator`.

It wraps `justinrainbow/json-schema` and comes with an own implementation of the validation. So most
arguments from `justinrainbow/json-schema` apply.

* Good, because it does not try to reinvent the wheel
* Good, because it gives a way to interpret a JSON file

### 3. opis/json-schema

Use the composer package: `opis/json-schema`.

Supports: draft-2020-12, draft-2019-09, draft-07 and draft-06

* Good, because quite many ways to change the way things work (e.g. reading schema)
* Good, because it does not reinvent the wheel by supporting draft-3 and draft-4 but aims to support
  later drafts
* Good, because no 3rd party dependencies besides opis
* Bad, because not sure if it is still maintained (last change 2022 and quite some open issues)
* Bad, because newer drafts run into errors which dont make sense (e.g. OpenAPI v3.1 webhook
  example)
    * There is a chance, that I wasn't setting my tests correct up. In that case, it still a bad,
      because hard to tell if stuff was set up correct.
* Bad, because they tried to implement things up on JSON schema, for example mappers.
    * That could be a good thing, when extracted into a separate specification. But in this case it
      kinda adds another load of functionalities to support.

### 4. swaggest/php-json-schema

Use the composer package: `swaggest/php-json-schema`.

Supports: draft-7 draft-6 and draft-4

* Good, because it works
* Interesting, because it comes with ClassStructures, which allows us to import/export things into
  PHP classes
    * Similar approach like opis/json-schema mappers just on a different layer
* Bad, because hard to debug when stuff blows up
    * I did not easily find a way to loop over every error

### 5. Custom Implementation

Build an own JSON-Schema implementation

* Bad, because there are already good implementations

### 6. Define contracts and use a default 3rd party package

Do not heavily lock into a specific package, focus more on domain contracts.

And provide recommendations for a default package.

* Good, because considering the amount of drafts, this seems the way to go.

## Trivia

- OpenAPI uses an extended subset of JSONSchema draft-04

## Decision Outcome

Chosen option: "[6](#6-define-contracts-and-use-a-default-3rd-party-package)"
and "[2](#2-ergebnisjson-schema-validator)"

The main focus in this package is to create a PDF from a schema.

Therefor we want to know that a given data is valid.

But do we need to know, how validation works? I assume no. So it should be good enough to define
contracts and let users specify how the validation works.

## References

* OpenAPI:
    * [v3](https://swagger.io/docs/specification/data-models/keywords/) uses draft-00 (aka
      draft-5)
    * [v2](https://swagger.io/specification/v2/#data-types) uses draft-04
* JSON Schema:
    * [Test Suite](https://github.com/json-schema-org/JSON-Schema-Test-Suite)
    * [List of all drafts](https://json-schema.org/specification-links#published-drafts)

[1]: https://github.com/justinrainbow/json-schema/issues/396
