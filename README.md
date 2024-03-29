# 42php

> 42php is the answer to the Ultimate Question of Life, the Universe and Everything, and especially your web projects.
>
> **Douglas Adams**, *maybe*.

42php is a developer oriented CMS. It will be shipped with a lot of prod-ready plugins, ergonomic and highly customizable.

## Alpha warning

As 42php is still under development, and without any production-ready release, use it carefully, and API can change at every moment.

## Requirements

- PHP 5.6

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

## Kanban

A Kanban is available [here](http://taiga.42php.com/project/42php-42php/)
