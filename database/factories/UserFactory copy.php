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

    // $path=public_path('avatars');
    // $path2=storage_path();
    // $path2=public_path().'\\images\\';
    // $avatar= $this->faker->image($path, 640, 480, null, false);

    // $avatar = $this->faker->image(
    //     $dir = Storage::path($filePath),
    //     $width = 640,
    //     $height = 480,
    //     $category = getIniciales($prename . ' ' . $name), /* usado como texto sobre la imagen,default null */
    //     $fullPath = true,
    //     $randomize = true, // it's a no randomize images (default: `true`)
    //     $word = null, //it's a filename without path
    //     $gray = false,
    //     $format = 'png'
    // );

    $avatar = $this->faker->imageUrl(640, 480, null, false);

    // dd($avatar, $avatar1, public_path('avatars'));
    // echo($avatar);
    // TODO: registrar foto en directorio, no se queda, se borra sola inmediatamente
    return [
      'name' => $name . " " . $prename,
      // 'prename' => $prename,
      'email' => $email,
      'email_verified_at' => now(),
      'profile_photo_path' => $avatar,

      'is_active' => $this->faker->boolean(),
      // 'password' => Hash::make('password'),
      'password' => 'password', // setPasswordAttribute
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

  /**
   * Indicate that the user should have a personal team.
   *
   * @return $this
   */
  public function withPersonalTeam()
  {
    if (!Features::hasTeamFeatures()) {
      return $this->state([]);
    }

    return $this->has(
      Team::factory()
        ->state(function (array $attributes, User $user) {
          return ['name' => $user->name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true];
        }),
      'ownedTeams'
    );
  }
}
