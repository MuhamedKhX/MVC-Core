<?php


namespace muhamex\phpmvc\form;


use muhamex\phpmvc\Model;

class Field
{
    public Model $model;
    public string $attribute;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    public function __toString()
    {
        return sprintf('
            <div class="mb-3">
                <label>%s</label>
                <input type="text" name="%s" value="%s" class="form-control%s">
                <div class="invalid-feedback">
                %s
                </div>
            </div>
        ',
        $this->model->labels()[$this->attribute] ?? $this->attribute,
        $this->attribute,
        $this->model->{$this->attribute},
        $this->model->hasError($this->attribute) ? ' is-invalid' : '',
        $this->model->getFirstError($this->attribute)

        );
    }

}