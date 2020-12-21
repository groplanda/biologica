<?php namespace Acme\Shop\Controllers;

use Illuminate\Routing\Controller;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\NotificationEventType;

class Checkouts extends Controller
{
  public function index()
  {
    $source = file_get_contents('php://input');
    $requestBody = json_decode($source, true);

    try {
      $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
        ? new NotificationSucceeded($requestBody)
        : new NotificationWaitingForCapture($requestBody);
    } catch (Exception $e) {
        // Обработка ошибок при неверных данных
    }

    $payment = $notification->getObject();
    dump($payment);
  }
}