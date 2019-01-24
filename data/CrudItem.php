<?
namespace izosa\serengeti\data;

use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use InvalidArgumentException;
use yii\helpers\Url;

/**
 * Class CrudItem
 * @package izosa\serengeti\data
 * @version 1.0
 *
 * @property string $modelName
 * @property string $modelType
 *
 * @property string $createdDateTime
 * @property string $updatedDateTime
 * @property User $creator
 * @property User $editor
 */
class CrudItem extends \yii\db\ActiveRecord
{
    const SCENARIO_SEARCH = 'search';
    const SCENARIO_CRUD = 'crud';

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;


    const ACTION_CREATE     = 'create';
    const ACTION_UPDATE     = 'update';
    const ACTION_STATUS     = 'status';
    const ACTION_DELETE     = 'delete';
    const ACTION_UP         = 'up';
    const ACTION_DOWN       = 'down';
    const ACTION_DOWNLOAD   = 'download';
    const ACTION_UPLOAD     = 'upload';

    const BEHAVIOR_TIMESTAMP_FORMAT = 'Y-m-d H:i';

    static $modelPrefix = '';
    static $icon = 'file-o';

    private $_modelName = null;
    private $_modelType = null;

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

    // <editor-fold defaultstate="collapsed" desc="Display Behaviors">

    /**
     * Get Created DateTime
     * @param $format
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCreatedDateTime($format = self::BEHAVIOR_TIMESTAMP_FORMAT){
        return Yii::$app->formatter->asDatetime($this->created_at,$format);
    }

    /**
     * Get Updated DateTime
     * @param $format
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getUpdatedDateTime($format = self::BEHAVIOR_TIMESTAMP_FORMAT){
        return Yii::$app->formatter->asDatetime($this->updated_at,$format);
    }

    /**
     * Return User Creator
     * @return \yii\db\ActiveQuery
     */
    public function getCreator(){
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Return User Editor
     * @return \yii\db\ActiveQuery
     */
    public function getEditor(){
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    // </editor-fold>

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
    public static function all(array $conditions = [], array $order = [],int $limit = 0)
    {
        $query = self::find();
        if(!empty($conditions)){
            $query->where($conditions);
        }

        if(!empty($order)){
            $query->orderBy($order);
        }

        if($limit != 0){
            $query->limit($limit);
        }

        return $query->all();
    }

    /**
     * Return models number
     * @return array
     */
    public static function count(array $conditions = [])
    {
        $query = self::find();
        if(!empty($conditions)){
            $query->where($conditions);
        }

        return $query->count();
    }


    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Url">

    /**
     * Return URL for Dashboard by action
     * @param $action string
     * @return string
     */
    public function getURLDashboard($action = 'update')
    {
        return Url::to('/'.$this->modelType.'/'.$action.'/'.$this->id,true);
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="POST Tools">

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
     * Return upload Files
     * @param bool $errorReport
     */
    public static function getUploadFiles($errorReport = false)
    {
        $files = [];


        // get FILE parameters
        if (count($_FILES) > 0) {
            foreach (array_keys($_FILES) as $variableName) {


                if (is_array($_FILES[$variableName]['name'])) {
                    foreach ($_FILES[$variableName]['name'] as $key => $value) {
                        if ($_FILES[$variableName]['error'][$key] == 0 || $errorReport) {
                            $files[$variableName][$key]['name'] = $_FILES[$variableName]['name'][$key];
                            $files[$variableName][$key]['type'] = $_FILES[$variableName]['type'][$key];
                            $files[$variableName][$key]['tmp_name'] = $_FILES[$variableName]['tmp_name'][$key];
                            $files[$variableName][$key]['error'] = $_FILES[$variableName]['error'][$key];
                            $files[$variableName][$key]['size'] = $_FILES[$variableName]['size'][$key];
                        }
                    }
                } else {


                    var_dump($variableName);


                    $files[$variableName]['name'] = $_FILES[$variableName]['name'];
                    $files[$variableName]['tmp_name'] = $_FILES[$variableName]['tmp_name'];
                    $files[$variableName]['error'] = $_FILES[$variableName]['error'];
                    $files[$variableName]['size'] = $_FILES[$variableName]['size'];
                }
            }
        }

        return $files;
    }

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Class / Model (Name|Type)">

    /**
     * Return Class Base name
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

    /**
     * Return Model Name
     * @return string
     */
    public function getModelName(){

        if(is_null($this->_modelName)){
            $this->_modelName = self::shortClassName($this,false);
        }

        return $this->_modelName;
    }

    /**
     * Return Model Type
     * @return string
     */
    public function getModelType(){

        if(is_null($this->_modelType)){
            $this->_modelType = strtolower($this->getModelName());
        }

        return $this->_modelType;
    }

    // </editor-fold>

}