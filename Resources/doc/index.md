Getting Started With IRContactBundle
====================================

## Prerequisites

This version of the bundle requires Symfony 2.3+.

## Installation

1. Download IRContactBundle using composer
2. Enable the bundle
3. Create your Message class
4. Configure the IRContactBundle
5. Import IRContactBundle routing
6. Update your database schema
7. Enable the doctrine extensions

### Step 1: Download IRContactBundle using composer

Add IRContactBundle in your composer.json:

``` js
{
    "require": {
        "informaticrevolution/contact-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update informaticrevolution/contact-bundle
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IR\Bundle\ContactBundle\IRContactBundle(),
    );
}
```

### Step 3: Create your Message class

##### Annotations

``` php
<?php
// src/Acme/ContactBundle/Entity/Message.php

namespace Acme\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\ContactBundle\Model\Message as BaseMessage;

/**
 * @ORM\Entity
 * @ORM\Table(name="acme_message")
 */
class Message extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
```

##### Yaml or Xml

``` php
<?php
// src/Acme/ContactBundle/Entity/Message.php

namespace Acme\ContactBundle\Entity;

use IR\Bundle\ContactBundle\Model\Message as BaseMessage;

/**
 * Message
 */
class Message extends BaseMessage
{
}
```

In YAML:

``` yaml
# src/Acme/ContactBundle/Resources/config/doctrine/Message.orm.yml
Acme\ContactBundle\Entity\Message:
    type:  entity
    table: acme_message
    id:
        id:
            type: integer
            generator:
                strategy: AUTO          
```

In XML:

``` xml
<!-- src/Acme/ContactBundle/Resources/config/doctrine/Message.orm.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                  xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                                      http://doctrine-project.org/schemas/orm/doctrine-mapping.xsd">

    <entity name="Acme\ContactBundle\Entity\Message" table="acme_message">
        <id name="id" type="integer" column="id">
            <generator strategy="AUTO" />
        </id> 
    </entity>
    
</doctrine-mapping>
```

### Step 4: Configure the IRContactBundle

Add the bundle minimum configuration to your `config.yml` file:

``` yaml
# app/config/config.yml
ir_contact:
    db_driver: orm # orm is the only available driver for the moment 
    message_class: Acme\ContactBundle\Entity\Message
```

### Step 5: Import IRContactBundle routing files

Add the following configuration to your `routing.yml` file:

``` yaml
# app/config/routing.yml
ir_contact:
    resource: "@IRContactBundle/Resources/config/routing/contact.xml"
    prefix: /contact

ir_contact_message:
    resource: "@IRContactBundle/Resources/config/routing/message.xml"
    prefix: /admin/messages
```

### Step 6: Update your database schema

Run the following command:

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 7: Enable the doctrine extensions

**a) Enable the stof doctrine extensions bundle in the kernel**

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
    );
}
```

**b) Enable the timestampable extension in your `config.yml` file**

``` yaml
# app/config/config.yml
stof_doctrine_extensions:
    orm:
        default:
            timestampable: true