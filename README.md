# Installation

Добавить в kernel

    Evrinoma\PartnerBundle\EvrinomaPartnerBundle::class => ['all' => true],

Добавить в routes

    partner:
        resource: "@EvrinomaPartnerBundle/Resources/config/routes.yml"

Добавить в composer

    composer config repositories.dto vcs https://github.com/evrinoma/DtoBundle.git
    composer config repositories.dto-common vcs https://github.com/evrinoma/DtoCommonBundle.git
    composer config repositories.utils vcs https://github.com/evrinoma/UtilsBundle.git

# Configuration

преопределение штатного класса сущности

    partner:
        db_driver: orm модель данных
        factory: App\Partner\Factory\Partner\Factory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Partner\Entity\Partner сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto: App\Partner\Dto\PartnerDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд партнера 
          query - декоратор mediator запросов партнера
        services:
          pre_validator - переопределение сервиса валидатора партнера
          handler - переопределение сервиса обработчика сущностей
          file_system - переопределение сервиса сохранения файла

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации

    1. API_GET_PARTNER, API_CRITERIA_PARTNER - получение партнера
    2. API_POST_PARTNER - создание партнера
    3. API_PUT_PARTNER -  редактирование партнера

# Статусы:

    создание:
        партнер создан HTTP_CREATED 201
    обновление:
        партнер обновлен HTTP_OK 200
    удаление:
        партнер удален HTTP_ACCEPTED 202
    получение:
        партнер(ы) найдены HTTP_OK 200
    ошибки:
        если партнер не найден PartnerNotFoundException возвращает HTTP_NOT_FOUND 404
        если партнер не уникален UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если партнер не прошел валидацию PartnerInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если партнер не может быть сохранен PartnerCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности partner нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.partner.constraint.property

    evrinoma.partner.constraint.property.custom:
        class: App\Partner\Constraint\Property\Custom
        tags: [ 'evrinoma.partner.constraint.property' ]

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    COMPOSER_NO_DEV=0 composer install

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY