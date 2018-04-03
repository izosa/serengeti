<?
namespace izosa\serengeti\data;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use InvalidArgumentException;

class CrudItem extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = 'search';
    const SCENARIO_CRUD = 'crud';

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    // <editor-fold defaultstate="collapsed" desc="Get">

    /**
     * Return model by id
     * @param int $id
     * @param array $conditions
     * @return CrudItem|null
     * @throws NotFoundHttpException
     */
    public static function get(int $id,array $conditions = [])
    {
        $query = self::find()->where(['id' => $id]);
        $conditions['id'] = $id;
        $query->where($conditions);
        $item = $query->one();

        if ($item !== null) {
            return $item;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Return all model
     * @return array
     */
    public static function all(array $conditions)
    {
        $query = self::find();
        if(!empty($conditions)){
            $query->where($conditions);
        }

        return $query->all();
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Tools">

    /**
     * Convert post array to list of objects
     * @param $model ActiveRecord
     * @return array
     * @throws \ReflectionException
     */
    public static function postToObjects($model){
        $key = self::shortClassName($model);
        $class = $model::className();
        $items = Yii::$app->request->post($key);

        $list = [];

        if(!empty($items)){
            $keys = array_keys($items);
            $count = count($items[$keys[0]]);

            if(ArrayHelper::isAssociative($items[$keys[0]])){

                $innerKeys = array_keys($items[$keys[0]]);

                foreach ($innerKeys as $innerKey){
                    $item = new $class;

                    for ($i = 0; $i < count($keys); $i++){
                        $item->{$keys[$i]} = isset($items[$keys[$i]][$innerKey]) ? $items[$keys[$i]][$innerKey] : '';
                    }

                    $list[] = $item;
                }
            } else {
                for ($i = 0; $i < $count; $i++){
                    $item = new $class();

                    foreach ($keys as $key){
                        $item->{$key} = isset($items[$key][$i]) ? $items[$key][$i] : '';
                    }
                    $list[] = $item;
                }
            }

        }

        return $list;
    }

    /**
     * Return Model short name
     * @param $model
     * @return string
     * @throws \ReflectionException
     */
    public static function shortClassName($model, $lowercase = true){

        if(is_object($model)){
            $name =  (new \ReflectionClass($model))->getShortName();
        } else if(is_string($model)){
            $name = basename(str_replace('\\','/',$model));
        } else{
            throw new InvalidArgumentException();
        }

        return $lowercase ? strtolower($name) : $name;
    }

    // </editor-fold>

}