<?php namespace Acme\Shop\Components;

use Cms\Classes\ComponentBase;

use Acme\Shop\Models\Order;
use Acme\Shop\Models\Product;

use Mail;
use System\Models\File;
use Illuminate\Support\Facades\Log;

use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class Notification extends ComponentBase
{

  public function componentDetails()
  {
      return [
          'name' => 'Yandex notification',
          'description' => 'Yandex notification'
      ];
  }

  public function onRun()
  {
    $this->prepareVars();
  }

  public function prepareVars()
  {
    $source = file_get_contents('php://input');
    if($source) {
      $requestBody = json_decode($source, true);
      try {
        $notification = null;
        if($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED) { // если оплачен
          Log::info($requestBody['object']);
          $this->sendOrderAttachments($requestBody['object']['id']);
        }
      } catch (Exception $e) {
        Log::error($e);
      }
    }
  }

  private function sendOrderAttachments($id) {
    $order = $this->getOrderById($id);
    $ids = $this->getProductsIds($order->products);
    $files = $this->getFilesPath($ids);
    $vars = [
      'name' => $order->name,
      'user_name' => $order->user_name,
      'user_email' => $order->user_email,
      'attachments' => $files,
    ];
    $this->updateStatus($order->id);
    if(isset($files) && !empty($files)) {
      Mail::send('acme.shop::mail.success', $vars, function($message) use ($vars) {
        $message->to(trim($vars['user_email']), 'Admin Person');
        $message->subject('Подтверждение оплаты - '.$vars['name']);
        if(!empty($vars['attachments'])) {
          foreach($vars['attachments'] as $key => $file) {
            $message->attach($file, ['as' => $key]);
          }
        }
      });
    }
  }
  // получим заказ по id yandex
  private function getOrderById($id)
  {
    return Order::where('order_id', $id)->first();
  }
  // получим id товаров из заказа в виде массива
  private function getProductsIds($products)
  {
    $ids = [];
    foreach($products as $product) {
      array_push($ids, $product['id']);
    }
    return $ids;
  }
  // получим пути документов в виде массива
  private function getFilesPath($ids) {
    $files = [];
    $query = Product::whereIn('id', $ids)->get();
    foreach($query as $product) {
      if(isset($product->file) && !empty($product->file)) {
        $path = $product->file['path'];
        $files[$product->file['title'].'.'.pathinfo($path, PATHINFO_EXTENSION)] = $path;
      }
    }
    return $files;
  }
  // обновим статус заказа
  private function updateStatus($id) {
    $order = Order::find($id);
    $order->status = 'pay';
    $order->save();
  }
}
