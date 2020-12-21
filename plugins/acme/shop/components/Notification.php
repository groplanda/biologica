<?php namespace Acme\Shop\Components;

use Cms\Classes\ComponentBase;

use Acme\Shop\Models\Order;
use Acme\Shop\Models\Product;

use Illuminate\Support\Facades\Log;

use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;
use YooKassa\Client;

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
        $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
          ? new NotificationSucceeded($requestBody)
          : new NotificationWaitingForCapture($requestBody);
      } catch (Exception $e) {
        Log::error($e);
      }
      $payment = $notification->getObject();
      Log::info($payment);
    }
  }
}
