# 42php

42php is a developer oriented CMS. It will be shipped with a lot of prod-ready plugins, ergonomic and highly customizable.

## Install

- Clone the repository.
```bash
git clone --recursive https://github.com/42php/42php.git
```
- Configure database in the `config/global.json`.
- If you use SQL databases, you can install base tables :
```bash
cd scripts; php cli.php install/PDO/tables
```
- Ready to use !

## Documentation

Documentation is code-generated via PHP Documentor, and available at [docs.42php.com](http://docs.42php.com).
