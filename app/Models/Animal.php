// app/Models/Animal.php
namespace App\Models;

use Illuminate\Database\Elequent\Model;

class Animal extends Model
{
    protected $table = 'animals';
    protected $guarded = ['name', 'species', 'breed', 'age', 'image', 'location', 'sex']; // Everything but status

    public function scopeAvailable($query)
    {
        return $query->whereRaw('LOWER(TRIM(status)) = ?', ['available']);
    }

}