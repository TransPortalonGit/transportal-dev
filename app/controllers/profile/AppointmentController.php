<?php
namespace Profile;
use Illuminate\Support\Facades\Mail;
use View;
use Input;
use Redirect;
use Appointment;
use Equipment;
use DateTime;
use DateInterval;
use Validator;

class AppointmentController extends \BaseController {
    public function get_index()	{
        if(!\Sentry::check()) return \Redirect::to('/account/login');

        $currentuser = \Sentry::getUser();
        $username = $currentuser->username;
        $appointments = Appointment::get(array('title','start','end','id','item_id', 'user_id', 'color'))->toJson();
        $userAppointments = Appointment::where('user_id', '=', $currentuser->id)->orderBy('start')->get()->toArray();
        $equips_list = \Machine::lists('name','id');
        $machines = \Machine::all();
        $users = \User::all();
        $date = new DateTime();
        //$week = array("year" => $date->format('Y'),"month" => $date->format('m'), "date" => $date->format('d'));
        $week = (new DateTime())->format('Y-m-d');
        //dd($week);

        $userID = $currentuser->id;
        $appointmentsOfUser = (Appointment::where('user_id','=',$userID)->where('start','>',(new DateTime())->format('Y-m-d H:i:s'))->orderBy('start')->get(array('start'))->toArray());
        //dd($appointmentsOfUser);

        return View::make('site/profile/appointments/index')
            ->with('user', \Sentry::getUser())
            ->with('username', $username)
            ->with('appointments', $appointments)
            ->with('equips_list', $equips_list)
            ->with('machines',$machines)
            ->with('users', $users)
            ->with('userAppointments', $userAppointments)
            ->with('week', $week);
    }

    public function submit() {
        if(!\Sentry::check()) return \Redirect::to('/account/login');

        $currentuser = \Sentry::getUser();
        $userID = $currentuser->id;
        $switchToDate = null;
        $validator = Validator::make(
            Input::all(),
            array(
                'start_time' => 'required',
                'duration' => 'required',
                'machine' => 'required'
            )
        );

        if ($validator->passes()) {

            $appointment = new Appointment;

            $appointment->user_id = $userID;
            $appointment->item_id = Input::get('machine');
            $appointment->title = Input::get('title');
            $appointment->start = Input::get('start_time');
            $date = new DateTime(Input::get('start_time'));
            $appointment->end = $date->add(new DateInterval('PT'.Input::get("duration").'M'));
            $machine = \Machine::find(Input::get('machine'));
            $appointment->color = $machine->color;
            //dd((new DateTime(Input::get('start_time')))->format('Y-m-d'));
            $week = (new DateTime(Input::get('start_time')))->format('Y-m-d');
            //dd($week);
            //$week = array("year" => $date->format('Y'),"month" => $date->format('m'), "date" => $date->format('d'));


            $events = Appointment::where('item_id','=', Input::get('machine'))->get();
            foreach ($events as $event) {
                $start1 = strtotime($event->start);
                $end1 = strtotime($event->end);
                $start2 = strtotime($appointment->start);
                $end2 = strtotime($appointment->end->format('Y/m/d H:i'));
                if ($start1 < $end2 && $end1 > $start2){
                    $user = \User::where('id','=',$event->user_id)->get()->last();
                    $firstname = $user->first_name;
                    $lastname = $user->last_name;
                    $startTime = (new DateTime($event->start))->format('H:i');
                    $endTime = (new DateTime($event->end))->format('H:i \o\n l jS F');
                    return Redirect::to('profile/appointments')
                        ->with('messageAlert', 'The machine is already reserved by '.$firstname.' '.$lastname.' from '.$startTime." to ".$endTime.'. Please choose another time')
                        ->with('switchToDate', $switchToDate)
                        ->with('week', $week);
                }
            }

            $events = Appointment::where('item_id','=', 4)->get();
            foreach ($events as $event) {
                $start1 = strtotime($event->start);
                $end1 = strtotime($event->end);
                $start2 = strtotime($appointment->start);
                $end2 = strtotime($appointment->end->format('Y/m/d H:i'));
                if ($start1 < $end2 && $end1 > $start2){
                    $startTime = (new DateTime($event->start))->format('H:i');
                    $endTime = (new DateTime($event->end))->format('H:i \o\n l jS F');
                    return Redirect::to('profile/appointments')
                        ->with('messageAlert', "An event takes place from ".$startTime." to ".$endTime.". Please choose another time")
                        ->with('switchToDate', $switchToDate)
                        ->with('week', $week);
                }
            }

            $appointment->save();

            //Notify all Admins

            $appointmentsOfUser = count(Appointment::where('user_id','=',$userID)->where('start','>',(new DateTime())->format('Y-m-d H:i:s'))->get()->toArray());
            $threshold = 15;
            $admins = \Sentry::findAllUsersWithAccess('admin');
            //dd(Appointment::where('user_id','=',$userID)->where('start','>',(new DateTime())->format('Y-m-d H:i:s'))->orderBy('created_at')->get(array('start'))->toArray());
            //dd($appointmentsOfUser);
            if($appointmentsOfUser == $threshold){
                foreach($admins as $admin)
                {
                    $data = array('threshold' => $threshold, 'email' => $admin['email'], 'admin' => $admin['username'], 'user' => \User::find($userID)->username);

                    Mail::send('site/profile/emails/tooManyAppointments', $data, function($message) use ($data)
                    {
                        $message->to($data['email'], $data['admin'])
                            ->subject('A User submitted too many Appointments!');
                    });
                }
            }

            return Redirect::to('profile/appointments')
                ->with('messageConfirm', 'You successfully added an appointment!')->with('switchToDate', $switchToDate);
			} else {
				return Redirect::to('profile/appointments')
					->withErrors($validator)
					->with('switchToDate', $switchToDate)
                    ->with('week', $week);
			}       
		}
    
    public function del() {
        if(!\Sentry::check()) return \Redirect::to('/account/login');
        
		$currentuser = \Sentry::getUser();
		$userID = $currentuser->id;
        
		$appointment = Appointment::find(Input::get('id'));
        //dd(\User::find($appointment->user_id)->username);
        
		if ($appointment->user_id == $userID) {
			$appointment->delete();
			
			return Redirect::to('profile/appointments')
            ->with('messageAlert','You successfully deleted an appointment!');
			
		} else if(\Sentry::user()->hasAccess('admin')) {
			
			$data = array('user' => \User::find($appointment->user_id)->username, 'email' => \User::find($appointment->user_id)->email, 'admin' => \User::find($userID)->username, 'start' => $appointment->start, 'end' => $appointment->end, 'machine' => \Machine::find($appointment->item_id)->name);
           
			Mail::send('site/profile/emails/appointmentDeleted', $data, function($message) use ($data)
				{
                    $message->to($data['email'], $data['admin'])
							->subject('Your Appointment was deleted was deleted by an Admin!');
                });
				
			$appointment->delete();
			
            return Redirect::to('profile/appointments')
                ->with('messageAlert','You successfully deleted the appointment! The User will be notified.');
		} else {
			
			return Redirect::to('profile/appointments')
                ->with('messageAlert','You can not delete an appointment of another user!');
		}
    }
	
	public function filter() {

        if(!\Sentry::check()) return \Redirect::to('/account/login');
    
		$currentuser = \Sentry::getUser();
		$username = $currentuser->username;
		$machines = \Machine::all();
		$input = array_values(Input::all());
		$appointments = array();
        $userAppointments = Appointment::where('user_id', '=', $currentuser->id)->orderBy('start')->get()->toArray();
		$equips_list = \Machine::lists('name','id');
        $users = \User::all();
		
		for($i=1; $i < count($input); $i++) {
            $machineArray = \Machine::where("type","=",$input[$i])->get()->toArray();
            
            for($j=0; $j < count($machineArray); $j++) {
                $appointment = Appointment::where("item_id","=", $machineArray[$j]['id'])->get()->toArray();
                $appointments = array_merge_recursive ($appointments, $appointment);
            }
		}
		// Always show Private Circle
		$appointments = array_merge_recursive ($appointments, Appointment::where("item_id","=", 4 )->get()->toArray());
		$appointments = json_encode($appointments);
		
		Input::flash();
		
	    return View::make('site/profile/appointments/index')
			   	->with('user', \Sentry::getUser())
			   	->with('username', $username)	 
                ->with('appointments', $appointments)
				->with('equips_list', $equips_list)
				->with('machines', $machines)
                ->with('users', $users)
                ->with('userAppointments', $userAppointments);
	}
}