<?php

namespace common\components\extractor;

abstract class DataExtractor {
    public abstract function extract($data, $model);
}
