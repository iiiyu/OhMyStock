<?php

namespace App\Admin\Controllers;

// use Dcat\Admin\Admin;
// use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
// use Dcat\Admin\Models\Repositories\Administrator;
use Dcat\Admin\Traits\HasFormResponse;
// use Illuminate\Auth\GuardHelpers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use Illuminate\Support\Facades\Lang;
// use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Models\Repositories\Administrator;

class RegisterController extends Controller
{
    use HasFormResponse;


    protected $redirectTo;

    public function show(Content $content)
    {
        return $content->full()->body(view('admin.pages.register'));
    }

    public function register(Request $request)
    {
        $credentials = $request->only([$this->username(), 'password']);

        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($credentials, [
            $this->username()   => 'required',
            'password'          => 'required',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorsResponse($validator);
        }


        try {
            DB::beginTransaction();
            AdministratorModel::create([
                'username'   => $credentials['username'],
                'password'   => bcrypt($credentials['password']),
                'name'       => $credentials['username'],
            ]);
            DB::commit();
            return $this->sendRegisterResponse($request);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->validationErrorsResponse([
                $this->username() => '注册失败',
            ]);
            throw $exception;
        }
    }



    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }


    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        return $this->redirectTo ?: admin_url('/');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendRegisterResponse(Request $request)
    {
        $request->session()->regenerate();

        return $this->redirectToIntended(
            $this->redirectPath(),
            trans('login.register_successful')
        );
    }
}
