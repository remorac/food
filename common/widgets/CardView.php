<?php
namespace common\widgets;

use Yii;
use yii\base\Arrayable;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\i18n\Formatter;

/**
 * DetailView using metronic card
 *
 * For more details and usage information on DetailView, see the [guide article on data widgets](guide:output-data-widgets).
 *
 * @author habiburrahman <remorac.14@gmail.com>
 * @since 2.0
 */
class CardView extends \yii\widgets\DetailView
{
    public $template = '<div class="my-4"><b>{label}</b><br>{value}</div>';
    public $options  = ['class' => 'card px-10 py-6'];

    /**
     * @inherit
     */
    public function run()
    {
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
            $rows[] = $this->renderAttribute($attribute, $i++);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::tag($tag, implode("\n", $rows), $options);
    }
}
