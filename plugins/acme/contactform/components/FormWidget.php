<?php namespace Acme\ContactForm\Components;

use Cms\Classes\ComponentBase;
use Input;
use Mail;
use Validator;
use ValidationException;
use Flash;
use Backend\Models\User;
use Acme\ContactForm\Models\Application;

class FormWidget extends ComponentBase
{
  public function componentDetails()
  {
      return [
          'name' => 'Контактная форма',
          'description' => 'Контактная форма с сохранением заявок'
      ];
  }

  public function defineProperties()
  {
      return [
          'formType' => [
              'title'             => 'Внешний вид',
              'type'              => 'dropdown',
              'default'           => 'slider',
              'placeholder' => 'Выберите тип',
              'options'     => ['first'=>'Форма главная', 'second'=>'Форма низ', 'third'=>'Форма модал']
          ]
      ];
  }

  public function onRender()
  {
      $view = $this->property('formType');
      if($view == 'second') {
          return $this->renderPartial('@_block.htm');
      }
      if($view == 'third') {
        return $this->renderPartial('@_modal.htm');
    }
   }

  public function getUserMail() {

    return User::where('is_superuser', 1)->value('email');

  }

  public function onSend()
  {

    $rules = [
      'user_name'  => 'required|min:3|max:50',
      'user_phone' => 'required|min:5|max:50',
      'user_mail'  => 'email'
    ];

    $messages = [
      'required' => 'Поле обязательно к заполнению!',
      'min'      => 'Минимум :min символов!',
      'max'      => 'Максимум :max символов!',
      'email'    => 'Некорректный e-mail'
    ];

    $validator = Validator::make(Input::all(), $rules, $messages);
    //если не прошло валидацию
    if ($validator->fails()) {

      throw new ValidationException($validator);

    } else {
      //переменные
      $vars = [
        'user_name' => Input::get('user_name'),
        'user_phone' => Input::get('user_phone'),
        'user_mail' => Input::get('user_mail'),
        'user_message' => Input::get('user_message'),
      ];

      //вставка в базу данных
      $query = new Application();
      $query->user_name = Input::get('user_name');
      $query->user_phone = Input::get('user_phone');
      $query->user_mail = Input::get('user_mail');
      $query->user_message = Input::get('user_message');
      $query->user_ip = $_SERVER["REMOTE_ADDR"];
      $query->user_status = 1;
      $query->created_at = time();
      $query->save();

      //отправка на почту
      Mail::send('acme.contactform::mail.message', $vars, function($message) {

          $message->to($this->getUserMail(), 'Admin Person');
          $message->subject('Сообщение с сайта');

      });

      if($query) {
        Flash::success('Сообщение успешно отправлено!');
      } else {
        Flash::error('Произошла ошибка!');
      }

    }

  }

}