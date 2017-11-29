<?php

namespace micetm\timeline;


use yii\base\Model;

class LogModel extends Model
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action', 'title'], 'required'],
            [['action', 'title', 'body'], 'string'],
            ['log_date', 'integer'],
            ['macros', 'safe']
        ];
    }
    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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