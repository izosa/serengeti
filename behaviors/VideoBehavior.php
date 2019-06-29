<?

use yii\db\BaseActiveRecord;
use \yii\behaviors\AttributeBehavior;
use izosa\serengeti\widgets\google\Youtube;

class VideoBehavior extends AttributeBehavior
{

    public $videoyAttribute = 'video';
    public $value;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => $this->videoyAttribute,
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->videoyAttribute,
            ];
        }
    }

    /**
     * {@inheritdoc}
     *
     * In case, when the [[value]] property is `null`, the value of [[defaultValue]] will be used as the value.
     */
    protected function getValue($event)
    {
        var_dump($this->value);
        var_dump($event);
        exit;

        return Youtube::getIdFromUrl($this->value);

        return parent::getValue($event);
    }

    /**
     * Get default value
     * @param \yii\base\Event $event
     * @return array|mixed
     * @since 2.0.14
     */
    protected function getDefaultValue($event)
    {
        if ($this->defaultValue instanceof \Closure || (is_array($this->defaultValue) && is_callable($this->defaultValue))) {
            return call_user_func($this->defaultValue, $event);
        }

        return $this->defaultValue;
    }


}