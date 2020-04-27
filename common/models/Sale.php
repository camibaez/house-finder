<?php

namespace common\models;

use common\components\access_security\SecureIDBehavior;
use common\components\evaluator\SaleEvaluator;
use Symfony\Component\Console\Helper\FormatterHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\Html;
use yii\i18n\Formatter;

/**
 * This is the model class for table "sale".
 *
 * @property integer $id
 * @property string $price
 * @property string $address
 * @property integer $bedroom
 * @property integer $bathroom
 * @property string $area
 * @property integer $province_id
 * @property integer $municipality_id
 * @property integer $neighborhood_id
 * @property integer $zone_id
 * @property integer $house_type_id
 * @property string $user_username
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $description
 * @property float $rank
 *
 * @property HouseType $houseType
 * @property Municipality $municipality
 * @property Neighborhood $neighborhood
 * @property Province $province
 * @property User $user
 * @property Zone $zone
 * @property SaleExtraField[] $saleExtraFields
 * @property ExtraField[] $extraFields
 * @property string $secureId
 * @property SaleThumbImage thumbnail
 * @property SaleThumbImage[] $images
 */
class Sale extends \yii\db\ActiveRecord
{
    const NEW_SALE_STATE = 0;
    const CHECKED_SALE_STATE = 1;

    const SEEN_SALE_SATE = 1;

    const REQUESTED_NOT = 0;
    const REQUESTED_YES = 1;

    const INACTIVE_STATUS = 0;
    const ACTIVE_STATUS = 1;
    const PARTIAL_STATUS = 2;
    const EXPIRED_STATUS = 4;
    const SALE_TAG_TABLE = 'sale_tag';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            SecureIDBehavior::className(),

            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_username',
                'updatedByAttribute' => 'user_username'
            ]

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'bedroom', 'bathroom', 'province_id', 'municipality_id', 'zone_id', 'house_type_id'], 'required'],
            [['price', 'area'], 'number', 'min' => 0],
            [['bedroom', 'bathroom', 'province_id', 'municipality_id', 'neighborhood_id', 'zone_id', 'house_type_id'], 'integer', 'min' => 0],
            [['address'], 'string', 'max' => 1024],
            [['description'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => Yii::t('app', 'Precio'),
            'address' => Yii::t('app', 'Dirección'),
            'bedroom' => Yii::t('app', 'Cuartos'),
            'bathroom' => Yii::t('app', 'Baños'),
            'area' => Yii::t('app', 'Área'),
            'province_id' => Yii::t("app", 'Provincia'),
            'municipality_id' => Yii::t("app", 'Municipio'),
            'neighborhood_id' => Yii::t("app", 'Barrio'),
            'zone_id' => Yii::t("app", 'Zona'),
            'house_type_id' => Yii::t("app", 'Tipo de Inmueble'),
            'user_username' => Yii::t("app", "User"),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->expiration_status = 0;
            return true;
        } else {
            return false;
        }
    }


    /**
     * Devuelve un arreglo de arreglos que contiene cada uno una Sale (correspondiente al user en cuestion)
     * y un dataProvider con las purchases que han sido requeridas por los compradores para esa sale.
     */
    public static function salesPurchaseMap()
    {
        $userId = Yii::$app->user->id;
        $sales = Sale::find()->where(['user_username' => $userId, 'status' => [Sale::ACTIVE_STATUS, Sale::EXPIRED_STATUS]])->all();
        $salesPurchaseMap = [];
        foreach ($sales as $sale) {
            /*
            $query = (new Query())
                     ->from('purchase')->innerJoin('requested_sales', 'purchase.id = requested_sales.purchase_id')
                     ->where([
                         'sale_id' => $sale->id,
                         'status' => Sale::ACTIVE_STATUS,
                         'requested_sales.state' => Sale::ACTIVE_STATUS
                     ]);


             $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

             $salesPurchaseMap[] = [$sale, $dataProvider];
            */

            $query = (new Query())->select(['first_name'])
                ->from('user')->innerJoin('requested_sales', 'username = buyer_id')
                ->where([
                    'sale_id' => $sale->id,
                    'status' => User::STATUS_ACTIVE,
                    'requested_sales.state' => Sale::ACTIVE_STATUS
                ]);


            $count = $query->count();
            $offset = rand(0, $count - 3);


            $firsts = [];
            foreach ($query->limit(3)->offset($offset)->all() as $buyer) {
                $firsts[] = $buyer['first_name'];
            }
            $others = $count - count($firsts);

            $salesPurchaseMap[] = [$sale, ['firsts' => $firsts, 'others' => $others]];

        }


        return $salesPurchaseMap;

    }

    public static function createdCount($userId)
    {
        return self::find()->where(['user_username' => $userId])->count();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouseType()
    {
        return $this->hasOne(HouseType::className(), ['id' => 'house_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipality()
    {
        return $this->hasOne(Municipality::className(), ['id' => 'municipality_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNeighborhood()
    {
        return $this->hasOne(Neighborhood::className(), ['id' => 'neighborhood_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['username' => 'user_username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'zone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViewImages()
    {
        return $this->hasMany(SaleViewImage::className(), ['sale_id' => 'id']);
    }

    public function getPresentationImage()
    {
        $image = $this->getThumbnail()->one();
        return $image ? $image : null;

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThumbnail()
    {
        return $this->hasOne(SaleThumbImage::className(), ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaleExtraFields()
    {
        return $this->hasMany(SaleExtraField::className(), ['sale_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtraFields()
    {
        return $this->hasMany(ExtraField::className(), ['id' => 'extra_field_id'])->viaTable('sale_extra_field', ['sale_id' => 'id']);
    }

    /** El valor de la columna requested en la tabl purchase_sale de esa venta para la compra dada. Que dice si el usuario quiso
     * ver la informacion de contacto de esa venta.
     * @param $purchaseId
     */
    public function getRequestedState($purchaseId)
    {
        $result = (new Query())->select('requested')->from(PurchaseSale::tableName())->where([
            'sale_id' => $this->id,
            'purchase_id' => $purchaseId
        ])->all();

        if ($result)
            return $result[0]['requested'];

    }

    public function getFullLocation()
    {
        $location = $this->province->name;
        if($this->municipality_id)
            $location .= ", " . $this->municipality->name;
        if($this->neighborhood_id){
            $location .= ", " . $this->neighborhood->name;
        }
        return Html::encode($location);
    }

    /** Devuelve los valores de los tags en un array
     * @return array
     */
    public function getTagsValues(){
        $tags = (new Query())->from(self::SALE_TAG_TABLE)->select(['tag_id'])->where(['sale_id' => $this->id])->indexBy('tag_id')->all();
        return array_keys($tags);
    }

    /** Devuelve una string con los tags separados por coma.
     * @return string
     */
    public function getTagsNames(){
        $tags = (new Query())->from(self::SALE_TAG_TABLE)->select(['tag_id'])->where(['sale_id' => $this->id])->indexBy('tag_id')->all();
        return implode(',', array_keys($tags));
    }

    /** Devuelve el rank relativo con respecto a la compra que esta en el view de purchase_sale_view
     * @param $purchaseId
     */
    public function getRelativeRank($purchaseId, $precision = 1){
        $rank = (new Query())
            ->from(PurchaseSale::MATCHING_SALES_VIEW)
            ->where(['purchase_id' => $purchaseId, 'sale_id' => $this->id])
            ->select(['r_rank'])->scalar();

        return Yii::$app->formatter->asDecimal($rank, 1);
    }

    /**Cambia el estado de la venta para una compra en es pecifico para un usuario determinado.
     * Los estados son (Nueva, Chequeada, etc...)
     *
     * @param $user
     * @param $purchaseId
     * @param $state
     * @throws \yii\db\Exception
     */
    public function changeSalePurchaseStatus($user, $purchaseId, $state)
    {
        Yii::$app->db->createCommand()->update(PurchaseSale::tableName(), ['state' => $state], [
            'user' => $user,
            'sale_id' => $this->id,
            'purchase_id' => $purchaseId
        ])->execute();
    }

    /** Elimina las images enlazadas a una venta
     * @throws \yii\db\Exception
     */
    public function cleanImages()
    {
        Yii::$app->db->createCommand()->delete(SaleThumbImage::tableName(), ['sale_id' => $this->id])->execute();
        Yii::$app->db->createCommand()->delete(SaleViewImage::tableName(), ['sale_id' => $this->id])->execute();
    }

    /** Elimina los archivos de las imagenes enlazadas a una venta
     *
     */
    public function cleanImageFiles()
    {
        $thumb = $this->thumbnail;
        $path = $thumb->getFilePath();
        unlink($path);

        foreach ($this->viewImages as $image) {
            $path = $image->getFilePath();
            unlink($path);
        }


    }

    public function setInactive()
    {
        $this->status = self::INACTIVE_STATUS;
        $this->save();
    }

    public function calculateRank(){
        $this->rank = (new SaleEvaluator())->evaluateSale($this);
    }

    public function updateRank(){
        $this->calculateRank();
        $this->save();
    }

}
