<?php
namespace Acme\Shop\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Config;
use Acme\Shop\Models\Category;

class Parentbox extends FormWidgetBase
{
  public function widgetDetails() {
    return [
      'name' => 'Parentbox',
      'description' => 'add parent id',
    ];
  }

  public function prepareVars() {
    $id = $this->model->id;
    $this->vars['categories'] = Category::where('id', '!=', $id)->lists('title', 'id');
    $this->vars['name'] = $this->formField->getName();
    $this->vars['selectedValue'] = $this->getLoadValue();
  }

  public function render() {
    $this->prepareVars();
    return $this->makePartial('widget');
  }
}
