<?

namespace izosa\serengeti\widgets\elements;

use izosa\serengeti\data\CrudItem;
use izosa\serengeti\site\Utility;
use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\web\Response;
use izosa\serengeti\widgets\helpers\Loader;

/**
 * Rating extension
 */
class Rating extends Widget
{
    public $model;
    public $message;
    public $label = 'stars';
    public $thankyou = 'Thanks for voting!';
    public $youvoted = 'You already voted!';
    public $count = 5;

    private $_stars = 0;

    /**
     * @inheritdoc
     */
    public function init() 
    {
        parent::init();

        if ($this->model->rate > 0) {
            $this->_stars = ceil($this->model->rate / $this->model->votes) > $this->count ? $this->count : ceil($this->model->rate / $this->model->votes);
        } else {
            $this->_stars = 0;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        RatingAsset::register(Yii::$app->view);

        Loader::addWidget('rating', [
            'id' => $this->model->id,
            'rate' => $this->model->rate,
            'votes' => $this->model->votes,
            'isVoted' => false,
            'stars' => $this->_stars,
            'label' => $this->label,
            'thankyou' => $this->thankyou,
            'youvoted' => $this->youvoted,
            'count' => $this->count,
            'model' => CrudItem::shortClassName($this->model),
        ]);

        return  $this->render('rating', [
            'count' => $this->count,
            'votes' => $this->model->votes,
            'stars' => $this->_stars,
            'model' => $this->model,
        ]);
    }

    /**
     * Create new vote
     * @param $class
     * @return mixed
     */
    public static function vote($class)
    {
        $id = Yii::$app->request->get('id', '');
        $rate = intval(Yii::$app->request->get('rate', 0));

        if((Yii::$app->request->isAjax && !empty($id) && !empty($rate)) || YII_DEBUG)
        {
            Yii::$app->response->format = 'json';

            $item = $class::findOne($id);

            if (!is_null($item)) {
                $item->rate+= $rate;
                ++$item->votes;
                $item->save();

                Yii::$app->response->format = Response::FORMAT_JSON;

                return Json::encode([
                    'votes' => $item->votes,
                    'rate' => $item->rate,
                    'stars' => ceil($item->rate / $item->votes)
                ]);
            }
        }
        
        Yii::$app->end();
    }

    /**
     * Populate rating
     * @param $item
     * @return mixed
     */
    public static function populate($item)
    {
        $loop = rand(1, 10);
        $sum = 0;

        for ($i = 0; $i < $loop; $i++) {
            $sum = $sum + rand(3, 5);
        }

        $item->rate = $sum;
        $item->votes = $loop;
        return $item;
    }
    
}
