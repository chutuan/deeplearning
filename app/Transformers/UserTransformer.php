<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{
    protected $avatarWidth = 52;
    protected $avatarHeight = 52;

    public function transform(User $user)
    {
        return [
             'id'      => (int) $user->id,
             'first_name'   => $user->first_name,
             'last_name' => $user->last_name,
             'email' => $user->email,
             'access_token' => $user->access_token,
             'email_confirmed' => $user->email_confirmed,
             'role' => (int) $user->role,
             'avatar' => $this->getAvatar($user),
             'created_at' => $user->created_at->format('c'),
             'updated_at' => $user->updated_at->format('c')
         ];
    }

        // Attributes
    public function getAvatar(User $user)
    {
        // Get Facebook Avatar
        if(empty($user->avatar) && !empty($user->facebook_id))
        {
            return "https://graph.facebook.com/{$user->facebook_id}/picture?type=large&width={$this->avatarWidth}&height={$this->avatarHeight}";
        }else
        {
            if(empty($user->avatar))
            {
                $image = "/avatars/default.png";
                $path = '/avatars/' . md5('avatar') . '_medium.png';
            }else
            {
                $image = \Auth::user()->avatar;
                $path = '/avatars/' . md5(\Auth::user()->id) . '_medium.png';
            }
            if(!file_exists(public_path($path)))
            {
                \Image::make(public_path($image))->resize(52, 52)
                    ->save(public_path($path));
            }
            $user->avatar = asset($path);
        }

        return $user->avatar;
    }
}