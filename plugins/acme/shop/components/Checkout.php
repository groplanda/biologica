<?php
namespace Acme\Shop\Components;

use Cms\Classes\ComponentBase;
use Input;
use Mail;
use Validator;
use ValidationException;
use Flash;
use Acme\Shop\Models\Order;
use Acme\Shop\Models\Product;
use Backend\Models\User;
use YooKassa\Client;

class Checkout extends ComponentBase {
  public function componentDetails()
  {
    return [
      'name' => 'Оформление заказа',
      'description' => 'Виджет оформления заказа'
    ];
  }

  // получение email админа
  public function getUserMail()
  {
    return User::where('is_superuser', 1)->value('email');
  }
  public function onRun()
  {

  }

  public function onCheckout()
  {
    $rules = [
      'user_name'  => 'required|min:3',
      'user_phone' => 'required|min:5',
      'user_email'  => 'email',
      'user_comment' => 'max:200'
    ];

    $messages = [
      'required' => 'Поле обязательно к заполнению!',
      'email'    => 'E-mail имеет неверный формат!',
      'min'      => 'Минимум :min символов!',
      'max'      => 'Максимум :min символов!',
    ];

    $validator = Validator::make(Input::all(), $rules, $messages);

    if ($validator->fails()) { //если не прошло валидацию
      throw new ValidationException($validator);
    } else {
      //переменные
      $allProducts = json_decode($this->convertString(Input::get('products')));
      $ids = $this->getProductsIds($allProducts);
      $files = $this->getFilesPath($ids);
      $time = date('m/d/Y H:i:s', time());
      $ip = $_SERVER['REMOTE_ADDR'];

      if(Input::get('user_payment_method') === 'online') {
        $client = new Client();
        $client->setAuth(env('SHOP_ID'), env('KASSA_KEY'));
        $payment = $client->createPayment(
            array(
                'amount' => array(
                    'value' => 100.0,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => 'https://moon.bardinteam.ru',
                ),
                'capture' => true,
                'description' => 'Заказ - '.$time,
            ),
            uniqid('', true)
        );
      }

      /*$vars = [
        'user_name' => Input::get('user_name'),
        'user_phone' => Input::get('user_phone'),
        'user_email' => Input::get('user_email'),
        'user_address' => Input::get('user_address'),
        'user_comment' => Input::get('user_comment'),
        'user_payment_method' => Input::get('user_payment_method'),
        'products' => $allProducts,
        'order'=> 'Заказ - '.$time,
        'attachments' => $files,
      ];
      //вставка в базу данных
      $order = new Order;
      $order->name = $vars['order'];
      $order->ip = $ip;
      $order->status = 'new';
      $order->user_name = $vars['user_name'];
      $order->user_phone = $vars['user_phone'];
      $order->user_email = $vars['user_email'];
      $order->user_address = $vars['user_address'];
      $order->user_comment = $vars['user_comment'];
      $order->user_payment_method = $vars['user_payment_method'];
      $order->products = $vars['products'];
      $query = $order->save();
      //отправка на почту
      Mail::send('acme.shop::mail.message', $vars, function($message) {
        $message->to($this->getUserMail(), 'Admin Person');
        $message->subject('Новый заказ с сайта');
      });
      //если указали почту
      if(isset($vars['user_email']) && !empty($vars['user_email'])) {
        Mail::send('acme.shop::mail.order', $vars, function($message) use ($vars) {
          $message->to(trim(Input::get('user_email')), 'Admin Person');
          $message->subject('Заказ - '.date('m/d/Y H:i:s', time()));
          if(!empty($vars['attachments'])) {
            foreach($vars['attachments'] as $key => $file) {
              $message->attach($file, ['as' => $key]);
            }
          }
        });
      }
      if($query) {
        Flash::success('Вы успешно заказали!');
      } else {
        Flash::error('Произошла ошибка!');
      }*/
    }
  }

  public function getProductsIds($products)
  {
    $ids = [];
    foreach($products as $product) {
      array_push($ids, $product->id);
    }
    return $ids;
  }

  public function getFilesPath($ids) {
    $files = [];
    $query = Product::whereIn('id', $ids)->get();
    foreach($query as $product) {
      if(isset($product->file) && !empty($product->file)) {
        $files[$product->file['title']] = $product->file['path'];
      }
    }
    return $files;
  }

  public function convertString($string)
  {
    return trim(str_replace('/storage/app/media', '', stripcslashes($string)), '"');
  }
}
