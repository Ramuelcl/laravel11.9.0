<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = User::class;
  protected $table = 'users';

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $filePath = 'public/images/avatars';
    Storage::deleteDirectory($filePath);

    // genera el nombre, prenombre y de ESTOS el eMail
    $filePath2 = database_path('factories\\include_email.php');
    include($filePath2);
    dump(['filePath' => $filePath, 'email' => $email]);

    $avatar = $this->faker->imageUrl(640, 480, null, false);

    return [
      'name' => $name . " " . $prename,
      // 'prename' => $prename,
      'email' => $email,
      'email_verified_at' => now(),
      'profile_photo_path' => $avatar,

      'is_active' => $this->faker->boolean(),
      'password' => Hash::make('password'),
      // 'password' => 'password', // setPasswordAttribute
      // 'password' => static::$password ??= Hash::make('password'),

      'remember_token' => Str::random(10),
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
  public function unverified()
  {
    return $this->state(function (array $attributes) {
      return [
        'email_verified_at' => null,
      ];
    });
  }
}
