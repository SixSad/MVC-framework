<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Src\Files\FileUploadInterface;

class User extends Model implements IdentityInterface, FileUploadInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'username',
        'password',
        'firstname',
        'lastname',
        'birth_date',
        'role_id'
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where(['username' => $credentials['username'],
            'password' => md5($credentials['password'])])->first();
    }

    public function getUploadFile($file): string
    {
        return $_FILES["$file"]['name'];
    }

    public function getUploadTempFile($file): string{
        return $_FILES["$file"]['tmp_name'];
    }

    public function getUploadPath($file,$path): string {
        return "..".$path . "/".$this->getUploadFile($file);
}
    public function getTemplate($file,$path): string {
        return $path."/".$this->getUploadFile($file);
    }

    public function saveFromTemp($file,$path){
        return move_uploaded_file($this->getUploadTempFile($file), $this->getUploadPath($file,$path));
}

}
