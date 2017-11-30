Yii2 TimeLine Widget
====================

[![Latest Version](https://img.shields.io/github/tag/mice-tm/yii2-timeline-widget.svg?style=flat-square&label=release)](https://github.com/mice-tm/yii2-timeline-widget/releases)
[![Open Source Love](https://badges.frapsoft.com/os/mit/mit.svg?v=102)](https://github.com/ellerbrock/open-source-badge/)
[![Dependency Status](https://www.versioneye.com/user/projects/5a2025600fb24f0018f8c517/badge.svg?style=flat-square)](https://www.versioneye.com/user/projects/5a2025600fb24f0018f8c517)
[![Total Downloads](https://img.shields.io/packagist/dt/vova07/yii2-imperavi-widget.svg?style=flat-square)](https://packagist.org/packages/vova07/yii2-imperavi-widget)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mice-tm/yii2-timeline-widget "*"
```

or add

```
"mice-tm/yii2-timeline-widget": "*"
```

to the require section of your `composer.json` file.


Usage
-----
Timeline widget expects array of LogModel-like models (micetm\timeline\LogModel).
```php
class LogModel extends Model
{

    public $action;
    public $title,
    public $body;
    public $log_date;
    public $macros;
    public $_id;
    
    public function rules()
    {
        return [
            [['action', 'title'], 'required'],
            [['action', 'title', 'body'], 'string'],
            ['log_date', 'integer'],
            ['macros', 'safe']
        ];
    }

    public function attributes()
    {
        return [
            '_id',
            'action',
            'title',
            'body',
            'macros',
            'log_date',
        ];
    }
    
    public function attributeLabels()
    {
        return [
            '_id' => '#',
            'action' => 'Action',
            'macros' => 'Macros',
            'title' => 'Title',
            'body' => 'Body',
            'log_date' => 'Date',
        ];
    }
}
```

Once the extension is installed, simply use it in your code by  :

```php
<?php
use micetm\timeline\Timeline;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

echo Timeline::widget([
    'items' => $dataProvider->getModels(),
    'eventIcons' => [
        'update' => 'fa-pencil bg-orange',
        'add' => 'fa-pencil bg-orange',
        'create' => 'fa-check bg-green',
    ]
]); ?>

```
