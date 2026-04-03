use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\CommentController;

Route::prefix('v1')->group(function () {

    //  Tickets
    Route::apiResource('tickets', TicketController::class);

    //  Comments
    Route::post('tickets/{ticket}/comments', [CommentController::class, 'store']);
});