<?php
$email = '';
$name = $this->faker->lastName();
$prename = $this->faker->unique()->firstName();

$i = $this->faker->numberBetween($min = 0, $max = 6);
if ($i == 0) {
  $email = "$name$prename";
} elseif ($i == 1) {
  $email = "$prename.$name";
} elseif ($i == 2) {
  $email = "$name.$prename";
} elseif ($i == 3) {
  $email = "$prename$name";
} elseif ($i == 4) {
  $email = $name . '_' . $prename;
} elseif ($i == 5) {
  $email = $prename . '_' . $name;
} else {
  $email = $this->faker->userName();
}
$email = fncNormalizeString($email);
$email = $email . '@' . $this->faker->freeEmailDomain();
