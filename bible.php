<?php
namespace JELCKama\Liturgical;
require __DIR__ . "/vendor/autoload.php";
use JELCKama\Liturgical\LitId;

class BibleBook {
  public readonly LitId $id;
  public readonly string $name;
  public readonly string $abbr1;
  public readonly string $abbr2;
  public function __construct(LitId $id, string $name, string $abbr1, string $abbr2) {
    $this->id = $id;
    $this->name = $name;
    $this->abbr1 = $abbr1;
    $this->abbr2 = $abbr2;
  }
  public static function fromArray(array $data): BibleBook {
    return new BibleBook(
      new LitId($data["id"]),
      $data["name"],
      $data["abbr1"],
      $data["abbr2"]
    );
  }
  public static function fromCsv(string $csv): array {
    $lines = explode("\n", $csv);
    $books = [];
    foreach($lines as $line) {
      $data = str_getcsv($line);
      if(count($data) < 4) continue;
      $books[] = self::fromArray([
        "id" => $data[0],
        "name" => $data[1],
        "abbr1" => $data[2],
        "abbr2" => $data[3]
      ]);
    }
    return $books;
  }
}

?>