<?php

namespace App\Models;

use Illuminate\Auth;
use Illuminate\Contracts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Developer extends Model implements
    Contracts\Auth\Authenticatable,
    Contracts\Auth\CanResetPassword
{
    use Auth\Authenticatable;
    use Auth\Passwords\CanResetPassword;

    /**
     * @var string
     */
    protected $table = "developer";

    /**
     * @var array
     */
    protected $fillable = [
        "github_id",
        "github_nickname",
        "github_name",
        "github_email",
        "github_avatar",
    ];

    /**
     * @return HasMany
     */
    public function repositories()
    {
        return $this->hasMany(
            Repository::class, "developer_id"
        );
    }

    /**
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->github_email;
    }
}
