<?php

namespace App\Http\Controllers\Auth;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Auth\Signup as Request;
use App\Jobs\Auth\DeleteInvitation;
use App\Models\Auth\UserInvitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Jobs\Auth\CreateUser;
use App\Jobs\Common\CreateCompany;

class Signup extends Controller
{
    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('auth.signup.create', ['token' => '']);
    }

    public function store(Request $request)
    {
        dd(['aa' => 'ddd']);
        return '';
    }

    public function store1(Request $request)
    {
        // $invitation = UserInvitation::token($request->get('token'))->first();

        // if (!$invitation) {
        //     abort(403);
        // }
        dd($request);

        DB::transaction(function () use ($request) {
            $locale = session('locale') ?? config('app.locale');

            // Create company
            $this->createCompany($request->get('company_name'), $request->get('company_email'), $locale);

            $company_id = company()?->id;
            // Create user
            $this->createUser($request->get('user_email'), $request->get('password'), $company_id, $locale);
        });

        $user = user();

        // $this->dispatch(new DeleteInvitation($invitation));
        $this->guard()->login($user);
        $message = trans('messages.success.connected', ['type' => trans_choice('general.users', 1)]);

        flash($message)->success();

        return response()->json([
            'redirect' => url($this->redirectPath()),
        ]);
        // event(new Registered($user));

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $user->forceFill([
            'password' => $request->password,
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);

        $message = trans('messages.success.connected', ['type' => trans_choice('general.users', 1)]);

        flash($message)->success();

        return response()->json([
            'redirect' => url($this->redirectPath()),
        ]);
    }

    public function createCompany($name, $email, $locale)
    {
        dispatch_sync(new CreateCompany([
            'name' => $name,
            'domain' => '',
            'email' => $email,
            'currency' => 'USD',
            'locale' => $locale,
            'enabled' => '1',
        ]));
    }

    public function createUser($email, $password, $company, $locale)
    {
        dispatch_sync(new CreateUser([
            'name' => '',
            'email' => $email,
            'password' => $password,
            'locale' => $locale,
            'companies' => [$company],
            'roles' => ['1'],
            'enabled' => '1',
        ]));
    }
}
