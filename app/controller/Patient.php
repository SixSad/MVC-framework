<?php

namespace Controller;

use Model\Appointments;
use Model\User;
use Src\View;
use Src\Request;
use Src\Validator\Validator;

class Patient
{
    public function patientAppointments(Request $request): string
    {
        $appointments = Appointments::all()->sortBy('date');

        if (!empty($_GET['search_patient'])) {
            $q = $request->get('search_patient');
            if (!empty($q)) {
                $appointments = Appointments::whereIn('doctor_id', User::select('id')->where('firstname', 'like', "%$q%")->orWhere('lastname', 'like', "%$q%"))->get()->sortBy('date');
            } else {
                $appointments = [];
            }
        }

        if (!empty($_GET['search_date'])) {
            $q = $request->get('search_date');
            $appointments = Appointments::where('date', $q)->get()->sortBy('-date');
        }

        if ($request->method === 'POST') {
            return app()->route->redirect('/error403');
        }

        return (new View())->render('site.patientAppointments', ['appointments' => $appointments]);
    }

    public function appointmentsCreate(Request $request): string
    {
        $doctors = User::where('role_id', '2')->get();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'date' => ['date'],
                'doctor_id' => ['required']
            ], [
                'required' => 'Поле: field пусто',
                'date' => 'Поле: введите корректную дату',

            ]);

            if ($validator->fails()) {
                return new View('site.new_appointment',
                    ['message' => '<h5 class="text-danger">'.json_encode($validator->errors(), JSON_UNESCAPED_UNICODE).'</h5>', 'doctors' => $doctors]);
            }

            if (Appointments::create($request->all())) {
                return new View('site.new_appointment',
                    ['message' => "<h5 class='text-success'>Вы записались на прием</h5>", 'doctors' => $doctors]);
            }
        }

        return (new View())->render('site.new_appointment', ['doctors' => $doctors]);
    }
}