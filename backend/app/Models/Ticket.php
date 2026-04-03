<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'user_id',
        'assigned_to'
    ];

    //  Creator (utente che crea ticket)
   

    public function user()
{
    return $this->belongsTo(User::class);
}

    //  Agent assegnato
    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    //  Commentipublic function comments()
    public function comments()
{
    return $this->hasMany(Comment::class);
}


    //  Helper status (molto utili dopo)
    public function isOpen()
    {
        return $this->status === 'open';
    }

    public function isResolved()
    {
        return $this->status === 'resolved';
    }
}