<?php

namespace Controller;

use Model\Appointments;
use Model\User;
use Model\Diagnoses;
use Src\View;
use Src\Request;
use Src\Validator\Validator;
use function Collect\collection;

class Doctor
{
    public function doctorAppointments(Request $request): string
    {
        if ($request->method === 'GET') {
            $appointments = Appointments::all()->sortBy('date');

            if (!empty($_GET['search_patient'])) {
                $q = $request->get('search_patient');
                if (!empty($q)) {
                    $appointments = Appointments::whereIn('patient_id', User::select('id')->where('firstname', 'like', "%$q%")->orWhere('lastname', 'like', "%$q%"))->get()->sortBy('date');
                } else {
                    $appointments = [];
                }
            }
            if (!empty($_GET['search_date'])) {
                $q = $request->get('search_date');
                $appointments = Appointments::where('date', $q)->get()->sortBy('date');
            }
        }
        return (new View())->render('site.doctorAppointments', ['appointments' => $appointments]);
    }

    public function diagnosis(Request $request): string
    {
        if ($request->method === 'GET') {
            if (!empty($_GET['search'])) {
                $q = $request->get('search');
                $diagnosis = Diagnoses::where('title', 'like', "%$q%")->get()->sortBy('title');
                return (new View())->render('site.diagnosis', ['diagnosis' => $diagnosis]);
            } else {
                $diagnosis = Diagnoses::all()->sortBy('title');
                return (new View())->render('site.diagnosis', ['diagnosis' => $diagnosis]);
            }
        }
    }

    public function updateDiagnosis(Request $request): string
    {
        $id = $request->get('id');
        $diagnosis = Diagnoses::all();
        $form = Appointments::where('id', $id)->first();
        $patient = User::where('id', $form['patient_id'])->first();
        if ($request->method === 'GET') {
            return new View('site.update_diagnosis', ['form' => $form, 'patient' => $patient, 'diagnosis' => $diagnosis]);
        }

        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'diagnosis' => ['required']
            ], [
                'required' => 'Поле: field пусто',
            ]);

            if ($validator->fails()) {
                return new View('site.update_diagnosis',
                    ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE), 'form' => $form, 'patient' => $patient, 'diagnosis' => $diagnosis]);
            }
            $form = Appointments::where('id', $id)->first();
            $form->diagnosis = $request->get('diagnosis');
            $form->save();
            app()->route->redirect('/appointmentsd');

        }

    }

}