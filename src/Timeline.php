<?php

namespace micetm\timeline;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

class Timeline extends Widget
{
    public $items = [];

    public $eventIcons = [];

    public $startMacros = '{';

    public $endMacros = '}';

    protected $defaultIcons = [
        'update' => 'fa-pencil bg-orange',
        'create' => 'fa-check bg-green',
        'delete' => 'fa-trash bg-red',
        'default' => 'fa-check'
    ];

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->eventIcons = array_merge($this->defaultIcons, $this->eventIcons);
        return $this->renderItems();
    }

    /**
     * Renders tab items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    protected function renderItems()
    {
        $lis = [];
        foreach ($this->items as $model) {
            $nodes = [];
            if (!isset($date) || $date != Yii::$app->formatter->asDate($model->log_date)) {
                $date = Yii::$app->formatter->asDate($model->log_date);
                $lis[] = Html::tag('li', Html::tag('span', $date, ["class" => "bg-blue"]), ["class" => "time-label"]);
            }

            $nodes[] = $this->constructIcon($model->action);
            $timelineItem = [];
            $timelineItem[] = $this->construnctTime($model->log_date);

            if ($model->title) {
                $timelineItem[] = $this->constructHeader($model->title, is_array($model->macros)
                    ? $model->macros
                    : json_decode($model->macros, true));
            }
            if ($model->body) {
                $timelineItem[] = $this->constructBody($model->body, is_array($model->macros)
                    ? $model->macros
                    : json_decode($model->macros, true));
            }
            $nodes[] = Html::tag('div', implode("\n", $timelineItem), ['class' => 'timeline-item']);
            $lis[] = Html::tag('li', implode("\n", $nodes));
        }
        $lis[] = Html::tag('li', Html::tag('i', '', ["class" => "fa fa-clock-o"]));
        return Html::tag('ul', implode("\n", $lis), ['class' => "timeline"]);
    }



    protected function constructIcon($action)
    {
        return Html::tag(
            'i',
            '',
            [
                'class' => 'fa ' . $this->eventIcons[$action] ?? $this->eventIcons['default']
            ]
        );
    }

    protected function construnctTime($time)
    {
        $nodes = [];
        $nodes[] = Html::tag('i', '', ['class' => 'fa fa-clock-o']);
        $nodes[] = Yii::$app->formatter->asTime($time);
        return Html::tag('span', implode("\n", $nodes), ['class' => 'time']);
    }

    protected function constructHeader($title, $macros)
    {
        if (isset($macros['admin_name'])) {
            $macros['admin_name'] = Html::a(
                $macros['admin_name'],
                ['/user/view', 'id' => $macros['admin_id']]
            );
        }
        return Html::tag('h3', $this->replaceMacros($title, $macros), ['class' => 'timeline-header']);
    }

    protected function constructBody($body, $macros)
    {
        return Html::tag('h3', $this->replaceMacros($body, $macros), ['class' => 'timeline-header']);
    }

    protected function replaceMacros($template, $replacement)
    {
        return \Yii::t('timeline', $template, $replacement);
    }
}
