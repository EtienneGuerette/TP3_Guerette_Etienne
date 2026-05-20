<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Exceptions\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Illuminate\Database\QueryException;
use Exception;
use App\Repository\UserRepositoryInterface;
use App\Http\Requests\PasswordRequest;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(SignupRequest $request)
    {
        try {
            $credentials = $request->validated();

            $user = User::create($credentials);

            $user['password'] = bcrypt($user['password']);

            if (Auth::attempt($credentials)) {
                return (response()->json(['user_token' => $user->createToken('UserToken')->plainTextToken]))->setStatusCode(CREATED);
            }
        } catch (QueryException $ex) {
            abort(INVALID_DATA, "Invalid data");
        } catch (Exception $ex) {
            abort(SERVER_ERROR, "Server error");
        }
    }

    public function login(SigninRequest $request)
    {
        try {
            if (!Auth::attempt($request->validated())) {
                throw new AuthorizationException;
            }

            $user = Auth::user();
            $token = $user->createToken('UserToken');
            return (response()->json(['user_token' => $token->plainTextToken]))->setStatusCode(OK);
        } catch (AuthorizationException $ex) {
            abort($ex->status(), $ex->message());
        } catch (QueryException $ex) {
            abort(INVALID_DATA, "Invalid data");
        } catch (Exception $ex) {
            abort(SERVER_ERROR, "Server error");
        }
    }

    public function me()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                return (response()->json($user))->setStatusCode(OK);
            }
        } catch (QueryException $ex) {
            abort(UNAUTHORIZED, "Unauthorized");
        } catch (Exception $ex) {
            abort(SERVER_ERROR, "Server error");
        }
    }

    public function refresh()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $user->currentAccessToken()->delete();
                $token = $user->createToken('UserToken');
                return (response()->json(['user_token' => $token->plainTextToken]))->setStatusCode(OK);
            }
        } catch (QueryException $ex) {
            abort(UNAUTHORIZED, "unauthorized");
        } catch (Exception $ex) {
            abort(SERVER_ERROR, "Server error");
        }
    }

    public function logout()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $user->tokens()->delete();
                return response()->noContent()->setStatusCode(NO_CONTENT);
            }
        } catch (QueryException $ex) {
            abort(UNAUTHORIZED, "unauthorized");
        } catch (Exception $ex) {
            abort(SERVER_ERROR, "Server error");
        }
    }

    public function password(PasswordRequest $request)
    {
        try {
            $this->userRepository->changePassword($request->validated()['new_password']);
            return response()->noContent()->setStatusCode(NO_CONTENT);
        }
        catch (Exception $ex) {
            abort(SERVER_ERROR, "Server error");
        }
    }
}
