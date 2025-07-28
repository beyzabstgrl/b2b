<?php
namespace App\Repository;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository {
    protected $modelName = User::class;



}
