<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class OauthAccessTokens extends Model
{
    protected $table = 'oauth_access_tokens';
    protected $guarded = ['id'];
}
