<?php

namespace common\models;

use backend\models\ConfigurationModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * HouseSearch represents the model behind the search form about `common\models\House`.
 */
class HouseSearch extends House {

    static $EXLCUDE = ['la', 'las', 'el', 'los', 'del', 'de'];
    static $PRICE_RANK = [];
    static $CONFIGURATION_MODEL = [];
    public $priceMin;
    public $priceMax;
    public $terms;
    public $price;
    public $imagesOnly;
    public $date = 0;
    public $sites = ["Revolico", "Cubisima", 'Detras de la Fachada', "Ofertas"];
    static $MAGIC_ORDER = 1, $HIGH_PRICE_ORDER = 2, $LOW_PRICE_ORDER = 3,  $DATE_ORDER = 4;
    public $order = 1;

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'searches';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = [
            [['priceMin', 'priceMax'], 'number', 'min' => 0],
            ['terms', 'string', 'max' => 1024],
            [['sites', 'imagesOnly', 'order'], 'safe'],
            ['date', 'in', 'range' => [0, 1, 2, 3, 4]],
        ];
        return $rules;
    }

    /**
     * Limpa los terminos quitandole todos los elementos indeseables.
     * (Comas, puntos, espacios, etc)
     * @return type
     */
    public function getCleanTerms() {
        $terms = strtolower($this->terms);
        $terms = " " . $terms . " ";

        $unecesaryWordsPreg = implode('|', static::$EXLCUDE);
        $regex = '/\s(' . $unecesaryWordsPreg . ')\s/';
        $terms = preg_replace($regex, "", $terms);
        $terms = preg_replace("/(,|\.)/", " ", $terms);

        $terms = preg_replace('/\s+/', " ", $terms);
        $terms = trim($terms);
        return $terms;
    }

    /**
     * Transforma la cadena de texto con los terminos de las locaciones convirtiendolos
     * en elementos de un array
     * @param string $terms
     * @return array
     */
    public function getNormalizedLocations($terms) {
        if ($terms) {
            $terms = explode(' ', $terms);
            return $terms;
        }
        return null;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $asArray = true) {
        $query = House::find();
        if ($asArray)
            $query = (new Query())->from("house_locations");


        $this->load($params);

        if (!$this->validate()) {
            $query->where("1=0");
            return new ActiveDataProvider([
                'query' => $query,
            ]);
        }

        $this->loadGlobalValues();

        $cleanTerms = $this->cleanTerms;
        $locations = $this->getNormalizedLocations($cleanTerms);

        $rankFunctions = [];
        $this->locationsSetup($locations, $rankFunctions);
        $this->priceSetup($query, $rankFunctions);
        $this->dateSetup($rankFunctions);
        $selectParameters = ['id', 'price', 'created_at', 'description', 'rank', 'url', 'title', 'site_id', "thumb"];
        if ($rankFunctions)
            $selectParameters[] = "(" . implode("+", $rankFunctions) . " + rank) AS r_rank";
        else
            $rankFunctions[] = "rank AS r_rank";

        $query->select($selectParameters);




        $query->where(['status' => House::SAFE_STATUS]);
        $query->andFilterWhere(['>=', 'price', $this->priceMin]);
        $query->andFilterWhere(['<=', 'price', $this->priceMax]);


        $this->loadSitesList();
        if ($this->checkSitesDiff())
            $query->andWhere(['site_id' => $this->sites]);

        if ($this->imagesOnly) {
            $imageQuery = (new Query())->from("sale_image")->where("sale_id = house_locations.id");
            $query->andWhere(['exists', $imageQuery]);
        }

        if ($this->date != 0) {
            $dayPeriods = [
                1 => 2,
                2 => 7,
                3 => 31,
                4 => 365
            ];
            $dayPeriod = $dayPeriods[$this->date];
            $query->andWhere("DATEDIFF(NOW(), FROM_UNIXTIME(created_at)) <= $dayPeriod");
        }

        /*
          $query->andFilterWhere(["OR",
          ['or like', 'title', $locations],
          ['like', 'description', $locations]
          ]);
         * 
         */
        if ($locations) {
            $query->andWhere([
                'OR',
                [
                    "AND",
                    ["IN", 'site_id', ['Revolico', 'Ofertas']],
                    ["OR",
                        ['or like', 'title', $locations],
                        ['like', 'description', $locations]
                    ]
                ],
                [
                    "AND",
                    ["NOT IN", 'site_id', ['Revolico', 'Ofertas']],
                    [
                        'or',
                        ['or like', 'p_pattern', $locations],
                        ['or like', 'm_pattern', $locations],
                        ['or like', 'n_name', $locations],
                    ]
                ]
            ]);
        }

        switch ($this->order) {
            case static::$MAGIC_ORDER:
                $query->orderBy('r_rank DESC');
                break;
            case static::$LOW_PRICE_ORDER:
                $query->orderBy('price ASC');
                break;
            case static::$HIGH_PRICE_ORDER:
                $query->orderBy('price DESC');
                break;

            case static::$DATE_ORDER:
                $query->orderBy('created_at DESC');
                break;
        }
        if (!$this->order) {
            
        }


        /*
          $revQuery = (new Query())->create($query);

          $revQuery->andWhere(['site_id' => ['Revolico', "Ofertas"]]);
          $revQuery->andFilterWhere(["OR",
          ['or like', 'title', $locations],
          ['like', 'description', $locations]
          ]);
          $revQuery->limit(16);

          $query->andWhere(['NOT IN', 'site_id', ['Revolico', "Ofertas"]]);
          $query->andFilterWhere([
          'or',
          ['or like', 'province.name', $locations],
          ['or like', 'municipality.name', $locations],
          ['or like', 'neighborhood.name', $locations],
          ]);

          $query = $query->union($revQuery);

         */

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $dataProvider;
    }

    protected function locationsSetup($locations, &$rankFunctions) {

        /*
          if(count($locations) > 0){
          $locationsRegex = "(".implode('|', $locations).")"."+";
          $locationsFunction = Functions::locationsNameRank(['province.name', 'municipality.name', 'neighborhood.name', "'$locationsRegex'"]);
          $rankFunctions[] = $locationsFunction;
          }
         * 
         */
        if ($locations) {
            $rankFunctions[] = Functions::calcTermsRank($locations);
        }
    }

    protected function priceSetup($query, &$rankFunctions) {
        $priceMin = $this->priceMin > 0 ? $this->priceMin : static::getPriceRange()['min_price'];
        $priceMax = $this->priceMax > 0 ? $this->priceMax : static::getPriceRange()['max_price'] * 0.20;

        $priceFunction = Functions::priceRank(['price', $priceMin, $priceMax]);
        $rankFunctions [] = $priceFunction;
    }

    protected function dateSetup(&$rankFunctions) {
        $dateFunction = Functions::dateRank(["created_at"]);
        $rankFunctions[] = $dateFunction;
    }

    /**
     * Carga valores globales en el servidor mysql.
     * - coeficiente de evaluacion relativa del precio
     * - valor pivote del precio.
     */
    public function loadGlobalValues() {
        if (!static::$CONFIGURATION_MODEL) {
            self::$CONFIGURATION_MODEL = ConfigurationModel::findOne(['id' => 'main']);
        }
        $configModel = self::$CONFIGURATION_MODEL;
        $globalVariables = [
            '@price_pivot' . ":=" . $configModel->price_pivot,
            '@r_price' . ":=" . $configModel->r_price,
            '@r_date' . ":=" . $configModel->r_date
        ];
        $command = "SET " . implode(",", $globalVariables);

        Yii::$app->db->createCommand($command)->execute();
    }

    /**
     * Almacena en la variable $PRICE_RANK el rango de precios de las casas.
     * @return array
     */
    public static function getPriceRange() {
        if (!self::$PRICE_RANK) {
            self::$PRICE_RANK = Yii::$app->db->createCommand("SELECT MIN(price) AS min_price, MAX(price) AS max_price FROM house WHERE status = " . House::SAFE_STATUS)->queryOne();
        }
        return self::$PRICE_RANK;
    }

    /**
     * Devuelve un arreglo con los 
     * @return type
     */
    public static function sitesMap() {
        return [
            "Revolico" => "Revolico",
            "Detras de la Fachada" => "DetrasDeLaFachada",
            "Cubisima" => "Cubisima",
            "Ofertas" => "Ofertas",
        ];
    }

    public static function datesMap() {
        return[
            0 => "Cualquier fecha",
            1 => "Hoy",
            2 => "Una semana",
            3 => "Un mes",
            4 => "Un año"
        ];
    }

    /**
     * Calcula la diferencia entre la lista de sitios posible y la que se recibio en el pedido.
     * @return type
     */
    public function checkSitesDiff() {
        $sitesMap = array_keys(self::sitesMap());
        return array_diff($sitesMap, $this->sites);
    }

    /**
     * Carga la lista de sitios posibles en caso que los sitios pedidos este en null
     */
    public function loadSitesList() {
        if (!$this->sites) {
            $this->sites = array_keys(self::sitesMap());
            return;
        }
    }

    public function saveSearch() {
        \Yii::$app->db->createCommand()->insert('searches', [
            'terms' => $this->terms,
            'price_min' => $this->priceMin,
            'price_max' => $this->priceMax,
            'images_only' => $this->imagesOnly,
            'sites' => implode(",", $this->sites),
            'created_at' => time(),
            'hash' => md5($this->priceMin . $this->priceMax . $this->terms . $this->imagesOnly . implode(",", $this->sites))
        ])->execute();
    }

}
