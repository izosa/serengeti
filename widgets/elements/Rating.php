<?

namespace izosa\serengeti\widgets\elements;

use Yii;
use yii\base\Widget;
use yii\helpers\Json;
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
    
    
    public function init() 
    {
        
        parent::init();

        if ($this->model->rate > 0)
        {
            $stars = ceil($this->model->rate / $this->model->votes) > $this->count ? $this->count : ceil($this->model->rate / $this->model->votes);
        }
        else
        {
            $stars = 0;
        }
        
        RatingAsset::register(Yii::$app->view);
        
        
        $model = $this->model;
        
        Loader::addWidget('rating', [
            'id' => $this->model->id,
            'rate' => $this->model->rate,
            'votes' => $this->model->votes,
            'isVoted' => false,
            'stars' => $stars,
            'label' => $this->label,
            'thankyou' => $this->thankyou,
            'youvoted' => $this->youvoted,
            'count' => $this->count,
            'model' => $model::DIR
        ]);
        
        echo $this->render('rating', [
            'count' => $this->count,
            'votes' => $this->model->votes,
            'stars' => $stars,
            'model' => $this->model,
        ]);
    }
        
    public static function vote($class)
    {
        if(Yii::$app->request->isAjax && isset($_GET['id']) && intval($_GET['id']) > 0 && isset($_GET['rate']) && intval($_GET['rate']) || YII_DEBUG)
        {
            Yii::$app->response->format = 'json';
            
            $id = intval($_GET['id']);
            $rate = isset($_GET['rate']) ? intval($_GET['rate']) : 0;

            $item = $class::find()->where(['id' => $id])->one();

            if ($item !== null) {
                $item->rate+= $rate;
                ++$item->votes;
                $item->save();

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
