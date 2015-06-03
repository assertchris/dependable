<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repository extends Model
{
    /**
     * @var string
     */
    protected $table = "repository";

    /**
     * @var array
     */
    protected $fillable = [
        "label",
        "github_name",
        "is_active",
        "developer_id",
    ];

    /**
     * @return BelongsTo
     */
    public function developer()
    {
        return $this->belongsTo(
            Developer::class, "developer_id"
        );
    }
}
