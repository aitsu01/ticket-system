<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message'
    ];

    //  Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    //  Autore commento
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}