<?php namespace Acme\ContactForm\Components;

use Cms\Classes\ComponentBase;
use Input;
use Validator;
use ValidationException;
use Flash;
use Acme\ContactForm\Models\Subscribe;

class SubscribeForm extends ComponentBase
{
  public function componentDetails()
  {
      return [
          'name' => 'Форма подписки',
          'description' => 'Форма подписки для сайта'
      ];
  }

  public function onSubscribe()
  {

    $rules = [
      'subscribe_mail'  => 'required|email|unique:acme_contactform_subscribe',
    ];

    $messages = [
      'required'  => 'Укажите e-mail!',
      'email'     => 'Некорректный e-mail!',
      'unique'    => 'Данный e-mail уже подписан!'
    ];

    $validator = Validator::make(Input::all(), $rules, $messages);
    //если не прошло валидацию
    if ($validator->fails()) {

      throw new ValidationException($validator);

    } else {
      //переменные

      //вставка в базу данных
      $query = new Subscribe();
      $query->subscribe_mail = Input::get('subscribe_mail');
      $query->created_at = time();
      $query->save();
      
      if($query) {
        Flash::success('Вы успешно подписаны!');
      } else {
        Flash::error('Произошла ошибка!');
      }
      
    }
    
  }

}