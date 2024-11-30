<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = ['disabilities', 'medical_history', 'test_results'];

    // Define accessor and mutator for encrypted fields

    // Encrypt disabilities before saving to the database
    public function setDisabilitiesAttribute($value)
    {
        $this->attributes['disabilities'] = Crypt::encryptString($value);
    }

    // Encrypt medical_history before saving to the database
    public function setMedicalHistoryAttribute($value)
    {
        $this->attributes['medical_history'] = Crypt::encryptString($value);
    }

    // Encrypt test_results before saving to the database
    public function setTestResultsAttribute($value)
    {
        $this->attributes['test_results'] = Crypt::encryptString($value);
    }

    // Decrypt disabilities when retrieving from the database
    public function getDisabilitiesAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Decrypt medical_history when retrieving from the database
    public function getMedicalHistoryAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Decrypt test_results when retrieving from the database
    public function getTestResultsAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}