<?php
namespace Controller;

use Model\Appointments;
use Model\User;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;

class Patient
{
    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }

    public function profile(): string
    {
        return new View('site.profile');
    }

    public function patientAppointments(Request $request): string
    {
        $user = app()->auth::user()->id;
        if ($request->method === 'GET') {
            $appointments = Appointments::where('patient_id', $user)->get();
            if (!empty($_GET['search_patient'])) {
                $q = $request->get('search_patient');
                $user = User::where(['firstname' => $q], ['lastname' => $q])->first();
                if (!empty($user)) {
                    $appointments = Appointments::where('patient_id', $user['id'])->get();
                } else {
                    $appointments = [];
                }
            }
            if (!empty($_GET['search_date'])) {
                $q = $request->get('search_date');
                $appointments = Appointments::where('date', $q)->get();
            }
            return (new View())->render('site.patientAppointments', ['appointments' => $appointments]);
        }
    }

    public function appointmentsCreate(Request $request): string
    {
        $doctors = User::where('role_id', '2')->get();
        if ($request->method === 'GET') {
            return (new View())->render('site.new_appointment', ['doctors' => $doctors]);
        }

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
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'doctors' => $doctors]);
            }

            if (Appointments::create($request->all())) {
                return new View('site.new_appointment',
                    ['message' => "<p class='text-success'>Вы записались на прием</p>", 'doctors' => $doctors]);
            }
        }
    }
}