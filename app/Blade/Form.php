<?php

namespace App\Blade;

use function old;

// TODO 待確認
class Form
{
    private $cacheModel;

    public function setModel($model): self
    {
        $this->cacheModel = $model;
        return $this;
    }

    public function bt4CssIsValidOrNot(string $attributeName)
    {
        return empty($this->getInput($attributeName)) ? "" : "is-valid";
    }

    public function getInput( $firstAttributeName)
    {
        $model = $this->cacheModel();
        $firstAttribute = empty(old($firstAttributeName)) ? $model->$firstAttributeName : old($firstAttributeName);

        return $firstAttribute;
    }

    public function getModelValueFromEditForm($firstAttributeName, $secondAttribute = null, $model = null): array
    {
        $model = $this->cacheModel($model);
        $firstAttribute = empty(old($firstAttributeName)) ? $model->$firstAttributeName : old($firstAttributeName);

        if (empty($secondAttribute)) {
            return $firstAttribute;
        }

        if ($firstAttribute) {
            $secondAttribute = empty(old($secondAttribute)) ? $model->$secondAttribute : old($secondAttribute);
        } else {
            $secondAttribute = "";
        }
        return [$firstAttribute, $secondAttribute];
    }

    private function cacheModel($model = null)
    {
        if (empty($model)) {
            return $this->cacheModel;
        }

        $this->cacheModel = $model;
        return $this->cacheModel;
    }
}
