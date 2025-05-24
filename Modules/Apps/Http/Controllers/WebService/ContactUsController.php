<?php

namespace Modules\Apps\Http\Controllers\WebService;

use Notification;
use Illuminate\Http\Request;
use Modules\Apps\Http\Requests\FrontEnd\ContactUsRequest;
use Modules\Apps\Notifications\FrontEnd\ContactUsNotification;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;

class ContactUsController extends WebServiceController
{
    public function send(ContactUsRequest $request)
    {
        Notification::route('mail', config('setting.contact_us.email'))
        ->notify((new ContactUsNotification($request))->locale(locale()));

        return $this->response([]);
    }
}
