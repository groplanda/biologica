<?php namespace Acme\Settings\Components;


use Input;
use Validator;
use ValidationException;
use Flash;
use System\Models\File;
use Acme\Settings\Models\Feedback;
use Mail;
use Backend\Models\User;

class feedbackForm extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Форма для отзывов',
            'description' => 'Добавить форму для отзывов'
        ];
    }

    // получение email админа
    public function getUserMail() 
    {
        return User::where('is_superuser', 1)->value('email');
    }


    public function onSaveFeedback()
    {

        //валидация формы
        $rules = [
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'message' => 'required|min:10',
            'rating'  => 'required|min:1|max:5',
            'avatar'  => 'mimes:jpeg,bmp,png|file|max:512'
        ];

        //сообщения об ошибках
        $messages = [                
            'name.required' => 'Пожалуйста, заполните имя',       
            'name.min' => 'Какое то короткое имя...',  
            'email.required' => 'E-mail обязателен!',
            'email.email' => 'E-mail некорректный!',
            'message.required' => 'Напишите текст отзыва!',
            'message.min' => 'Текст не менее 10 символов',
            'rating.required' => 'Поставьте оценку!',
            'avatar.mimes' => 'Недопустимый формат!',
            'avatar.max' => 'Размер не более :max кб.'
        ];

        //валидация проверка
        $validator = Validator::make(Input::all(), $rules, $messages);


        if ($validator->fails()) {

            throw new ValidationException($validator);

        }

        //переменные
        $name = Input::get('name');
        $email = Input::get('email');
        $message = Input::get('message');
        $stars = Input::get('rating');

        //вставка отзыва в базу данных
        $feedback = new Feedback();

        $feedback->name = $name;
        $feedback->email = $email;
        $feedback->rewiew = $message;
        $feedback->rating = $stars;
        $feedback->time = time();

        //прикрепление файла
        if (Input::hasFile('avatar')) {
            $feedback->avatar = Input::file('avatar');
        }

        $result = $feedback->save();

        if($result) {
            Flash::success('Отзыв успешно добавлен!');
        } else {
            Flash::error('Произошла ошибка!');
        }

        //отправка сообщения на почту
        $vars = [
            'name' => $name, 
            'mail' => $email,
            'stars' => $stars,
            'content_message' => $message,
        ];

        Mail::send('acme.settings::mail.message', $vars, function($message) {

            $message->to($this->getUserMail(), 'Admin Person');
            $message->subject('Добавлен новый отзыв');
        
        });

    }

}