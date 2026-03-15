<?php
namespace JELCKama\Liturgical;

require __DIR__ . "/vendor/autoload.php";

class LitId {
  public readonly string $id;
  public const ID_REGEX = "/^[a-zA-Z0-9_-]+$/";
  public function __construct(string $id) {
    $this->id = self::validate($id);
  }
  public static function validate(string $id): string {
    if(preg_match(self::ID_REGEX, $id)) {
      return $id;
    } else {
      throw new \InvalidArgumentException("Invalid ID format");
    }
  }
}
?>  